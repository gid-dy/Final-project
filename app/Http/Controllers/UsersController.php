<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Country;
use Auth;
use Session;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Exports\usersExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DB;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     /**
      * Where to redirect users after registration.
      *
      * @var string
      */
     //protected $redirectTo = '/cart';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function showRegistrationForm(){
        $meta_title ="User Register - GhanaTrek";
        return view('user.register')->with(compact('meta_title'));
    }

    public function register(Request $request){
      //if($request->isMethod('post')){
         $data = $request->all();
         $validator = Validator::make($request->all(), [
            'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'UserEmail' => 'required|email',
            'Mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Password' => 'min:8|required_with:Password_confirmation|same:Password_confirmation',
            'Password_confirmation' =>'min:8',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

         //check if user already exists
         $UserCount = User::where('UserEmail',$data['UserEmail'])->count();
         if($UserCount>0){
             return redirect()->back()->with('flash_message_error', 'Email already exists!');
         }else{
            $user = new User;
            $user->SurName = $data['SurName'];
            $user->OtherNames = $data['OtherNames'];
            $user->UserEmail = $data['UserEmail'];
            $user->Mobile = $data['Mobile'];
            $user->Password = bcrypt($data['Password']);
            $user->save();

            //Send Register Email
            // $UserEmail = $data['UserEmail'];
            // $messageData = ['UserEmail'=>$data['UserEmail'],'SurName'=>$data['SurName']];
            // Mail::send('emails.register', $messageData,function($message) use($UserEmail){
            //     $message->to($UserEmail)->subject('Registration with Ghanatrek');
            // });

            //Send Confirmation Email
            $UserEmail = $data['UserEmail'];
            $messageData = ['UserEmail'=>$data['UserEmail'], 'SurName'=>$data['SurName'], 'code'=>base64_encode($data['UserEmail'])];
            Mail::send('emails.confirmation', $messageData,function($message) use($UserEmail){
                $message->to($UserEmail)->subject('E-mail confirmation');
            });
            return redirect()->back()->with('flash_message_success', 'Confirm your email to activate your account');

            if(Auth::attempt(['UserEmail' => $data['UserEmail'], 'Password' => $data['Password']])){
                Session::put('frontSession', $data['UserEmail']);

                if(!empty(Session::get('Session_id'))){
                    $Session_id = Session::get('Session_id');
                    DB::table('carts')->where('Session_id', $Session_id)->update(['UserEmail'=> $data['UserEmail']]);
                }
                return redirect('/cart');
            }


        }
         //}

    }


     public function showLoginForm(Request $request){
        $meta_title ="User Login - GhanaTrek";
         return view('user.login')->with(compact('meta_title'));
     }

     public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'UserEmail' => 'required|email',
            'Password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->input();
        $user = User::where('UserEmail', $data['UserEmail'])->first();

        if ($user && Hash::check($data['Password'], $user->Password)){
            $users = User::where('UserEmail', $data['UserEmail'])->first();
            if($user->Status == 0){
                return redirect()->back()->with('flash_message_error','Your account is not activated!');
            }
            Session::put('frontSession', $data['UserEmail']);
            Auth::login($user);
            //if($user->Status == 1)

            if(!empty(Session::get('Session_id'))){
                $Session_id = Session::get('Session_id');
                DB::table('carts')->where('Session_id',$Session_id)->update(['UserEmail'=> $data['UserEmail']]);
            }
            return redirect(url('/cart'));
        }else{
            return redirect()->back()->with('flash_message_error','Invalid Username or Password');
        }



     }


     public function forgotPassword(Request $request){
        $meta_title ="Forgot password - GhanaTrek";
         if($request->isMethod('post')){
             $data = $request->all();
             $UserCount = User::where('UserEmail',$data['UserEmail'])->count();
             if($UserCount == 0){
                 return redirect()->back()->with('flash_message_error', 'Email does not exists!');
             }
             $userDetails = User::where('UserEmail', $data['UserEmail'])->first();

             //Generate random password
             $random_password = str_random(8);

             //Encode/ Secure Password
             $new_password = bcrypt($random_password);

             //Update password
             User::where('UserEmail', $data['UserEmail'])->update(['Password'=>$new_password]);

             //Send forgot Password Email Code
             $UserEmail = $data['UserEmail'];
             $SurName =$userDetails->SurName;
             $OtherNames =$userDetails->OtherNames;
             $messageData=[
                 'UserEmail'=>$UserEmail,
                 'SurName'=>$SurName,
                 'OtherNames'=>$OtherNames,
                 'Password'=>$random_password
             ];
             Mail::send('emails.forgotpassword', $messageData, function($message)use($UserEmail){
                 $message->to($UserEmail)->subject('New Password - GhanaTrek');
             });
             return redirect('/login')->with('flash_message_success','Please check your email for new password');
         }
         return view('user.forgot_password')->with(compact('meta_title'));
     }


     public function confirmAccount($UserEmail){
         $UserEmail = base64_decode($UserEmail);
         $UserCount = User::where('UserEmail', $UserEmail)->count();
         if($UserCount>0){
             $userDetails=User::where('UserEmail', $UserEmail)->first();
             if($userDetails->Status == 1){
                 return redirect('/register')->with('flash_message_success','Your Email account is already activated.You can login in now');
             }else{
                 User::where('UserEmail', $UserEmail)->update(['Status'=>1]);

                 //Send Register Email
                $messageData = ['UserEmail'=>$UserEmail,'SurName'=>$userDetails->SurName];
                Mail::send('emails.welcome', $messageData,function($message) use($UserEmail){
                    $message->to($UserEmail)->subject('Welcome to Ghanatrek');
                });
                 return redirect('/register')->with('flash_message_success','Your Email account is activated.You can login in now');
             }
         }else{
             abort(404);
         }
     }

     public function account(Request $request)
     {
        $meta_title ="User Update Account - GhanaTrek";
            $user_id = Auth::user()->id;
            $userDetails = User::find($user_id);
            $countries = Country::get();

            if($request->isMethod('post')){
                $data = $request->all();
                $validator = Validator::make($request->all(), [
                    'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'UserEmail' => 'required|email',
                    'Mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'OtherContact' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'Address'=>'',
                    'City' => 'regex:/^[\pL\s\-]+$/u|max:255',
                    'State' => 'regex:/^[\pL\s\-]+$/u|max:255',
                    'ZipCode' =>'regex:/^([0-9\s\-\+\(\)]*)$/|max:3'

                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if(empty($data['SurName'])){
                    return redirect()->back()->with('flash_message_error', 'Please enter your name');
                }

                if(empty($data['Address'])){
                    $data['Address']='';
                }

                if(empty($data['State'])){
                    $data['State']='';
                }

                if(empty($data['City'])){
                    $data['City']='';
                }
                if(empty($data['ZipCode'])){
                    $data['ZipCode']='';
                }

                if(empty($data['OtherContact'])){
                    $data['OtherContact']='';
                }


                if(empty($data['Country'])){
                    $data['Country']='';
                    }
                $user = User::find($user_id);
                $user->SurName = $data['SurName'];
                $user->OtherNames = $data['OtherNames'];
                $user->UserEmail = $data['UserEmail'];
                $user->Address = $data['Address'];
                $user->Country = $data['Country'];
                $user->City = $data['City'];
                $user->ZipCode = $data['ZipCode'];
                $user->State = $data['State'];
                $user->Mobile = $data['Mobile'];
                $user->OtherContact = $data['OtherContact'];
                $user->save();
                return redirect()->back()->with('flash_message_success', 'Your account details has been successfully updated!');
            }
            return view('user.account')->with(compact('countries','userDetails','meta_title'));

        }


     public function chkUserPassword(Request $request) {
         $data = $request->all();
         //echo "<pre>"; print_r($data); die;
         $current_password =$data['current_pwd'];
         $user_id = Auth::User()->id;
         $check_password = User::where('id',$user_id)->first();
         if(Hash::check($current_password, $check_password->Password)){
             echo "true"; die;
         }else{
             echo "false"; die;
         }

     }

     public function updatePassword(Request $request) {
        $data = $request->all();
        $old_pwd =User::where('id',Auth::User()->id)->first();
        $current_pwd = $data['current_pwd'];
        if(Hash::check($current_pwd,$old_pwd->Password)){
            //update password
            $new_pwd =bcrypt($data['new_pwd']);
            User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
            return redirect()->back()->with('flash_message_success', 'Password updated Successfully!');
        }else{
            return redirect()->back()->with('flash_message_error', 'Current Password is incorrect!');
        }
     }

    public function logout(Request $request) {
        Auth::logout();
        Session::forget('Session_id');
        return redirect(url('/'));
    }

    public function viewUsers(){
        if(Session::get('adminDetails')['Users_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $users = User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }

    public function exportUsers(){
        if(Session::get('adminDetails')['Users_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        return Excel::download(new usersExport, 'users.xlsx');

    }

    public function viewUsersChart(){
        if(Session::get('adminDetails')['Users_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
         $current_month_users =User::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_users =User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
         $last_to_last_month_users =User::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.users.view_users_chart')->with(compact('current_month_users','last_month_users','last_to_last_month_users'));
    }

    public function viewUsersCountriesChart(){
        if(Session::get('adminDetails')['Users_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $getUserCountries = User::select('Country',DB::raw('count(Country) as count'))->groupBy('Country')->get();
        $getUserCountries = json_decode(json_encode($getUserCountries),true);
        // dd($getUserCountries[0]['Country']);
        return view('admin.users.view_users_countries_chart')->with(compact('getUserCountries'));

    }

}
