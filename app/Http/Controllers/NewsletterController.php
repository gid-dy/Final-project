<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsletterSubscriber;
use App\Exports\subscribersExport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class NewsletterController extends Controller
{
    public function checkSubscriber(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $subcriberCount = NewsletterSubscriber::where('UserEmail',$data['newsletter_email'])->count();
            if($subcriberCount>0){
                echo "exists";
            }
        }
    }

    public function addSubscriber(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $subcriberCount = NewsletterSubscriber::where('UserEmail',$data['newsletter_email'])->count();
            if($subcriberCount>0){
                echo "exists";
            }else{
                //add user Newsletter Email
                $newsletter = new NewsletterSubscriber;
                $newsletter->UserEmail = $data['newsletter_email'];
                $newsletter->Status = 1;
                $newsletter->save();
                echo"saved";
            }
        }
    }

    public function viewSubscriber(){
        $newsletters = NewsletterSubscriber::get();
        return view('admin.newsletters.view_newsletter')->with(compact('newsletters'));
    }

    public function updateNewsletterStatus($id, $Status){
        NewsletterSubscriber::where('id', $id)->update(['Status'=>$Status]);
        return redirect()->back()->with('flash_message_success', 'Newsletter Status has been updated');
    }

    public function deleteNewsletterEmail($id){
        NewsletterSubscriber::where('id', $id)->delete();
        return redirect()->back()->with('flash_message_success', 'Newsletter email has been deleted');
    }

    // public function exportNewsletterEmails(){
    //     $subscriberData =  NewsletterSubscriber::select('id','UserEmail','created_at')->where('Status', 1)->orderby('id','DESC')->get();
    //     $subscriberData = json_decode(json_encode($subscriberData), true);

    //     return Excel::download('subscribers'.rand(),function($excel) use($subscriberData){
    //         $excel->sheet('mysheet',function($sheet) use($subscriberData){
    //             $sheet->fromArray($subscriberData ,null, 'A1', false, false);
    //         });

    //     })->subscribers('xlsx');
    // }

    public function exportNewsletterEmails(){
        return Excel::download(new subscribersExport,'subscribers.xlsx');
    }




}
