<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class ServiceCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_priv');
    }

    public function index(){
        $keyword = Session::get('serviceKeyword');
        $services = Service::where('description','like',"%$keyword%")
            ->orWhere('code','like',"%$keyword%")
            ->orderBy('id','asc')
            ->paginate(20);
        return view('service.index',[
            'services'=>$services
        ]);
        return view('service.index');
    }

    public function search(Request $request)
    {
        Session::put('serviceKeyword',$request->keyword);
        return self::index();
    }

    public function save(Request $request)
    {
        $validateCode = Service::where('code',trim($request->code))->first();
        $validateDesc = Service::where('description',trim($request->description))->first();

        if($validateCode){
            return redirect('services?duplicate=code');
        }
        if($validateDesc){
            return redirect('services?duplicate=desc');
        }
        $q = new Service();
        $q->code = strtoupper($request->code);
        $q->description = $request->description;
        $q->save();
        Session::put('success',true);
        return redirect('services');
    }

    public function info($id){
        $info = Service::find($id);
        $delete = array(
            'table' => 'services',
            'id' => $id
        );
        Session::put('toDelete',$delete);
        return $info;
    }

    public  function update(Request $request)
    {
        $id = $request->currentID;

        $validateCode = Service::where('code',trim($request->code))->where('id','!=',$id)->first();
        $validateDesc = Service::where('description',trim($request->description))
            ->where('id','!=',$id)
            ->first();

        if($validateCode){
            return redirect('services?duplicate=code');
        }
        if($validateDesc){
            return redirect('services?duplicate=desc');
        }

        Service::where('id',$id)
            ->update([
                'code' => $request->code,
                'description' => $request->description
            ]);
        Session::put('update',true);
        return redirect('services');
    }
}
