<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tourpackagecategory;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use Validator;

class TourpackagecategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.

     *
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request)
    {
        if(Session::get('adminDetails')['Categories_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'CategoryName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'CategoryDescription' => 'nullable',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //echo "<pre>"; print_r($data);die;
            if(empty($data['CategoryStatus'])){
                $CategoryStatus = 0;
            }else{
                $CategoryStatus = 1;
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }
            $tourpackagecategory = new Tourpackagecategory;
            $tourpackagecategory->CategoryName = $data['CategoryName'];
            $tourpackagecategory->CategoryDescription = $data['CategoryDescription'];
            $tourpackagecategory->meta_title = $data['meta_title'];
            $tourpackagecategory->meta_description = $data['meta_description'];
            $tourpackagecategory->meta_keywords = $data['meta_keywords'];
            $tourpackagecategory->CategoryStatus = $CategoryStatus;
            //upload image
            if($request->hasFile('Imageaddress')){
                $Imageaddress_tmp = $request->file('Imageaddress');
                if($Imageaddress_tmp->isValid()){
                    $extension = $Imageaddress_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/categories/large/'.$filename;
                    $medium_image_path = 'images/backend_images/categories/medium/'.$filename;

                    //Resize Images
                    Image::make($Imageaddress_tmp)->save($large_image_path);
                    Image::make($Imageaddress_tmp)->resize(270,180)->save($medium_image_path);

                    //store image name in tours table
                    $tourpackagecategory->Imageaddress =$filename;
                }
            }
            $tourpackagecategory->save();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Category added Successfully!');
         }
        // if(Session::has('adminSession')){

        // }else{
        //     return redirect('/admin/login')->with('flash_message_error','Please login to access');
        // }
        return view('admin.categories.add_category');
    }

    public function viewCategories()
    {
        if(Session::get('adminDetails')['Categories_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $tourpackagecategory = Tourpackagecategory::get();
        // $tourpackagecategory = json_decode(json_encode($tourpackagecategory));

        return view('admin.categories.view_categories')->with(compact('tourpackagecategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editCategory(Request $request, $id=null)
    {
        if(Session::get('adminDetails')['Categories_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'CategoryName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'CategoryDescription' => 'nullable',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if(empty($data['CategoryStatus'])){
                $CategoryStatus = 0;
            }else{
                $CategoryStatus = 1;
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }

            if($request->hasFile('Imageaddress')){
                $Imageaddress_tmp = $request->file('Imageaddress');
                if($Imageaddress_tmp->isValid()){
                    $extension = $Imageaddress_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/categories/large/'.$filename;
                    $medium_image_path = 'images/backend_images/categories/medium/'.$filename;

                    //Resize Images
                    Image::make($Imageaddress_tmp)->save($large_image_path);
                    Image::make($Imageaddress_tmp)->resize(270,180)->save($medium_image_path);
                }
            }else{
                $filename = $data['current_image'];
            }
            Tourpackagecategory::where(['id'=>$id])->update([
                'CategoryName'=>$data['CategoryName'],
                'CategoryDescription'=>$data['CategoryDescription'],
                'meta_title'=>$data['meta_title'],
                'meta_description'=>$data['meta_description'],
                'meta_keywords'=>$data['meta_keywords'],
                'CategoryStatus'=>$CategoryStatus,
                'Imageaddress'=>$filename
            ]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category updated Successfully!');
        }
        $categoryDetails = Tourpackagecategory::where(['id'=>$id])->first();
        return view('admin.categories.edit_category')->with(compact('categoryDetails'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory($id = null)
    {
        if(Session::get('adminDetails')['Categories_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        // if(!empty($id)){
            Tourpackagecategory::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success', 'Category deleted Successfully!');
        //}
    }

    public function deleteCategoryImage($id = null)
    {
        $tourcategoryimage = Tourpackagecategory::where(['id'=>$id])->first();
        //echo $tourpackageimage->Imageaddress; die;
        $large_image_path = 'images/backend_images/categories/large/';
        $medium_image_path = 'images/backend_images/categories/medium/';

        //deleting large image if not exist in folder
        if(file_exists($large_image_path.$tourcategoryimage->Imageaddress)){
            unlink($large_image_path.$tourcategoryimage->Imageaddress);
        }

         //deleting medium image if not exist in folder
         if(file_exists($medium_image_path.$tourcategoryimage->Imageaddress)){
            unlink($medium_image_path.$tourcategoryimage->Imageaddress);
        }

        Tourpackagecategory:: where(['id'=>$id])->update(['Imageaddress'=>'']);
        return redirect()->back()->with('flash_message_success', 'Category Image has been deleted successfully!');
    }

}
