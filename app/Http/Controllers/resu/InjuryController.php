<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ResuNatureInjury;
use App\ResuBodyParts;
use App\ResuExternalInjury;
use App\ResuTransportAccident;
use App\ResuSafety;
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Support\Facades\Validator; //use validator for id

class InjuryController extends Controller
{
    //
    public function index(){
        $user = Auth::user();

        $injured = ResuNatureInjury::paginate(13);

        return view('resu.injury.nature_injury', [
            'injured' =>  $injured,
            'user_priv' => $user
        ]);
    }

    public function bodypart(){
        $user = Auth::user();
        
        $b_body = ResuBodyParts::paginate(13);
        
        return view('resu.partsbody.bodyparts', [
            'b_parts' => $b_body,
            'user_priv' => $user
        ]);
    }

    public function addinjury(Request $r)
    {
        $injured = new ResuNatureInjury();
        $injured->name = $r->name;
        $injured->save();

        return Redirect::back();
    }

    public function deleteInjury(Request $r) //nature injury
    {
        $name = $r->input('name'); 
        $injured = ResuNatureInjury::where('name', $name)->firstOrFail();
        $injured->delete();
        return Redirect::back()->with('success', 'Injury deleted successfully.');
    }
    
    public function editInjury($id)
    {
        $injured = ResuNatureInjury::findOrFail($id);
        $updateRoute = 'injury-update';
        return view('resu.injury.edit', [
            'entity' => $injured,
            'updateRoute' => $updateRoute
        ]);
    }

    public function updateInjury(Request $r, $id)
     {
            $validator = Validator::make($r->all(), [
                'name' => 'required|string|max:255',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $injury = ResuNatureInjury::findOrFail($id);
                $injury->name = $r->input('name');
                $injury->save();
                return redirect()->back()->with('success', 'Injury updated successfully.');
     }

    public function addbodypart(Request $r){
        $b_part = new ResuBodyParts();
        $b_part->name = $r->name;
        $b_part->save();
        return Redirect::back();
    }

    public function editBodyParts($id)
    {
        $b_part = ResuBodyParts::findOrFail($id);
        $updateRoute = 'update-body-parts';
        return view('resu.injury.edit', [
            'entity' => $b_part,
            'updateRoute' => $updateRoute
        ]);
       
    }
    public function updateBodyParts(Request $r, $id)
        {
            $validator = Validator::make($r->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $b_part = ResuBodyParts::findOrFail($id);
            $b_part->name = $r->input('name');
            $b_part->save();
            return redirect()->back()->with('success', 'Updated successfully.');
        }

    public function deleteBodyPart(Request $r)
        {
            $id = $r->input('id');
            $b_part = ResuBodyParts::findOrFail($id);
            $b_part->delete();
            return redirect()->back()->with('success', 'Body part deleted successfully.');
        }

    public function Listbodyparts(){

        $b_part = ResuBodyParts::all();

        return response()->json($b_part);
    }

    public function listExternal(){

        $external = ResuExternalInjury::paginate(13);
    
        return view('resu.injury.external_injury', [
            'external' => $external
        ]);
     }

    public function addExternal(Request $r){
       
        $external = new ResuExternalInjury();

        $external->name = $r->name;
        $external->save();

        return Redirect::back();
    }

    public function editExternalInjury($id)
    {
        // Fetch the injury record by ID
        $injured = ResuExternalInjury::findOrFail($id); 
        $updateRoute = 'injury-external-update';
        return view('resu.injury.edit', [
            'entity' => $injured, 
            'updateRoute' => $updateRoute
        ]);
    }

    public function updateExternalInjury(Request $r, $id)
    {
           $validator = Validator::make($r->all(), [
               'name' => 'required|string|max:255',
               ]);
               if ($validator->fails()) {
                   return redirect()->back()->withErrors($validator)->withInput();
               }
               $injury = ResuExternalInjury::findOrFail($id);
               $injury->name = $r->input('name');
               $injury->save();
               return redirect()->back()->with('success', 'Injury updated successfully.');
       }


    public function deleteExternalInjury(Request $r) //external injury
    {
        $name = $r->input('name'); 
        $injured = ResuExternalInjury::where('name', $name)->firstOrFail(); // Find the injury by name
        $injured->delete(); // Delete the injury from the database
        return Redirect::back()->with('success', 'Injury deleted successfully.');
    }

    public function viewAccident(){
        $rtaccident = ResuTransportAccident::paginate(13);

        return view('resu.accident.accident', [
            'accidentType' => $rtaccident
        ]);
    }

    public function AddAccidenttype(Request $req){

        $rtaccident = new ResuTransportAccident();

        $rtaccident->description = $req->Description;
        $rtaccident->save();

        return Redirect::back();

    }
    public function editAccidentType($id)
    {
        // Fetch the injury record by ID
        $rtaccident = ResuTransportAccident::findOrFail($id); 
        $updateRoute = 'update-accident-type';
        return view('resu.accident.edit', [
            'entity' => $rtaccident, 
            'updateRoute' => $updateRoute
        ]);
    }

    public function updateAccidentType(Request $r, $id)
    {
           $validator = Validator::make($r->all(), [
               'description' => 'required|string|max:255',
               ]);
               if ($validator->fails()) {
                   return redirect()->back()->withErrors($validator)->withInput();
               }
               $rtaccident = ResuExternalInjury::findOrFail($id);
               $rtaccident->description = $r->input('description');
               $rtaccident->save();
               return redirect()->back()->with('success', 'Updated successfully.');
       }


    public function deleteAccidentType(Request $req) //delete Accident Type
    {
        $description = $req->input('description'); 
        $rtaccident = ResuTransportAccident::where('description', $description)->firstOrFail(); // Find the injury by name
        $rtaccident->delete(); // Delete the accident from the database
        return Redirect::back()->with('success', 'Deleted successfully.');
    }

    public function safetyView(){
        $saftey = ResuSafety::paginate(13);
        return view('resu.accident.safety', [
            'safetytype' => $saftey 
        ]);
    }

    public function Savesafety(Request $req){

       $safety = new ResuSafety();

       $safety->name = $req->name;

       $safety->save();

       return Redirect::back();
    }
}
