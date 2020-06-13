<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Cmspages;
use App\Enquiry;
use Validator;

class CmsController extends Controller
{
    public function addCsmPage(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $cmspage = new Cmspages;
            $cmspage->Title = $data['Title'];
            $cmspage->URL = $data['URL'];
            $cmspage->Description = $data['Description'];
            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status =1;
            }
            $cmspage->Status = $Status;
            $cmspage->save();
            return redirect()->back()->with('flash_message_success', 'CSM Page has been added successfully!');
        }
        return view('admin.pages.add_cms_page');
    }

    public function EditCsmPages(Request $request, $id){
        $cmspageDetails = Cmspages::where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status =1;
            }
            Cmspages::where('id',$id)->update([
                'Title'=>$data['Title'],
                'URL'=>$data['URL'],
                'Description'=>$data['Description'],
                'Status'=>$Status
            ]);
            return redirect('/admin/detail-cms/'.$id)->with('flash_message_success', 'Cms Page has been updated Successfully!');
        }
        return view('admin.pages.edit_cms_page')->with(compact('cmspageDetails'));
    }



    public function viewCsmPages(){
        $cmspage = Cmspages::get();
        $cmspage = json_decode(json_encode($cmspage));
        return view('admin.pages.view_cms_pages')->with(compact('cmspage'));
    }


    public function detailsCsmPages(Request $request, $id = null){
        $cmspageDetails = Cmspages::where(['id'=>$id])->first();
        // $cmspage = Cmspages::get();
        // $cmspage = json_decode(json_encode($cmspage));
        return view('admin.pages.detail_cms_page')->with(compact('cmspageDetails'));
    }



    public function deleteCmsPage($id){
        Cmspages::where('id',$id)->delete();
        return redirect('/admin/view-cms-pages')->with('flash_message_success', 'Cms Page has been deleted successfully!');
    }

    public function cmsPage($URL){
        //redirect to 404
        $cmsPageCount = CmsPages::where(['URL'=>$URL, 'Status'=>1])->count();
        if($cmsPageCount>0){

            //Get cms Page Details
            $cmsPagesDetails = Cmspages::where('URL',$URL)->first();
        }else{
            abort(404);
        }

        return view('pages.cms_page')->with(compact('cmsPagesDetails'));
    }


    public function contact(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'UserEmail' => 'required|email',
                'Subject' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $enquiry = new Enquiry;
            $enquiry->SurName = $data['SurName'];
            $enquiry->OtherNames =$data['OtherNames'];
            $enquiry->UserEmail =$data['UserEmail'];
            $enquiry->Subject =$data['Subject'];
            $enquiry->message =$data['message'];
            $enquiry->save();

            //send Contact Email
            $UserEmail ="ghanatrek.toursite@gmail.com";
            $messageData = [
                'SurName'=>$data['SurName'],
                'OtherNames'=>$data['OtherNames'],
                'UserEmail'=>$data['UserEmail'],
                'Subject'=>$data['Subject'],
                'comment'=>$data['message']
            ];
            Mail::send('emails.enquiry', $messageData, function($message)use($UserEmail){
                $message->to($UserEmail)->subject('Enquiry from Ghanatrek');
            });
            return redirect()->back()->with('flash_message_success', 'Thanks for your enquiry. We will get back to you soon.');
        }
        $meta_title = "Contact Us - GhanaTrek";
        $meta_description = "Contact Us for any queries related to our tour";
        $meta_keywords = "Contact Us, queries";
        return view('pages.contact')->with(compact('meta_title','meta_description','meta_keywords'));
    }

    public function addPost(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'UserEmail' => 'required|email',
                'Subject' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //dd($data);
            $enquiry = new Enquiry;
            $enquiry->SurName = $data['SurName'];
            $enquiry->OtherNames =$data['OtherNames'];
            $enquiry->UserEmail =$data['UserEmail'];
            $enquiry->Subject =$data['Subject'];
            $enquiry->message =$data['message'];
            $enquiry->save();
            echo "Thanks for contacting us. We will get back to you soon"; die;
        }
        return view('pages.post');
    }

    public function getEnquiries(){
        $enquiries = Enquiry::orderby('id', 'DESC')->get();
        $enquiries = json_encode($enquiries);
        return $enquiries;
    }

    public function viewEnquiries(){
        return view('admin.enquiries.view_enquiries');
    }

    public function getContact(){
        $contacts = Enquiry::get();
        return view('admin.enquiries.view_contacts')->with(compact('contacts'));
    }

    public function deleteContact($id){
        Enquiry::where('id', $id)->delete();
        return redirect()->back()->with('flash_message_success', 'Message has been deleted');
    }
}
