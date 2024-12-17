<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        $countries=Country::all();
        $states=State::all();
        return view('admin.country.city',compact('countries','states'));
    }
    public function getStatesByCountry($country_id)
    {
       $states = State::where('country_id', $country_id)->get();

        return response()->json(['data'=>$states]);
    }

    public function store(Request $request){
        $request->validate([
            'state_id'=>['required'],
            'city'=>['required','unique:cities,city_name'],
        ]);
        City::create([
            'state_id'=>$request->state_id,
            'city_name'=>$request->city,
        ]);

       return response()->json(['success'=>'City Added Duccessfully']);
        
    }

    public function allCity(){
      $allData=  City::with('state','state.country')->get();
      return response()->json(['data'=>$allData]);
    }
    public function cityDelete($id){
        $delete=City::findOrFail($id)->delete();
        return response()->json(['delete'=>'Data Deleted Successfully']);
    }

    public function cityedit($id){
       $city=City::with('state','state.country')->findOrFail($id);

        return response()->json(['data'=>$city]);
    }
    public function update(Request $request){
        // return 'OOk';
        $id=$request->id;
        $request->validate([
            'state_id'=>['required'],
            'city'=>['required','unique:cities,city_name,'.$id],
        ]);
        City::findOrFail($id)->update([
            'state_id'=>$request->state_id,
            'city_name'=>$request->city,
        ]);
     

        return response()->json(['success'=>'Data Update Successfully']);
    }
}
