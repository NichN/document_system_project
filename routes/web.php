<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\cardcontroller;
=======
use App\Models\User;

>>>>>>> 0ebaae45de2f70d19200c58354a099040d655571
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

<<<<<<< HEAD
Route::get('/',function(){
    return view('Student.homepage');
});
Route::get('/login',function(){
    return view('Student.loginform');
})->name('login');
Route::get('/document', [cardcontroller::class, 'showcard'])->name('document');
Route::get('/document/detail',function(){
    return view('Student.document_detail');
})->name('detail');

Route::get('/admin',function(){
    return view('Admin.dashboard');
});
Route::get('/document/add',function(){
    return view('Admin.add');
})->name('create_document');
=======

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-token', function () {
    $user = User::find(1); // Replace with the ID of the user you want to generate a token for
    $token = $user->createToken('API Token')->accessToken;
    return ['token' => $token];
});
>>>>>>> 0ebaae45de2f70d19200c58354a099040d655571
