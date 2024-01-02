<?php

Route::get('/', function (){
    return view('home');
});
Route::any('{slug}', function(){
    return view('welcome');
});


////Route::get("{any}", function(){
////    return "call";
////})->where("any", ".*");
///
Route::get('{path}', function (){
    return view('welcome');
})->where('path','([A-z\d\-\/_.]+)?');
//
//
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//
