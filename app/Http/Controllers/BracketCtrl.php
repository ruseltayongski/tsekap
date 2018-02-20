<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Bracket;
use App\BracketServices;

class BracketCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_priv');
    }

    public function index()
    {
        $keyword = Session::get('bracketKeyword');
        $brackets = Bracket::where('description','like',"%$keyword%")
            ->orderBy('id','asc')
            ->paginate(1);
        return view('bracket.index',[
            'brackets'=>$brackets
        ]);
    }

    public function search(Request $request)
    {
        Session::put('bracketKeyword',$request->keyword);
        return self::index();
    }

    public function assign(Request $req){
        $validate = BracketServices::where('bracket_id',$req->bracket)
                ->where('service_id',$req->services)
                ->first();
        if($validate){
            return redirect()->back()->with('status','duplicate');
        }

        $q = new BracketServices();
        $q->bracket_id = $req->bracket;
        $q->service_id = $req->services;
        $q->save();

        Session::put('bracket_id',$req->bracket);
        return redirect()->back()->with('status','added');
    }

    public function remove($id)
    {
        BracketServices::where('id',$id)->delete();
        return redirect()->back()->with('status','deleted');
    }
}
