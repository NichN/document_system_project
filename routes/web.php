<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cardcontroller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function(){
    return view('Student.homepage');
});
Route::get('/login',function(){
    return view('Student.loginform');
})->name('login');
/*Route::get('/document',function(){
    return view('Student.Document');
})->name('document');*/
Route::get('/document', [cardcontroller::class, 'showcard'])->name('document');
