<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Feedback;
use App\Tourpackages;
use Validator;

class FeedbackController extends Controller
{
    public function feedback(Request $request, $id = null){
        $feedbacks = Tourpackages::where(['id'=>$id])->first();

        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'UserEmail' => 'required|email',
                'Package_id' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $feedback = new Feedback;
            $feedback->Package_id =$data['Package_id'];
            $feedback->SurName = $data['SurName'];
            $feedback->OtherNames =$data['OtherNames'];
            $feedback->UserEmail =$data['UserEmail'];
            $feedback->Message =$data['Message'];
            $feedback->Status = 1;
            $feedback->save();

            //send Contact Email
            $UserEmail ="ghanatrek.toursite@gmail.com";
            $messageData = [
                'Package_id'=>$data['Package_id'],
                'SurName'=>$data['SurName'],
                'OtherNames'=>$data['OtherNames'],
                'UserEmail'=>$data['UserEmail'],
                'comment'=>$data['Message']
            ];
            Mail::send('emails.feedback', $messageData, function($message)use($UserEmail){
                $message->to($UserEmail)->subject('feedback from Ghanatrek');
            });
            return redirect()->back()->with('flash_message_success', 'Thanks for your feedback. We will get back to you soon.');


        }
        return view('tour.details')->with(compact('feedbacks'));
    }

    public function viewFeedback(){
        $feedbacks = Feedback::get();
        return view('admin.feedbacks.view_feedback')->with(compact('feedbacks'));
    }

    public function updateFeedbackStatus($id, $Status){
        Feedback::where('id', $id)->update(['Status'=>$Status]);
        return redirect()->back()->with('flash_message_success', 'Feddback Status has been updated');
    }

    public function deleteFeedback($id){
        Feedback::where('id', $id)->delete();
        return redirect()->back()->with('flash_message_success', 'Feedback has been deleted');
    }
}
