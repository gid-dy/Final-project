<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Hash;
use App\User;
use App\Booking;
use App\Admin;
use App\Country;
use Illuminate\Support\Facades\Mail;
use Auth;
use DB;
use Carbon\Carbon;
use Validator;

class AdminController extends Controller
{



    public function dashboard()
    {

         $current_month_users =User::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_users =User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
         $last_to_last_month_users =User::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(2))->count();

                                $current_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_to_last_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(2))->count();

        $getUserCountries = User::select('Country',DB::raw('count(Country) as count'))->groupBy('Country')->get();
        $getUserCountries = json_decode(json_encode($getUserCountries),true);
        return view('admin.dashboard')->with(compact('current_month_users','last_month_users','last_to_last_month_users','current_month_booking','last_month_booking','last_to_last_month_booking','getUserCountries'));
    }

    public function settings()
    {
        $adminDetails = Admin::where(['UserEmail'=>Session::get('adminSession')])->first();
        // dd($adminDetails);
        return view('admin.settings')->with(compact('adminDetails'));
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        $adminCount = Admin::where(['UserEmail'=> Session::get('adminSession'),'Password'=>md5($data['current_pwd'])])->count();
        if($adminCount == 1){
            echo "true"; die;
        }else {
            echo "false"; die;
        }
    }

    public function updatePassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $adminCount = Admin::where(['UserEmail'=> Session::get('adminSession'),'Password'=>md5($data['current_pwd'])])->count();
            if($adminCount == 1){
                $Password = md5($data['new_pwd']);
                Admin::where('UserEmail',Session::get('adminSession'))->update(['Password'=>$Password]);
                return redirect('/admin/settings')->with('flash_message_success','Password updated Successfully!');
            }else {
                return redirect('/admin/settings')->with('flash_message_error','Incorrect Current Password!');
            }
        }
    }

    public function forgotPassword(Request $request){
        $meta_title ="Forgot password - GhanaTrek";
         if($request->isMethod('post')){
             $data = $request->all();
             $adminCount = Admin::where('UserEmail',$data['UserEmail'])->count();
             if($adminCount == 0){
                 return redirect()->back()->with('flash_message_error', 'Email does not exists!');
             }
             $AdminDetails = Admin::where('UserEmail', $data['UserEmail'])->first();

             //Generate random password
             $random_password = str_random(8);

             //Encode/ Secure Password
             $new_pwd = md5($random_password);

             //Update password
             User::where('UserEmail', $data['UserEmail'])->update(['Password'=>$new_pwd]);

             //Send forgot Password Email Code
             $UserEmail = $data['UserEmail'];
             $messageData=[
                 'UserEmail'=>$UserEmail,
                 'Password'=>$random_password
             ];
             Mail::send('emails.adminforgotpassword', $messageData, function($message)use($UserEmail){
                 $message->to($UserEmail)->subject('New Password - GhanaTrek');
             });
             return redirect('/admin/login')->with('flash_message_success','Please check your email for new password');
         }
         return view('admin.admin_login')->with(compact('meta_title'));
     }

    public function logout()
    {
        Session::flush();
        return redirect('/admin/login')->with('flash_message_success','logged out successfull');
    }

    public function viewAdmins(){
        $admins = Admin::get();

        return view('admin.admins.view_admins')->with(compact('admins'));
    }

    public function addAdmin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'UserEmail' => 'required|email',
                'Password' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // dd($data);
            $adminCount = Admin::where('UserEmail',$data['UserEmail'])->count();
            if($adminCount>0){
                return redirect()->back()->with('flash_message_error', 'Admin already exist!');
            }else{
                if(empty($data['Status'])){
                    $data['Status'] = 0;
                }
                if ($data['Type']=="Admin") {
                    $admin = new Admin;
                    $admin->Type =$data['Type'];
                    $admin->UserEmail = $data['UserEmail'];
                    $admin->Password = md5($data['Password']);
                    $admin->Status = $data['Status'];
                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Admin added successfully');
                }elseif ($data['Type']=="Sub-Admin") {
                    if(empty($data['Categories_access'])){
                        $data['Categories_access'] = 0;
                    }
                    if(empty($data['Tourpackages_access'])){
                        $data['Tourpackages_access'] = 0;
                    }
                    if(empty($data['Bookings_access'])){
                        $data['Bookings_access'] = 0;
                    }
                    if(empty($data['Users_access'])){
                        $data['Users_access'] = 0;
                    }

                    $admin = new Admin;
                    $admin->Type =$data['Type'];
                    $admin->UserEmail = $data['UserEmail'];
                    $admin->Password = md5($data['Password']);
                    $admin->Status = $data['Status'];
                    $admin->Categories_access = $data['Categories_access'];
                    $admin->Tourpackages_access =$data['Tourpackages_access'];
                    $admin->Bookings_access =$data['Bookings_access'];
                    $admin->Users_access =$data['Users_access'];
                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Sub Admin added successfully');
                }

            }
        }
        return view('admin.admins.add_admin');
    }

    public function editAdmin(Request $request, $id){
        $adminDetails = Admin::where('id', $id)->first();
        // $adminDetails = json_decode(json_encode($adminDetails));
        // dd($adminDetails);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'UserEmail' => 'required|email',
                'Password' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //dd($data);
            if(empty($data['Status'])){
                $data['Status'] = 0;
            }
            if ($data['Type']=="Admin") {
                Admin::where('UserEmail', $data['UserEmail'])->update(['Password'=>md5($data['Password']), 'Status'=>$data['Status']]);
                return redirect()->back()->with('flash_message_success', 'Admin updated successfully');
            }elseif ($data['Type']=="Sub-Admin") {
                if(empty($data['Categories_access'])){
                    $data['Categories_access'] = 0;
                }
                if(empty($data['Tourpackages_access'])){
                    $data['Tourpackages_access'] = 0;
                }
                if(empty($data['Bookings_access'])){
                    $data['Bookings_access'] = 0;
                }
                if(empty($data['Users_access'])){
                    $data['Users_access'] = 0;
                }

                Admin::where('UserEmail', $data['UserEmail'])->update(['Password'=>md5($data['Password']),
                'Status'=>$data['Status'],
                'Categories_access'=>$data['Categories_access'],
                'Tourpackages_access'=>$data['Tourpackages_access'],
                'Bookings_access'=>$data['Bookings_access'],
                'Users_access'=>$data['Users_access']]);
                return redirect()->back()->with('flash_message_success', 'Sub Admin updated successfully');
            }
        }
        return view('admin.admins.edit_admin')->with(compact('adminDetails'));
    }

    public function viewUsersChart(){

    }

}
