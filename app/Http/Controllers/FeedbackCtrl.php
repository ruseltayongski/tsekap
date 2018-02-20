<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Feedback;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class FeedbackCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_priv');
    }

    public function index()
    {
        $feedback = Feedback::orderBy('created_at','desc')->paginate(10);
        return view('report.feedback',['feedback' => $feedback]);
    }

    public function view($id)
    {
        Session::put('feedbackID',$id);
        $record = Feedback::find($id);
        $user_id = $record->user_id;
        $message = $record->message;

        $user = User::find($user_id);
        $name = $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->suffix;

        return array(
            'sender' => $name,
            'message' => $message,
            'remarks' => $record->remarks,
        );
    }

    public function status(Request $req)
    {
        $id = $req->currentID;
        if($req->done){
            Feedback::where('id',$id)
                ->update(['status' => 1 , 'remarks' => $req->remarks ]);
            return redirect()->back()->with('status','done');
        }

        if($req->pending){
            Feedback::where('id',$id)
                ->update(['status' => 0 , 'remarks' => $req->remarks ]);
            return redirect()->back()->with('pending','done');
        }

        if($req->seen){
            Feedback::where('id',$id)
                ->update(['status' => 2 , 'remarks' => $req->remarks ]);
            return redirect()->back()->with('pending','done');
        }

        if($req->remove){
            $id = Session::get('feedbackID');
            Feedback::where('id',$id)->delete();
            return redirect()->back()->with('status','remove');
        }
    }
}
