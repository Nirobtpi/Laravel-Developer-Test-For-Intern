<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

// Route::get('/{page?}', function ($page = null) {
//     $page = $page ?? 'index.html';

//     $path = public_path("html/{$page}");

//     if (File::exists($path)) {
//         return response()->file($path);
//     }

//     abort(404);
// });

Route::get('/', function () {
    return view('admin.country.index');
});
// index page link 
Route::get('/countires',[CountryController::class,'index'])->name('country.index');
// country store route 
Route::post('add/country',[CountryController::class,'store'])->name('country.store');
// all country view route 
Route::get('all-country',[CountryController::class,'allCountry'])->name('country.all');
// delete data 
Route::get('country/delete/{id}',[CountryController::class,'destroy'])->name('country.destroy');
// edit data 
Route::get('edit/data/{id}',[CountryController::class,'edit'])->name('country.edit');
Route::post('update',[CountryController::class,'update'])->name('country.edit');

// all state route here
Route::get('all-state',[StateController::class,'index'])->name('state.index');
Route::get('state',[StateController::class,'state'])->name('state.all');
Route::get('state/delete/{id}',[StateController::class,'destroy'])->name('state.delete');
Route::post('state/store',[StateController::class,'store'])->name('state.store');
Route::get('state/edit/{id}',[StateController::class,'editData'])->name('state.edit.data');
Route::post('state/update',[StateController::class,'update'])->name('state.update');

// all cities route here 
Route::get('cities',[CityController::class,'index'])->name('city.index');
Route::get('states/{id}',[CityController::class,'getStatesByCountry']);
Route::post('city/store',[CityController::class,'store'])->name('city.store');
Route::get('city/all',[CityController::class,'allCity'])->name('city.all');
Route::get('city/delete/{id}',[CityController::class,'cityDelete'])->name('city.delete');
Route::get('city/edit/{id}',[CityController::class,'cityedit'])->name('city.edit');
Route::post('city/update',[CityController::class,'update'])->name('city.update');
