<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Exports\tourpackagesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Str;
use App\Tourpackages;
use App\Feedback;
use App\Country;
use App\Tourtype;
use App\Tourlocations;
use App\Accommodation;
use App\Packageimages;
use App\Tourtransportation;
use App\Tourinclude;
use App\Coupon;
use App\User;
use App\Booking;
use App\BookingsPackage;
use App\TravelAddress;
use Auth;
use Image;
use App\Tourpackagecategory;
use Dompdf\Dompdf;
use Session;
use DB;
use Carbon\Carbon;
use Validator;

class TourpackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addtour(Request $request)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        if($request->isMethod('post')){
            $data = $request->all();
             //echo "<pre>"; print_r($data); die;
             if(empty($data['featured_tour'])){
                $featured_tour = 0;
            }else{
                $featured_tour = 1;
            }
            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }

             if(empty($data['Category_id'])){
                 return redirect()->back()->with('flash_message_error', 'Select Under category option!');
             }
             if (Tourpackages::where('PackageCode', $request->PackageCode)->exists()){
                return redirect()->back()->with('flash_message_error', 'Package code already exists!');
            }
            if(empty($data['PackagePrice'])){
                return redirect()->back()->with('flash_message_error', 'Price cannot be empty!');
            }

            $validator = Validator::make($request->all(), [
                'PackageName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'PackagePrice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'PackageCode' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $tourpackages = new Tourpackages;
            $tourpackages->Category_id = $data['Category_id'];
            $tourpackages->PackageName = $data['PackageName'];
            $tourpackages->PackageCode = $data['PackageCode'];
            if (!empty($data['Description'])) {
                $tourpackages->Description = $data['Description'];
            }else{
                $tourpackages->Description = '';
            }
            $tourpackages->PackagePrice = $data['PackagePrice'];
            $tourpackages->Status = $Status;
            $tourpackages->featured_tour = $featured_tour;

             //upload image
             if($request->hasFile('Imageaddress')){
                $Imageaddress_tmp = $request->file('Imageaddress');
                if($Imageaddress_tmp->isValid()){
                    $extension = $Imageaddress_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/tours/large/'.$filename;
                    $medium_image_path = 'images/backend_images/tours/medium/'.$filename;
                    $small_image_path = 'images/backend_images/tours/small/'.$filename;

                    //Resize Images
                    Image::make($Imageaddress_tmp)->save($large_image_path);
                    Image::make($Imageaddress_tmp)->resize(270,180)->save($medium_image_path);
                    Image::make($Imageaddress_tmp)->resize(135,90)->save($small_image_path);

                    //store image name in tours table
                    $tourpackages->Imageaddress =$filename;
                }

            }
            $tourpackages->save();
            return redirect('/admin/view_tourpackages')->with('flash_message_success','Package has been added successfully!');
        }
        $tourpackagecategory = Tourpackagecategory::get();
        $tourpackagecategory_dropdown ="<option value='' selected disabled>Select</option>";
        foreach ($tourpackagecategory as $cat) {
            $tourpackagecategory_dropdown .= "<option value='".$cat->id."'>".$cat->CategoryName."</option>";
        }
        return view('admin.tour.tourpackage')->with(compact('tourpackagecategory_dropdown'));
    }

    public function viewTour()
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackages = Tourpackages::get();
        $tourpackages = json_decode(json_encode($tourpackages));
            foreach($tourpackages as $key => $val){
                $CategoryName = Tourpackagecategory::where(['id'=>$val->Category_id])->first();
                $tourpackages[$key]->CategoryName = $CategoryName->CategoryName;
            }

        return view('admin.tour.view_tourpackages')->with(compact('tourpackages'));
    }

    public function editTour(Request $request, $id=null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }

            if(empty($data['featured_tour'])){
                $featured_tour = 0;
            }else{
                $featured_tour = 1;
            }

            if(empty($data['Category_id'])){
                return redirect()->back()->with('flash_message_error', 'Select Under category option!');
            }

            $validator = Validator::make($request->all(), [
                'PackageName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'PackagePrice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'PackageCode' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if($request->hasFile('Imageaddress')){
                $Imageaddress_tmp = $request->file('Imageaddress');
                if($Imageaddress_tmp->isValid()){
                    $extension = $Imageaddress_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/tours/large/'.$filename;
                    $medium_image_path = 'images/backend_images/tours/medium/'.$filename;
                    $small_image_path = 'images/backend_images/tours/small/'.$filename;

                    //Resize Images
                    Image::make($Imageaddress_tmp)->save($large_image_path);
                    Image::make($Imageaddress_tmp)->resize(270,180)->save($medium_image_path);
                    Image::make($Imageaddress_tmp)->resize(135,90)->save($small_image_path);
                }
            }else{
                $filename = $data['current_image'];
            }
            if (empty($data['description'])) {
                $data['description']= '';
            }

            Tourpackages::where(['id'=>$id])->update([
                'Category_id'=>$data['Category_id'],
                'PackageName'=>$data['PackageName'],
                'PackageCode'=>$data['PackageCode'],
                'Description'=>$data['Description'],
                'PackagePrice'=>$data['PackagePrice'],
                'Status'=>$Status,
                'featured_tour'=>$featured_tour,
                'Imageaddress'=>$filename

            ]);
            return redirect()->back()->with('flash_message_success', 'Tour has been updated successfully!');
        }

        $tourpackagesDetails = Tourpackages::where(['id'=>$id])->first();

        $tourpackagecategory = Tourpackagecategory::get();
        $tourpackagecategory_dropdown ="<option value='' selected disabled>Select</option>";
        foreach ($tourpackagecategory as $cat) {
            if($cat->id==$tourpackagesDetails->Category_id){
                $selected ="selected";
            }else{
                $selected = " ";
            }
            $tourpackagecategory_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->CategoryName."</option>";
        }

        return view('admin.tour.edit_tourpackages')->with(compact('tourpackagesDetails', 'tourpackagecategory_dropdown'));
    }

    public function deleteTourImage($id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackageimage = Tourpackages::where(['id'=>$id])->first();
        //echo $tourpackageimage->Imageaddress; die;
        $large_image_path = 'images/backend_images/tours/large/';
        $medium_image_path = 'images/backend_images/tours/medium/';
        $small_image_path = 'images/backend_images/tours/small/';

        //deleting large image if not exist in folder
        if(file_exists($large_image_path.$tourpackageimage->Imageaddress)){
            unlink($large_image_path.$tourpackageimage->Imageaddress);
        }

         //deleting medium image if not exist in folder
         if(file_exists($medium_image_path.$tourpackageimage->Imageaddress)){
            unlink($medium_image_path.$tourpackageimage->Imageaddress);
        }

        //deleting small image if not exist in folder
        if(file_exists($small_image_path.$tourpackageimage->Imageaddress)){
            unlink($small_image_path.$tourpackageimage->Imageaddress);
        }

        Tourpackages:: where(['id'=>$id])->update(['Imageaddress'=>'']);
        return redirect()->back()->with('flash_message_success', 'Tour Image has been deleted successfully!');
    }

    public function deleteTourpackage($id=null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        Tourpackages::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Tour has been deleted successfully!');
    }

    public function deleteTourtype($id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        Tourtype::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Tour type has been deleted successfully!');
    }


    public function tourtype(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackagesDetails = Tourpackages::with('tourtypes')->where(['id'=>$id])->first();
        // $tourpackagesDetails = json_decode(json_encode($tourpackagesDetails ));
        // echo "<pre>"; print_r($tourpackagesDetails); die;


        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['SKU'] as $key => $val){
                if(!empty($val)){
                    //prevent duplicate sku
                    $typeCountSKU = Tourtype::where('SKU', $val)->count();
                    if($typeCountSKU>0){
                        return redirect('admin/add-tourtype/'.$id)->with('flash_message_error', 'SKU already exist! Please add another SKU.');
                    }

                    //prevent duplicate tourtype
                    $typeCountName = Tourtype::where(['Package_id'=>$id,'TourTypeName'=>$data['TourTypeName'][$key]])->count();
                    if($typeCountName>0){
                        return redirect('admin/add-tourtype/'.$id)->with('flash_message_error','"'.$data['TourTypeName'][$key].'"Tour type name already exist for this tour! Please add another name.');
                    }


                    $tourtype = new Tourtype;
                    $tourtype->Package_id =$id;
                    $tourtype->SKU =$val;
                    $tourtype->TourTypeName =$data['TourTypeName'][$key];
                    $tourtype->TourTypeSize =$data['TourTypeSize'][$key];
                    $tourtype->PackagePrice =$data['PackagePrice'][$key];
                    $tourtype->save();
                }
            }
            return redirect('admin/add-tourtype/'.$id)->with('flash_message_success', 'Tour Type has been added successfully');
        }
        return view('admin.tour.add_tourtype')->with(compact('tourpackagesDetails'));
    }

    public function edittourtype(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        if($request->isMethod('post')){
            $data = $request->all();

            //echo "<pre>"; print_r($data); die;
             foreach($data['idType'] as $key => $type){
                 Tourtype::where(['id' =>$data['idType'][$key]])->update([
                     'PackagePrice'=>$data['PackagePrice'][$key],
                     'TourTypeSize'=>$data['TourTypeSize'][$key]
                     ]);
             }
             return redirect()->back()->with('flash_message_success', 'Tour Type has been updated successfully');
         }
    }



    public function image(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackagesDetails = Tourpackages::with('packageimages')->where(['id'=>$id])->first();

        if($request->isMethod('post')){
            $data = $request->all();
           if($request->hasFile('Image')){
            $files = $request->file('Image');
               foreach($files as $file){
                //upload image
                 $Image = new Packageimages;
                 $extension = $file->getClientOriginalExtension();
                 $fileName = rand(111,999999).'.'.$extension;

                 $large_image_path = 'images/backend_images/tours/large/'.$fileName;
                 $medium_image_path = 'images/backend_images/tours/medium/'.$fileName;
                 $small_image_path = 'images/backend_images/tours/small/'.$fileName;

                 //Resize Images
                 Image::make($file)->save($large_image_path);
                 Image::make($file)->resize(270,180)->save($medium_image_path);
                 Image::make($file)->resize(135,90)->save($small_image_path);

                 $Image->Image =$fileName;
                 $Image->Package_id = $data['Package_id'];
                 $Image->save();
               }
               return redirect('admin/add-image/'.$id)->with('flash_message_success', 'Image has been added successfully');
            }
        }
        $packageimages = Packageimages::where(['Package_id' => $id])->get();
        $packageimages = json_decode(json_encode($packageimages));

        return view('admin.tour.add_image')->with(compact('tourpackagesDetails','packageimages'));
    }

    public function deleteAltimage($id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackageimage = Packageimages::where(['id'=>$id])->first();
        //echo $tourpackageimage->Imageaddress; die;
        $large_image_path = 'images/backend_images/tours/large/';
        $medium_image_path = 'images/backend_images/tours/medium/';
        $small_image_path = 'images/backend_images/tours/small/';

        //deleting large image if not exist in folder
        if(file_exists($large_image_path.$tourpackageimage->Image)){
            unlink($large_image_path.$tourpackageimage->Image);
        }

         //deleting medium image if not exist in folder
         if(file_exists($medium_image_path.$tourpackageimage->Image)){
            unlink($medium_image_path.$tourpackageimage->Image);
        }

        //deleting small image if not exist in folder
        if(file_exists($small_image_path.$tourpackageimage->Image)){
            unlink($small_image_path.$tourpackageimage->Image);
        }

        Packageimages:: where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Alt Image has been deleted successfully!');
    }


    public function transport(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackagesDetails = Tourpackages::with('tourtransports')->where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['TransportName'] as $key => $val){
                if(!empty($val)){

                    //prevent duplicate tourtransport
                    $tranCountName = Tourtransportation::where(['Package_id'=>$id,'TransportName'=>$val])->count();
                    if($tranCountName>0){
                        return redirect('admin/add-tourtype/'.$id)->with('flash_message_error','"'.$val.'"Transportation name already exist for this tour! Please add another name.');
                    }

                    $validator = Validator::make($request->all(), [
                        'ToransportName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                        'TransportCost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                    ]);
                    if($validator->fails()){
                        return redirect()->back()->withErrors($validator)->withInput();
                    }

                    $tourtransportation = new Tourtransportation;
                    $tourtransportation->Package_id =$id;
                    $tourtransportation->TransportName =$val;
                    $tourtransportation->TransportCost =$data['TransportCost'][$key];
                    $tourtransportation->save();
                }
            }
            return redirect('admin/add-tourtype/'.$id)->with('flash_message_success', 'Tour Transport has been added successfully');
        }
        return view('admin.tour.add_tourtype')->with(compact('tourpackagesDetails'));
    }

    public function edittransport(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $validator = Validator::make($request->all(), [
                'TransportCost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            foreach($data['idTransport'] as $key => $transport){
                Tourtransportation::where(['id' =>$data['idTransport'][$key]])->update([
                    'TransportCost'=>$data['TransportCost'][$key]
                    ]);
            }
            return redirect()->back()->with('flash_message_success', 'Tour Transport has been updated successfully');
        }
    }



    public function deleteTransport($id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        Tourtransportation::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Tour Transportation has been deleted successfully!');
    }

    public function tourinclude(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackagesDetails = Tourpackages::with('tourincludes')->where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['IncludeName'] as $key => $val){
                if(!empty($val)){
                    $tourinclude = new Tourinclude;
                    $tourinclude->Package_id =$id;
                    $tourinclude->IncludeName =$val;
                    $tourinclude->TourIncludeInfo =$data['TourIncludeInfo'][$key];
                    $tourinclude->TourExcludeName =$data['TourExcludeName'][$key];
                    $tourinclude->save();
                }
            }
            return redirect('admin/add-tourtype/'.$id)->with('flash_message_success', 'Tour details has been added successfully');
        }
        return view('admin.tour.add_tourtype')->with(compact('tourpackagesDetails'));
    }

    public function deleteTourinclude($id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        Tourinclude::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Tour Include has been deleted successfully!');
    }


    public function accommodation(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackagesDetails = Tourpackages::with('accommodations')->where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();

            //prevent duplicate accommodation
            $accCountName = Accommodation::where(['Package_id'=>$id,'AccommodationName'=>$data['AccommodationName']])->count();
            if($accCountName>0){
                return redirect('admin/add-tourtype/'.$id)->with('flash_message_error','"'.$data['AccommodationName'].'"Accommodation Name already exist for this tour! Please add another name.');
            }

            $accommodation = new Accommodation;
            $accommodation->Package_id =$id;
            $accommodation->AccommodationName =$data['AccommodationName'];
            $accommodation->save();

            return redirect('admin/add-tourtype/'.$id)->with('flash_message_success', 'Accomodation has been added successfully');
        }
        return view('admin.tour.add_tourtype')->with(compact('tourpackagesDetails'));
    }

    public function deleteAccommodation($id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        Accommodation::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Accommodation has been deleted successfully!');
    }

    public function location(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['Tourpackages_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
            $tourpackagesDetails = Tourpackages::where(['id'=>$id])->first();
            if($request->isMethod('post')){
                $data = $request->all();
                //echo "<pre>"; print_r($data);die;
                if(empty($data['LocationName'])){
                    return redirect()->back()->with('flash_message_error', 'LocationName cannot be empty!');
                }
                $tourlocations = new Tourlocations;
                $tourlocations->Package_id =$id;
                $tourlocations->LocationName = $data['LocationName'];
                $tourlocations->Longitude = $data['Longitude'];
                $tourlocations->Latitude = $data['Latitude'];
                $tourlocations->Weather = $data['Weather'];
                $tourlocations->WeatherDetails = $data['WeatherDetails'];
                $tourlocations->save();

                return redirect('/admin/add-location/'.$id)->with('flash_message_success', 'tour location added Successfully!');
            }

            return view('admin.tour.location')->with(compact('tourpackagesDetails'));

    }







    public function tour($CategoryName = null)
    {

        $countCategory = Tourpackagecategory::where(['CategoryName'=>$CategoryName, 'CategoryStatus'=>1])->count();
        if ($countCategory==0){
            abort(404);
        }
        $tourpackagecategory = Tourpackagecategory::with('tourcategories')->where($id=null)->get();
        $categoryDetails = Tourpackagecategory::where(['CategoryName'=>$CategoryName])->first();


        $tourpackagesAll = Tourpackages::where(['tourpackages.Category_id' => $categoryDetails->id ])->where('tourpackages.Status','1')->orderBy('tourpackages.id','DESC');


        if(!empty($_GET['TourTypeName'])){
            $TourTypeNameArray = explode('-', $_GET['TourTypeName']);
            $tourpackagesAll = $tourpackagesAll->join('tourtypes','tourtypes.Package_id','=','tourpackages.id')
            ->select('tourpackages.*','tourtypes.Package_id','tourtypes.TourTypeName')
            ->groupBy('tourtypes.Package_id')
            ->whereIn('tourtypes.TourTypeName',$TourTypeNameArray);
        }

        $tourpackagesAll = $tourpackagesAll->paginate(6);
        // $tourpackagesAll = json_decode(json_encode($tourpackagesAll));
        // dd($tourpackagesAll);

        $TourTypeNameArray = Tourtype::select('TourTypeName')->groupBy('TourTypeName')->get();
        $TourTypeNameArray =array_flatten(json_decode(json_encode($TourTypeNameArray),true));
        //dd($TourTypeNameArray);
        //echo "<pre>"; print_r($TourTypeNameArray); die;

        //meta
        $meta_title = $categoryDetails->meta_title;
        $meta_description = $categoryDetails->meta_description;
        $meta_keywords = $categoryDetails->meta_keywords;
        return view('tour.package')->with(compact('tourpackagecategory','categoryDetails', 'tourpackagesAll','meta_title','meta_description','meta_keywords','CategoryName','TourTypeNameArray'));
    }

    public function filter(Request $request){
        $data = $request->all();
        //dd($data);

        $TourTypeNameUrl="";
        if(!empty($data['TourTypeNameFilter'])){
            foreach($data['TourTypeNameFilter'] as $TourTypeName){
                if(empty($TourTypeNameUrl)){
                    $TourTypeNameUrl = "&TourTypeName=".$TourTypeName;
                }else{
                    $TourTypeNameUrl .= "-".$TourTypeName;
                }
            }
        }
        $finalUrl = "tour/".$data['CategoryName']."?".$TourTypeNameUrl;
        return redirect::to($finalUrl);
    }

    public function searchTour(Request $request){
        $data = $request->all();
        $tourpackagecategory = Tourpackagecategory::with('tourcategories')->where($id=null)->get();
        $search_tour = $data['tour'];
        // $tourpackagesAll = Tourpackages::where('PackageName', 'like','%'.$search_tour.'%')->orwhere('PackageCode',$search_tour)->where('Status',1)->get();

        $tourpackagesAll = Tourpackages::where(function($query) use($search_tour){
            $query->where('PackageName','like','%'.$search_tour.'%')->orwhere('PackageCode','like','%'.$search_tour.'%');
        })->where('Status',1)->get();
        return view('tour.package')->with(compact('tourpackagecategory','search_tour', 'tourpackagesAll'));
     }



    public function tours($id = null)
    {

        $tourpackagesCount = Tourpackages::where(['id'=>$id, 'Status'=>1])->count();
        if($tourpackagesCount == 0){
            abort(404);
        }

        $tourpackagesDetails = Tourpackages::with('tourtypes','accommodations','tourincludes','tourtransports','tourlocations')->where('id', $id)->first();
        $tourpackagesDetails = json_decode(json_encode($tourpackagesDetails));

       // echo "<pre>"; print_r($tourpackagesDetails);die;
       $relatedTour = Tourpackages::where('id','!=',$id)->where(['Category_id'=>$tourpackagesDetails->Category_id])->get();


       $tourAltImage = Packageimages::where('Package_id',$id)->get();
        //    $tourAltImage = json_decode(json_encode($tourAltImage));
        //    echo "<pre>"; print_r($tourAltImage); die;

        $total_availability = Tourtype::where('Package_id',$id)->sum('TourTypeSize');
        //dd( $tourpackagesDetails);

        $feedbacks = Feedback::where('Status', '1')->get();
        // $banners = Banner::where('Status', '1')->get();


        //meta
        $meta_title = $tourpackagesDetails->PackageName;
        $meta_description = $tourpackagesDetails->Description;
        $meta_keywords = $tourpackagesDetails->PackageName;
        return view('tour.details')->with(compact('tourpackagesDetails','tourAltImage','relatedTour','total_availability','meta_title','meta_description','meta_keywords','feedbacks'));
    }


    public function getTourpackagePrice(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $tourArr = explode("-", $data['idTourTypeName']);
        //echo $tourArr[0]; echo $tourArr[1]; die;

        $tourtypeAtt = Tourtype::where(['Package_id' => $tourArr[0], 'TourTypeName' => $tourArr[1]])->first();
        $getCurrencyRates = Tourpackages::getCurrencyRates($tourtypeAtt->PackagePrice);
        echo $tourtypeAtt->PackagePrice."-".$getCurrencyRates['USD_Rate']."-".$getCurrencyRates['GBP_Rate']."-".$getCurrencyRates['EUR_Rate']."-".$getCurrencyRates['FRF_Rate']."-".$getCurrencyRates['BRL_Rate'];
        echo "#";
        echo $tourtypeAtt->TourTypeSize;
    }


    // public function getTransportCost(Request $request)
    // {
    //     $data = $request->all();
    //     // echo "<pre>"; print_r($data); die;
    //     $tranArr = explode("-", $data['idTransportName']);

    //     //echo $tourArr[0]; echo $tourArr[1]; die;

    //     $tranAtt = Tourtransportation::where(['Package_id' => $tranArr[0], 'TransportName' => $tranArr[1]])->first();
    //     echo $tranAtt->TransportCost;
    // }

    public function addtocart(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
          //echo "<pre>"; print_r($data); die;


        if(!empty($data['wishlistbutton']) && $data['wishlistbutton']=="Add to wishlist"){
            // echo"Wish list selected";die;

            if(!Auth::check()){
                return redirect()->back()->with('flash_message_error','Please login to add to your wishlist');
            }

            //check size is selected
            if(empty($data['TourTypeName'])){
                return redirect()->back()->with('flash_message_error','Please select Tour Type to add to your wishlist');
            }

            //Get Tour Type
            $TourTypeNameArr = explode("-", $data['TourTypeName']);
            $TourTypeName = $TourTypeNameArr[1];
            //Get Tour package price
            $tourPrice = Tourtype::where(['Package_id'=>$data['Package_id'], 'TourTypeName'=>$TourTypeName])->first();
            $PackagePrice = $tourPrice->PackagePrice;


            // if (empty($data['TransportName'])){
            //     $data['TransportName'] = '';
            // }

            // $TransportNameArr = explode("-", $data['TransportName']);
            // $TransportName = $TransportNameArr[1];


            //Get User Email
            $UserEmail = Auth::user()->UserEmail;

            //Set Travellers as 1
            //$Travellers =1;

            //Get current date
            $created_at = Carbon::now();

            $wishlistCount = DB::table('wishlist')->where(['UserEmail'=>$UserEmail,'Package_id'=>$data['Package_id'],'PackageName'=>$data['PackageName'],'PackageCode'=>$data['PackageCode'],'TourTypeName'=>$TourTypeName])->count();

            if($wishlistCount>0){
                return redirect()->back()->with('flash_message_error','Tour package already exists in wishlist');
            }else{
                DB::table('wishlist')->insert([
                    'Package_id'=>$data['Package_id'],
                    'PackageName'=>$data['PackageName'],
                    'PackageCode'=>$data['PackageCode'],
                    'PackagePrice'=>$PackagePrice,
                    'TourTypeName'=>$TourTypeName,
                    'Travellers'=>$data['Travellers'],
                    'UserEmail'=>$UserEmail,
                    'created_at'=>$created_at]);
            return redirect()->back()->with('flash_message_success','Tour packages has been added to your wishlist');

            }


        }else{
            if (!empty($data['cartbutton']) && $data['cartbutton']=="Add-to-wishlist") {
                // $data['Travellers'] =1;
            }
            if(empty($data['TourTypeName'])){
                return redirect()->back()->with('flash_message_error', 'Select Tour type !');
            }
            //checking tour package availability
            $TourTypeName = explode("-", $data['TourTypeName']);
            //echo $data['Travellers']; die;
            $getTourSize = Tourtype::where(['Package_id'=>$data['Package_id'],'TourTypeName'=>$TourTypeName[1]])->first();


            if($getTourSize->TourTypeSize<$data['Travellers']){
                return redirect()->back()->with('flash_message_error','Required Number of travellers is not available');
            }



            if(empty(Auth::user()->UserEmail)){
                $data['UserEmail'] = '';
            }else{
                $data['UserEmail'] = Auth::user()->UserEmail;
            }

            $Session_id = Session::get('Session_id');
            if(!isset($Session_id)){
                $Session_id = str::random(40);
                Session::put('Session_id',$Session_id);
            }

            // if (empty($data['TransportName'])){
            //     $data['TransportName'] = '';
            // }


            $TourTypeNameArr = explode("-", $data['TourTypeName']);
            $TourTypeName = $TourTypeNameArr[1];

            // $TransportNameArr = explode("-", $data['TransportName']);
            // $TransportName = $TransportNameArr[1];

            if(empty($data['TourTypeName'])){
                return redirect()->back()->with('flash_message_error', 'Select Tour type !');
            }
            if(empty(Auth::check())){
                $countTourpackages = DB::table('carts')->where([
                    'Package_id'=>$data['Package_id'],
                    'PackageName'=>$data['PackageName'],
                    'TourTypeName'=>$TourTypeName,
                    'Session_id'=>$Session_id])->count();
                if($countTourpackages>0){
                    return redirect()->back()->with('flash_message_error',  'Tour Package already exist in cart!');
                }
            }else{
                $countTourpackages = DB::table('carts')->where([
                    'Package_id'=>$data['Package_id'],
                    'PackageName'=>$data['PackageName'],
                    'TourTypeName'=>$TourTypeName,
                    'UserEmail'=>$data['UserEmail']])->count();
                if($countTourpackages>0){
                    return redirect()->back()->with('flash_message_error',  'Tour Package already exist in cart!');
                }
            }


                $getSKU =Tourtype::select('SKU')->where(['Package_id' =>$data['Package_id'],'TourTypeName'=>$TourTypeName])->first();
                DB::table('carts')->insert([
                    'Package_id'=>$data['Package_id'],
                    'PackageName'=>$data['PackageName'],
                    'PackageCode'=>$getSKU->SKU,
                    'PackagePrice'=>$data['PackagePrice'],
                    'Travellers'=>$data['Travellers'],
                    'TourTypeName'=>$TourTypeName,
                    // 'TransportName'=>$TransportName,
                    'UserEmail'=>$data['UserEmail'],
                    'Session_id'=>$Session_id]);

            return redirect('cart')->with('flash_message_success','tour added to cart');
        }

    }


    public function cart()
    {
        if(Auth::check()){
            $UserEmail = Auth::user()->UserEmail;
            $userCart = DB::table('carts')->where(['UserEmail'=>$UserEmail])->get();
        }else{
            $Session_id = Session::get('Session_id');
            $userCart = DB::table('carts')->where(['Session_id'=>$Session_id])->get();
        }

        foreach($userCart as $key =>$tourpackages){
            $tourpackagesDetails = Tourpackages::where('id', $tourpackages->Package_id)->first();
            $userCart[$key]->Imageaddress = $tourpackagesDetails->Imageaddress;
        }
        $meta_title = "Booking Cart - GhanaTrek";
        $meta_description = "View Booking Cart of GhanaTrek";
        $meta_keywords = "Booking cart, GhanaTrek";
        return view('tour.cart')->with(compact('userCart','meta_title','meta_description','meta_keywords'));
    }
    public function wishlist(){
        if(Auth::check()){
            $UserEmail = Auth::user()->UserEmail;
        $userwishlist = DB::table('wishlist')->where('UserEmail',$UserEmail)->get();
        foreach($userwishlist as $key => $tourpackages){
            $tourpackagesDetails = Tourpackages::where('id',$tourpackages->Package_id)->first();
            $userwishlist[$key]->Imageaddress =$tourpackagesDetails->Imageaddress;
            }
        }else{
            $userwishlist = array();

        }
        $meta_title = "Wishlist - GhanaTrek";
        $meta_description = "View wishlist of GhanaTrek";
        $meta_keywords = "Wishlist, GhanaTrek";
        return view('tour.wishlist')->with(compact('userwishlist','meta_title','meta_description','meta_keywords'));
    }

    public function deletewishlistPackage($id = null){
        DB::table('wishlist')->where('id', $id)->delete();
        return redirect('wishlist')->with('flash_message_success', 'Tour Package has been deleted from wishlist!');
    }

    public function deleteCartPackage($id = null){
        DB::table('carts')->where('id', $id)->delete();
        return redirect('cart')->with('flash_message_success', 'Tour Package has been deleted from cart!');
    }

    public function applyCoupon(Request $request)
    {
        Session::put('CouponAmount');
        Session::put('CouponCode');

        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $couponCount = Coupon::where('CouponCode', $data['CouponCode'])->count();
        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error', 'This coupon does not exist');
        }else{
            //get coupon details
            $couponDetails = Coupon::where('CouponCode', $data['CouponCode'])->first();

            //if coupon is Inactive
            if($couponDetails->Status==0){
                return redirect()->back()->with('flash_message_error', 'This coupon is not active');
            }
            //if coupon is expired
             $ExpiryDate = $couponDetails->ExpiryDate;
            $current_date = date('Y-m-d');
            if($ExpiryDate < $current_date){
                return redirect()->back()->with('flash_message_error', 'This coupon is expired');
            }

            //Coupon is valid for discount

            //Get Cart Total Amount
            $Session_id = Session::get('Session_id');

            if(Auth::check()){
                $UserEmail = Auth::user()->UserEmail;
                $userCart = DB::table('carts')->where(['UserEmail'=>$UserEmail])->get();
            }else{
                $Session_id = Session::get('Session_id');
                $userCart = DB::table('carts')->where(['Session_id'=>$Session_id])->get();
            }

            $total_amount = 0;
            foreach($userCart as $item){
                $total_amount = $total_amount + ($item->PackagePrice * $item->Travellers);

            }

            //check if amount type is fixed or percentage
            if($couponDetails->AmountType=="Fixed"){
                $couponAmount = $couponDetails->Amount;
            }else{
                //echo $total_amount;die;
                $couponAmount = $total_amount * ($couponDetails->Amount/100);
            }

            //add coupon code $ amount in session
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $data['CouponCode']);

            return redirect()->back()->with('flash_message_success', 'Coupon code successfully applied. You are availing discount!');
        }
    }

    public function billing(Request $request){
        $user_id =Auth::user()->id;
        $UserEmail =Auth::user()->UserEmail;
        $userDetails = User::find($user_id);
        $countries =Country::get();

        //checking if Travelling Address exists
        $travellingCount = TravelAddress::where('user_id',$user_id)->count();
        $travellingDetails = array();
            if($travellingCount>0){
                $travellingDetails = TravelAddress::where('user_id',$user_id)->first();
            }

            //update cart table with user Email
            $Session_id = Session::get('Session_id');
            DB::table('carts')->where(['Session_id'=>$Session_id])->update(['UserEmail'=>$UserEmail]);
        if($request->isMethod('post')){
            $data =$request->all();

            //return to checkout page if any of the field is empty
            if(empty($data['billing_SurName']) || empty($data['billing_OtherNames']) ||
              empty($data['billing_Country']) || empty($data['billing_Mobile']) || empty($data['billing_OtherContact']) ||
              empty($data['billing_Address']) || empty($data['billing_City']) || empty($data['billing_State']) || empty($data['billing_ZipCode']) ||
              empty($data['travelling_SurName']) || empty($data['travelling_OtherNames']) ||
              empty($data['travelling_Country']) || empty($data['travelling_Mobile']) || empty($data['travelling_OtherContact']) ||
              empty($data['travelling_Address']) || empty($data['travelling_City']) || empty($data['travelling_State']) || empty($data['travelling_ZipCode'])){


                  return redirect()->back()->with('flash_message_error', 'Please fill all fields to Checkout!');
              }
              //Update user details
              User::where('id',$user_id)->update([
                  'SurName'=>$data['billing_SurName'],
                  'OtherNames'=>$data['billing_OtherNames'],
                  'Country'=>$data['billing_Country'],
                  'Mobile'=>$data['billing_Mobile'],
                  'Address'=>$data['billing_Address'],
                  'City'=>$data['billing_City'],
                  'State'=>$data['billing_State'],
                  'ZipCode'=>$data['billing_ZipCode'],
                  'OtherContact'=>$data['billing_OtherContact'],
              ]);

              if($travellingCount>0){
                  //update Travelling Address
                  TravelAddress::where('user_id',$user_id)->update([
                    'SurName'=>$data['travelling_SurName'],
                    'OtherNames'=>$data['travelling_OtherNames'],
                    'Country'=>$data['travelling_Country'],
                    'Mobile'=>$data['travelling_Mobile'],
                    'Address'=>$data['travelling_Address'],
                    'City'=>$data['travelling_City'],
                    'State'=>$data['travelling_State'],
                    'ZipCode'=>$data['travelling_ZipCode'],
                    'OtherContact'=>$data['travelling_OtherContact']
                ]);
              }else{
                  //Add new travelling Address
                  $travelling = new TravelAddress;
                  $travelling->user_id =$user_id;
                  $travelling->UserEmail =$UserEmail;
                  $travelling->SurName=$data['travelling_SurName'];
                  $travelling->OtherNames=$data['travelling_OtherNames'];
                  $travelling->Mobile=$data['travelling_Mobile'];
                  $travelling->OtherContact=$data['travelling_OtherContact'];
                  $travelling->Country=$data['travelling_Country'];
                  $travelling->Address=$data['travelling_Address'];
                  $travelling->City=$data['travelling_City'];
                  $travelling->State=$data['travelling_State'];
                  $travelling->ZipCode=$data['travelling_ZipCode'];
                  $travelling->save();
              }
              return redirect('/tour-review');

        }
        $meta_title = "Checkout - GhanaTrek";
        return view('tour.billing')->with(compact('userDetails','countries','travellingDetails','meta_title'));
    }


    public function tourReview(Request $request)
    {
        $user_id =Auth::user()->id;
        $UserEmail =Auth::user()->UserEmail;
        $userDetails = User::where('id',$user_id)->first();
        $travellingDetails = TravelAddress::where('user_id',$user_id)->first();
        $travellingDetails = json_decode(json_encode($travellingDetails));
        $userCart = DB::table('carts')->where(['UserEmail'=>$UserEmail])->get();
        foreach($userCart as $key =>$tourpackages){
            $tourpackagesDetails = Tourpackages::where('id', $tourpackages->Package_id)->first();
            $userCart[$key]->Imageaddress = $tourpackagesDetails->Imageaddress;
        }

        $meta_title = "Booking review - GhanaTrek";
        return view('tour.tour_review')->with(compact('userDetails','travellingDetails','userCart','meta_title'));
    }


    public function placePackage(Request $request)
    {
        if($request->isMethod('post')){
            $data= $request->all();
            $user_id = Auth::user()->id;
            $UserEmail = Auth::user()->UserEmail;

            //Prevent Sold out Packages from Booking
            $userCart = DB::table('carts')->where('UserEmail', $UserEmail)->get();
            foreach($userCart as $cart){

                $getTourTypeCount =Tourpackages::getTourTypeCount($cart->Package_id,$cart->TourTypeName);
                if($getTourTypeCount ==0){
                    Tourpackages::deleteCartPackage($cart->Package_id,$UserEmail);
                    return redirect('/cart')->with('flash_message_error', ' Tour Type is not available! Please check again another time');
                }

                $toursize = Tourpackages::getTourSize($cart->Package_id,$cart->TourTypeName);
                if($toursize ==0){
                    Tourpackages::deleteCartPackage($cart->Package_id,$UserEmail);
                    return redirect('/cart')->with('flash_message_error', ' Tour package is sold out and removed from Cart! Please check again another time');
                }
                if($cart->Travellers>$toursize){
                    return redirect('/cart')->with('flash_message_error', 'Required number of travellers is not availalable now! Please try again later');
                }
                $tourStatus = Tourpackages::getPackageStatus($cart->Package_id);
                if($tourStatus==0){
                    Tourpackages::deleteCartPackage($cart->Package_id,$UserEmail);
                    return redirect('/cart')->with('flash_message_error', ' Disabled Tour package removed from Cart! Please check again another time');
                }
                $getCatgoryId = Tourpackages::select('Category_id')->where('id', $cart->Package_id)->first();
                //echo $getCatgoryId->Category_id; die;
                $categoryStatus = Tourpackages::getCategoryStatus($getCatgoryId->Category_id);
                if($categoryStatus==0){
                    Tourpackages::deleteCartPackage($cart->Package_id,$UserEmail);
                    return redirect('/cart')->with('flash_message_error', ' One of the tour packages category is disabled! Please try again');
                }

            }

            //Get travelling Address of User
            $travellingDetails =TravelAddress::where(['UserEmail' => $UserEmail])->first();

            if(empty(Session::get('CouponCode'))){
                $CouponCode ='';
            }else{
                $CouponCode = Session::get('CouponCode');
            }

            if(empty(Session::get('CouponAmount'))){
                $Amount ='';
            }else{
                $Amount = Session::get('CouponAmount');
            }


            $Grand_total = Tourpackages::getGrandTotal();

            $booking = new Booking;
            $booking->user_id = $user_id;
            $booking->UserEmail = $UserEmail;
            $booking->SurName = $travellingDetails->SurName;
            $booking->OtherNames = $travellingDetails->OtherNames;
            $booking->Address = $travellingDetails->Address;
            $booking->City = $travellingDetails->City;
            $booking->State = $travellingDetails->State;
            $booking->ZipCode = $travellingDetails->ZipCode;
            $booking->Country = $travellingDetails->Country;
            $booking->Mobile = $travellingDetails->Mobile;
            $booking->OtherContact = $travellingDetails->OtherContact;
            $booking->CouponCode = $CouponCode;
            $booking->Amount = $Amount;
            $booking->Status = "new";
            $booking->Payment_method = $data['Payment_method'];
            $booking->Grand_total = $data['Grand_total'];
            $booking->save();

            $Booking_id = DB::getPdo()->lastInsertId();
            $cartPackages = DB::table('carts')->where(['UserEmail'=>$UserEmail])->get();
            foreach($cartPackages as$pro){
                $cartPro = new BookingsPackage;
                $cartPro->Booking_id = $Booking_id;
                $cartPro->user_id = $user_id;
                $cartPro->Package_id = $pro->Package_id;
                $cartPro->PackageName = $pro->PackageName;
                $cartPro->PackageCode = $pro->PackageCode;
                $cartPro->TourTypeName = $pro->TourTypeName;
                $cartPro->Travellers = $pro->Travellers;
                $PackagePrice = Tourpackages::getPackagePrice($pro->Package_id, $pro->TourTypeName);
                $cartPro->PackagePrice = $PackagePrice;
                $cartPro->TransportName = $pro->TransportName;
                $cartPro->save();

                //reduce TourSize
                $getTourSize = Tourtype::where('SKU', $pro->PackageCode)->first();
                //  echo "Original Size: " .$getTourSize->TourTypeSize;
                //  echo "TourTypeSize to reduce: " .$pro->Travellers;
                 $newSize = $getTourSize->TourTypeSize - $pro->Travellers;
                 if($newSize<0){
                     $newSize = 0;
                 }
                 Tourtype::where('SKU',$pro->PackageCode)->update(['TourTypeSize'=>$newSize]);


            }
            Session::put('Booking_id',$Booking_id);
            Session::put('Grand_total',$data['Grand_total']);

            $tourpackagesDetails = Booking::with('bookings')->where('id', $Booking_id)->first();
            $tourpackagesDetails = json_decode(json_encode($tourpackagesDetails),true);
            //dd($tourpackagesDetails);

            $userDetails = User::where('id', $user_id)->first();
            $userDetails = json_decode(json_encode($userDetails),true);
            //dd($userDetails);
            /*Code for Booking Email starts*/
            $UserEmail = $UserEmail;
            $messageData = [
                'UserEmail'=>$UserEmail,
                'SurName'=>$travellingDetails->SurName,
                'OtherNames'=>$travellingDetails->OtherNames,
                'Booking_id'=>$Booking_id,
                'tourpackagesDetails' =>$tourpackagesDetails,
                'userDetails'=>$userDetails
            ];
            Mail::send('emails.booking', $messageData, function($message) use($UserEmail){
                $message->to($UserEmail)->subject('Booking Placed - GhanaTrek');
            });

            if($data['Payment_method']=="flutterwave"){
                //cod......redirect user to thanks page
                return redirect('/flutterwave');
            }else{
                //Ipay.....redirect user to ipay page
                return redirect('/ipay');
            }
        }
    }

    public function thanks(Request $request){
        $UserEmail = Auth::user()->UserEmail;
        DB::table('carts')->where('UserEmail', $UserEmail)->delete();
        return view('booking.thanks');
    }

    public function ipaythanks(Request $request){
        $UserEmail = Auth::user()->UserEmail;
        DB::table('carts')->where('UserEmail', $UserEmail)->delete();
        return view('booking.thanks_ipay');
    }

    public function ipaycancel(Request $request){
        $UserEmail = Auth::user()->UserEmail;
        DB::table('carts')->where('UserEmail', $UserEmail);
        return view('booking.cancel_ipay');
    }


    public function ipay(Request $request){
        $UserEmail = Auth::user()->UserEmail;
        DB::table('carts')->where('UserEmail', $UserEmail);
        return view('booking.ipay');
    }




    public function flutterwave(Request $request){
        $UserEmail = Auth::user()->UserEmail;
        DB::table('carts')->where('UserEmail', $UserEmail);
        $Booking_id = Session::get('Booking_id');
        $Grand_total = Session::get('Grand_total');
        $bookingDetails = Booking::getBookingDetails($Booking_id);
        $bookingDetails = json_decode(json_encode($bookingDetails));

        return view('booking.flutterwave');
    }
    public function flutterwavethanks(Request $request){
        $UserEmail = Auth::user()->UserEmail;
        DB::table('carts')->where('UserEmail', $UserEmail)->delete();
        return view('booking.thanks_flutterwave');
    }

    public function userBookings(){
        $user_id =Auth::user()->id;
        $bookings = Booking::with('Bookings')->where('user_id', $user_id)->orderBy('id','DESC')->get();

        return view('booking.users_bookings')->with(compact('bookings'));
    }

    public function userBookingDetails($Booking_id){
        $user_id = Auth::user()->id;
        $bookingDetails = Booking::with('bookings')->where('id',$Booking_id)->first();
        $bookingDetails = json_decode(json_encode($bookingDetails));

        return view('booking.users_bookings_details')->with(compact('bookingDetails'));
    }

    public function viewBookings(){
        if(Session::get('adminDetails')['Bookings_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $bookings = Booking::with('bookings')->orderBy('id', 'DESC')->get();
        $bookings = json_decode(json_encode($bookings));

        return view('admin.bookings.view_bookings')->with(compact('bookings'));
    }

    public function viewBookingDetails($Booking_id){
        if(Session::get('adminDetails')['Bookings_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $bookingDetails = Booking::with('bookings')->where('id',$Booking_id)->first();
        $bookingDetails =json_decode(json_encode($bookingDetails));
        $user_id = $bookingDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.bookings.booking_details')->with(compact('bookingDetails','userDetails'));
    }

    public function viewBookingInvoice($Booking_id){
        if(Session::get('adminDetails')['Bookings_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $bookingDetails = Booking::with('bookings')->where('id',$Booking_id)->first();
        $bookingDetails =json_decode(json_encode($bookingDetails));
        $user_id = $bookingDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.bookings.booking_invoice')->with(compact('bookingDetails','userDetails'));
    }

    public function viewPDFInvoice($Booking_id){
        if(Session::get('adminDetails')['Bookings_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $bookingDetails = Booking::with('bookings')->where('id', $Booking_id)->first();
        $bookingDetails =json_decode(json_encode($bookingDetails));
        $user_id = $bookingDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();

        $output = '<!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <title>Example 1</title>
            <link rel="stylesheet" href="style.css" media="all" />
            <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
              }

              a {
                color: #5D6975;
                text-decoration: underline;
              }

              body {
                position: relative;
                width: 21cm;
                height: 29.7cm;
                margin: 0 auto;
                color: #001028;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 12px;
                font-family: Arial;
              }

              header {
                padding: 10px 0;
                margin-bottom: 30px;
              }

              #logo {
                text-align: center;
                margin-bottom: 10px;
              }

              #logo img {
                width: 90px;
              }

              h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
              }

              #project {
                float: left;
              }

              #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
              }

              #company {
                float: right;
                text-align: right;
              }

              #project div,
              #company div {
                white-space: nowrap;
              }

              table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
              }

              table tr:nth-child(2n-1) td {
                background: #F5F5F5;
              }

              table th,
              table td {
                text-align: center;
              }

              table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;
                font-weight: normal;
              }

              table .service,
              table .desc {
                text-align: left;
              }

              table td {
                padding: 20px;
                text-align: right;
              }

              table td.service,
              table td.desc {
                vertical-align: top;
              }

              table td.unit,
              table td.qty,
               {
                font-size: 1.2em;
              }

              table td.grand {
                border-top: 1px solid #5D6975;;
              }

              #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
              }

              footer {
                color: #5D6975;
                width: 100%;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
              }
            </style>
          </head>
          <body>
            <header class="clearfix">
                <div id="logo">
                    <h2>GHANA<span style="color: #fafd44;">TREK</span></h2>
                </div>
                <h1>Booking #'. $bookingDetails->id.'</h1>
                <div id="project" class="clearfix">
                    <h2 class="to"><strong>Billing Address:</strong></h2>
                    <div><span>Name</span>  '. $userDetails->SurName.' '. $userDetails->OtherNames.'</div>
                    <div><span>Country</span>   '. $userDetails->Country.'</div>
                    <div><span>Address</span>   '. $userDetails->Address.'</div>
                    <div><span>City</span>  '. $userDetails->City.'</div>
                    <div><span>State</span> '. $userDetails->State.'</div>
                    <div><span>ZipCode</span> '. $userDetails->ZipCode.'</div>
                    <div><span>Mobile</span>    '. $userDetails->Mobile.'</div>
                    <div><span>OtherContact</span>  '. $userDetails->OtherContact .'</div>
                    <h2>Info</h2>
                    <div><span>Payment Method</span>   '. $bookingDetails->Payment_method.'</div>
                    <div><span>Booking Status</span>   '. $bookingDetails->Status.'</div>
                    <div><span>Booking Date</span>   '. $bookingDetails->created_at.'</div>
                </div>
                <div id="project" style="float:right">
                    <h2 class="to"><strong>Travelling Address:</strong></h2>
                    <div><span>Name</span>  '. $bookingDetails->SurName.' '. $bookingDetails->OtherNames.'</div>
                    <div><span>Country</span>   '. $bookingDetails->Country.'</div>
                    <div><span>Address</span>   '. $bookingDetails->Address.'</div>
                    <div><span>City</span>  '. $bookingDetails->City.'</div>
                    <div><span>State</span> '. $bookingDetails->State.'</div>
                    <div><span>ZipCode</span> '. $bookingDetails->ZipCode.'</div>
                    <div><span>Mobile</span>    '. $bookingDetails->Mobile.'</div>
                    <div><span>OtherContact</span>  '. $bookingDetails->OtherContact .'</div>
                </div>
            </header>
            <main>
              <table>
                <thead>
                  <tr>
                  <td><strong>PackageCode</strong></td>
                  <td class="text-center"><strong>PackageName</strong></td>
                  <td class="text-center"><strong>TourTypeName</strong></td>
                  <td class="text-center"><strong>PackagePrice</strong></td>
                  <td class="text-center"><strong>Travellers</strong></td>
                  <td class="text-right"><strong>Total</strong></td>
                  </tr>
                </thead>
                <tbody>';
                    $Subtotal = 0;
                    foreach ($bookingDetails->bookings as $pro) {
                    $output .='<tr>
                                <td style="text-align: center">'. $pro->PackageCode .'</td>
                                <td style="text-align: center">'. $pro->PackageName .'</td>
                                <td style="text-align: center">'. $pro->TourTypeName .'</td>
                                <td style="text-align: center">GHS '. $pro->PackagePrice .'</td>
                                <td style="text-align: center">'. $pro->Travellers .'</td>
                                <td style="text-align: center">GHS '. $pro->PackagePrice * $pro->Travellers .'</td>
                            </tr>';

                    $Subtotal = $Subtotal + ($pro->PackagePrice * $pro->Travellers);
                }

            $output .='<tr>
                    <td colspan="5">SUBTOTAL</td>
                    <td class="total">GHS '. $Subtotal .'</td>
                  </tr>
                  <tr>
                    <td colspan="5">Coupon Discount (-)</td>
                    <td class="total">GHS '. $bookingDetails->Amount .'</td>
                  </tr>
                  <tr>
                    <td colspan="5" class="grand total">GRAND TOTAL</td>
                    <td class="grand total">GHS '. $bookingDetails->Grand_total .'</td>
                  </tr>
                </tbody>
              </table>
            </main>
            <footer>
              Invoice was created on a computer and is valid without the signature and seal.
            </footer>
          </body>
        </html>';

            // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public  function updateBookingStatus(Request $request){
        if(Session::get('adminDetails')['Bookings_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        if($request->isMethod('post')){
            $data = $request->all();
            Booking::where('id',$data['Booking_id'])->update(['Status'=>$data['Status']]);
            return redirect()->back()->with('flash_message_success', 'Booking Status has been updated successfully!');
        }
    }

    public function exportTourpackages(){
        return Excel::download(new tourpackagesExport,'tourpackages.xlsx');
    }

    public function viewBookingsChart(){
        if(Session::get('adminDetails')['Bookings_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $current_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_to_last_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.tour.view_booking_chart')->with(compact('current_month_booking','last_month_booking','last_to_last_month_booking'));
    }


}
