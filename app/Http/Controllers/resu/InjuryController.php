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

    // public function updateInjury(Request $r, $id)
    // {
    //         $injury = ResuNatureInjury::findOrFail($id);
    //         
    //         $validatedData = $r->validate([
    //             'name' => 'required|string|max:255',
    //         ]);
    //         $injury->name = $validatedData['name'];
    //         $injury->save();

    //         // Redirect back with success message
    //         return Redirect::back()->with('success', 'Update successfully.');
    // }


    public function deleteInjury(Request $r) //nature injury
    {
        $name = $r->input('name'); 
        $injured = ResuNatureInjury::where('name', $name)->firstOrFail(); // Find the injury by name
        $injured->delete(); // Delete the injury from the database
        return Redirect::back()->with('success', 'Injury deleted successfully.');
    }
    
    public function addbodypart(Request $r){
        
        $b_part = new ResuBodyParts();

        $b_part->name = $r->name;
        $b_part->save();

        return Redirect::back();
    }

    public function deleteBodyPart(Request $r)
        {
                    // Retrieve the ID from the request
            $id = $r->input('id');

            // Find the body part by its ID
            $b_part = ResuBodyParts::findOrFail($id);

            // Delete the body part
            $b_part->delete();

            // Redirect back with a success message
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
