<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){
        return view('admin.country.index');
    }

    // store country 
    public function store(Request $request){
        $request->validate([
            'name'=>['required','unique:countries,country_name']
        ]);
        
        Country::create([
            'country_name'=>$request->name,
        ]);
        return response()->json(['res'=>'Country Added Successfully']);
    }
    // get all data 
    public function allCountry(){
      $countries=  Country::with('states')->get();
    
      

      return response()->json(['data'=>$countries]);
    }
    // delete data 
    public function destroy($id){
      $delete=  Country::findOrFail($id)->delete();

      return response()->json(['data'=>$delete]);
    }

    // edit data 
    public function edit($id){
        $editData=Country::findOrFail($id);
        return response()->json(['data'=>$editData]);
    }

    public function update(Request $request){
        $data=$request->id;
        $request->validate([
            'name'=>['required','unique:countries,country_name,'.$data]
        ]);
        Country::findOrFail($data)->update([
            'country_name'=>$request->name,
        ]);
        return response()->json(['success'=>'Country Updated Successfully!']);
    }
}
