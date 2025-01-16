<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cardcontroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
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

Route::get('/', function () {
    return view('Student.homepage');
});
Route::get('/login', function () {
    return view('Student.loginform');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/document', [cardcontroller::class, 'showcard'])->name('document');
Route::get('/document/detail', function () {
    return view('Student.document_detail');
})->name('detail');

Route::get('/admin', function () {
    return view('Admin.dashboard');
});


/*Route::get('/document/add', function () {
    return view('Admin.add');
})->name('create_document');*/


Route::get('/profile', function () {
    return view('Admin.profile');
})->name('profile');

Route::get('/teacherlist', function () {
    return view('Admin.teacherlist');
})->name('teacherlist');

Route::get('/create_teacher', function () {
    return view('Admin.add_teacher');
})->name('create_teacher');

Route::get('/adminlist', function () {
    return view('Admin.adminlist');
})->name('adminlist');

Route::get('/create_admin', function () {
    return view('Admin.add_admin');
})->name('create_admin');

/*Route::get('/admin', [DocumentController::class, 'index'])->name('documents');
Route::get('/documents/create', [DocumentController::class, 'create'])->name('create_document');
Route::post('/admin', [DocumentController::class, 'store'])->name('store_document');
Route::get('/documents/upload', [DocumentController::class, 'uploadDocument'])->name('uploadDocument');
Route::post('/admin', [DocumentController::class, 'getDocuments'])->name('documents');*/

Route::get('/documents/create', [DocumentController::class, 'create'])->name('create_document');
Route::post('/documents', [DocumentController::class, 'store'])->name('store_document');
Route::get('/documents', [DocumentController::class, 'getDocuments'])->name('documents');

