<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        return view('admin.country.state');
    }

    // store state 
    public function store(Request $request){
        $request->validate([
            'country_id'=>['required'],
            'state_name'=>['required','unique:states,name'],
        ]);
        State::create([
            'country_id'=>$request->country_id,
            'name'=>$request->state_name,
        ]);
         return response()->json(['res'=>'State Added Successfully']);
        
    }
    public function state(){
        $state=State::with('country')->get();

        return response()->json(['data'=>$state]);
    }

    public function destroy($id){
        $delete=State::findOrFail($id)->delete();
        return response()->json(['data'=>$delete]);
    }

    public function editData($id){
        $data=State::findOrFail($id);
        $countries = Country::all(); 

        return response()->json(['data'=>$data,'countries'=>$countries]);
    }
    public function update(Request $request){
        $id=$request->id;
        $request->validate([
            'country_id'=>['required'],
            'state_name'=>['required','unique:states,name,'.$id],
        ]);

        State::findOrFail($id)->update([
            'country_id'=>$request->country_id,
            'name'=>$request->state_name,
        ]);

        return response()->json(['success'=>'State Update Successfully']);
    }
}
