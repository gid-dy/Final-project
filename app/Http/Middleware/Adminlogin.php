<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;
use Session;
use App\Admin;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('adminSession'))){
            return redirect('admin/login');
        }else{
            $adminDetails = Admin::where('UserEmail',Session::get('adminSession'))->first();
            $adminDetails = json_decode(json_encode($adminDetails),true);
            if($adminDetails['Type']=="Admin"){
                $adminDetails['Categories_access']=1;
                $adminDetails['Tourpackages_access']=1;
                $adminDetails['Bookings_access']=1;
                $adminDetails['Users_access']=1;
            }
            Session::put('adminDetails',$adminDetails);

            // echo "<pre>"; print_r($adminDetails); die;

            //Get current Path
            $currentPath = Route::getFacadeRoot()->current()->uri();

            if($currentPath=="admin/view-categories" && Session::get('adminDetails')['Categories_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
            }

            if($currentPath=="admin/view_tourpackages" && Session::get('adminDetails')['Tourpackages_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
            }

            if($currentPath=="admin/add-tour" && Session::get('adminDetails')['Tourpackages_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
            }
        }
        return $next($request);
    }
}
