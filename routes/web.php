<?php
use App\Models\Card;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/font-install', 'Admin\CompanyController@installFonts');
Route::get('/profile', function(){
    $card = Card::where('email', 'chitanokumar@gmail.com')->with('branch','package')->first();
    return view('card',compact('card'));
});
Route::get('/backend/{vue_capture?}', function(){
    return view('admin');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');


Route::post('/store', 'CardController@store');
