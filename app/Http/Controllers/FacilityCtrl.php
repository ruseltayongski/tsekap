<?php

namespace App\Http\Controllers;

use App\Facility;
use App\Facility2;
use App\AvailService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class FacilityCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        if($request->view_all == 'view_all')
            $keyword = null;
        else{
            if(Session::get("keyword")){
                if(!empty($request->keyword) && Session::get("keyword") != $request->keyword)
                    $keyword = $request->keyword;
                else
                    $keyword = Session::get("keyword");
            } else {
                $keyword = $request->keyword;
            }
        }

        Session::put('keyword',$keyword);

        $data = Facility::select(
            "facility.id",
            'facility.facility_code',
            "facility.name",
            "facility.address",
            "prov.id as province_id",
            "prov.description as province",
            "mun.description as muncity",
            "bar.description as barangay",
            "facility.contact",
            "facility.email",
            "facility.chief_hospital",
            "facility.level",
            "facility.hospital_type",
            "facility.status",
            "facility.referral_used",
            "info.service_cap",
            "info.phic_status",
            "info.sched_day_from",
            "info.sched_day_to",
            "info.sched_time_from",
            "info.sched_time_to",
            "info.sched_notes",
            "info.transport"
        )
            ->leftJoin("province as prov","prov.id","=","facility.province")
            ->leftJoin("muncity as mun","mun.id","=","facility.muncity")
            ->leftJoin("barangay as bar","bar.id","=","facility.brgy")
            ->leftJoin("tsekap_main.facility_add_info as info","info.facility_code","=","facility.facility_code");

        $province = Auth::user()->province;
        $muncity = Auth::user()->muncity;
        $user_priv = Auth::user()->user_priv;

        if($user_priv == 0 || $user_priv == 2)
            $data = $data->where('muncity',$muncity);
        else if($user_priv == 3)
            $data = $data->where('province',$province);

        if(isset($keyword))
            $data = $data->where('facility.name',"like","%$keyword%")->orWhere('facility.facility_code',"like","%$keyword%");

        $data = $data->orderBy('name','asc')
            ->paginate(20);

        $avail_services = AvailService::select(
            'service',
            'costing',
            'facility.facility_code',
            'facility.province',
            'facility.muncity',
            'type'
        )
            ->leftJoin('doh_referral.facility','facility.facility_code','=','available_services.facility_code');

        if($user_priv == 0 || $user_priv == 2)
            $avail_services = $avail_services->where('facility.muncity',$muncity)->get();
        else if($user_priv == 3)
            $avail_services = $avail_services->where('facility.province',$province)->get();

        return view('facility.facility',[
            'title' => 'List of Facilities',
            'data' => $data,
            'avail_services' => $avail_services,
            'dashboard' => (Auth::user()->user_priv == 3 || Auth::user()->user_priv == 1) ? 'app' : 'client'
        ]);
    }

    public function getFacility(Request $request) {
        $data = Facility::find($request->facility_id);
        $service = AvailService::where('facility_code', $request->facility_code)->get();
        $add_info = Facility2::where('facility_code', $request->facility_code)->first();
        return view('facility.facility_body',[
            "data" => $data,
            "services" => $service,
            "add_info" => $add_info
        ]);
    }

    public function addFacility(Request $request) {
        $data = $request->all();
        unset($data['_token']);

        AvailService::where('facility_code', $request->facility_code)->delete();
        $counter = 0;
        foreach($request->lab_services as $l) {
            $service = new AvailService();
            $service->facility_code = $request->facility_code;
            $service->service = $l;
            $service->costing = $request->lab_costing[$counter++];
            $service->type = 'Laboratory';
            $service->save();
        }
        $counter = 0;
        foreach($request->consultation as $s) {
            $service = new AvailService();
            $service->facility_code = $request->facility_code;
            $service->service = $s;
            $service->costing = $request->consultation_cost[$counter++];
            $service->type = 'Consultation';
            $service->save();
        }
        $counter = 0;
        foreach($request->dental as $s) {
            $service = new AvailService();
            $service->facility_code = $request->facility_code;
            $service->service = $s;
            $service->costing = $request->dental_cost[$counter++];
            $service->type = 'Dental';
            $service->save();
        }
        $counter = 0;
        foreach($request->abtc as $s) {
            $service = new AvailService();
            $service->facility_code = $request->facility_code;
            $service->service = $s;
            $service->costing = $request->abtc_cost[$counter++];
            $service->type = 'ABTC';
            $service->save();
        }
        $counter = 0;
        foreach($request->tb_dots as $s) {
            $service = new AvailService();
            $service->facility_code = $request->facility_code;
            $service->service = $s;
            $service->costing = $request->tb_dots_cost[$counter++];
            $service->type = 'TB DOTS';
            $service->save();
        }
        $counter = 0;
        foreach($request->fam_plan as $s) {
            $service = new AvailService();
            $service->facility_code = $request->facility_code;
            $service->service = $s;
            $service->costing = $request->fam_plan_cost[$counter++];
            $service->type = 'Family Planning';
            $service->save();
        }
        $counter = 0;
        foreach($request->other_services as $s) {
            $service = new AvailService();
            $service->facility_code = $request->facility_code;
            $service->service = $s;
            $service->costing = $request->other_cost[$counter++];
            $service->type = 'Other Services';
            $service->save();
        }
        unset($data['lab_services'], $data['lab_costing']);
        unset($data['consultation'], $data['consultation_cost']);
        unset($data['dental'], $data['dental_cost']);
        unset($data['abtc'], $data['abtc_cost']);
        unset($data['tb_dots'], $data['tb_dots_cost']);
        unset($data['fam_plan'], $data['fam_plan_cost']);
        unset($data['other_services'], $data['other_cost']);

        $fac = Facility2::where('facility_code', $request->facility_code)->first();

        if(!$fac)
            $fac = new Facility2();

        $fac->facility_code = $request->facility_code;
        $fac->service_cap = ($request->service_cap) ? $request->service_cap : null;
        $fac->phic_status = ($request->phic_status) ? $request->phic_status : '';
        $fac->sched_day_from = ($request->sched_day_from) ? $request->sched_day_from : null;
        $fac->sched_day_to = ($request->sched_day_to) ? $request->sched_day_to : null;
        $fac->sched_time_from = ($request->sched_time_from) ? $request->sched_time_from : null;
        $fac->sched_time_to = ($request->sched_time_to) ? $request->sched_time_to : null;
        $fac->sched_notes = ($request->sched_notes) ? $request->sched_notes : '';
        $fac->transport = ($request->transport) ? $request->transport : null;
        $fac->save();

        unset($data['service_cap']);
        unset($data['phic_status']);
        unset($data['sched_day_from']);
        unset($data['sched_day_to']);
        unset($data['sched_time_from']);
        unset($data['sched_time_to']);
        unset($data['sched_notes']);
        unset($data['transport']);

        if($request->id){
            Facility::find($request->id)->update($data);
            Session::put('facility_message','Successfully updated facility');
        } else {
            Facility::create($data);
            Session::put('facility_message','Successfully added facility');
        }

        Session::put('facility',true);
        return Redirect::back();
    }

    public function deleteFacility(Request $request) {
        Facility::find($request->facility_id)->delete();
        Facility2::where('facility_code', $request->facility_code)->delete();
        AvailService::where('facility_code', $request->facility_code)->delete();
        Session::put('facility_message','Successfully deleted facility');
        Session::put('facility',true);
        return Redirect::back();
    }
}