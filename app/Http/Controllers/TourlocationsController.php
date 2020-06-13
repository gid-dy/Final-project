<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tourpackages;
use App\Country;
use App\Tourlocations;
use Session;

class TourlocationsController extends Controller
{
    public function addlocation(Request $request )
    {
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;
            $tourlocations = new Tourlocations;
            $tourlocations->LocationName = $data['LocationName'];
            $tourlocations->Longitude = $data['Longitude'];
            $tourlocations->Latitude = $data['Latitude'];
            $tourlocations->Weather = $data['Weather'];
            $tourlocations->GhanaPostAddress = $data['GhanaPostAddress'];
            $tourlocations->OtherAddress = $data['OtherAddress'];
            $tourlocations->save();
            return redirect('/admin/add-location')->with('flash_message_success', 'Category added Successfully!');
        }
            if(Session::has('adminSession')){

            }else{
                return redirect('/admin/login')->with('flash_message_error','Please login to access');
            }
            return view('admin.tour.location');

    }




}
