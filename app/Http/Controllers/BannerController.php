<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Image;

class BannerController extends Controller
{
    public function addbanner(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);

            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }
            $banner = new Banner;
            $banner->Title = $data['Title'];
            $banner->Link = $data['Link'];

             //upload image
             if($request->hasFile('Image')){
                $Image_tmp = $request->file('Image');
                if($Image_tmp->isValid()){
                    $extension = $Image_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $banner_path = 'images/frontend_images/banners/'.$filename;

                    Image::make($Image_tmp)->resize(1600,500)->save($banner_path);

                    //store image name in tours table
                    $banner->Image =$filename;
                }

            }
            $banner->Status =$Status;
            $banner->save();
            return redirect()->back()->with('flash_message_success', 'Banner has been added successfully');
        }
        return view('admin.banners.add_banner');
    }

    public function editbanner(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }
            if(empty($data['Title'])){
                $Title = "";
            };
            if(empty($data['Link'])){
                $Link = "";
            };

             //upload image
             if($request->hasFile('Image')){
                $Image_tmp = $request->file('Image');
                if($Image_tmp->isValid()){
                    $extension = $Image_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $banner_path = 'images/frontend_images/banners/'.$filename;
                    Image::make($Image_tmp)->resize(1600,500)->save($banner_path);

                }

            }else if(!empty($data['current_image'])){
                $fileName =$data['current_image'];
            }else{
                $fileName = '';
            }

            Banner::where('id', $id)->update([
                'Status'=>$Status,
                'Title'=>$data['Title'],
                'Link'=>$data['Link'],
                'Image'=>$fileName
                ]);
                return redirect()->back()->with('flash_message_success','Banner has been updated Successfully');
        }
        $bannerDetails = Banner::where('id', $id)->first();
        return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
    }

    public function viewbanners(){
        $banners = Banner::get();
        return view('admin.banners.view_banners')->with(compact('banners'));
    }
    public function deletebanner($id = null){
        Banner::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Banner has been deleted successfully');
    }


}
