<?php
namespace App\Models;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cardcontroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
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
    return view(view: 'Student.loginform');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth:api')->get('/auth/user', [AuthController::class, 'getUser']);


Route::get('/document', [cardcontroller::class, 'showcard'])->name('document');
//Route::get('/documents/{documentId}', [CommentController::class, 'show'])->name('document.show');

Route::get('/document/detail', function () {
    return view('Student.document_detail');
})->name('detail');

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

/*Route::get('/documents/create', [DocumentController::class, 'create'])->name('create_document');
Route::post('/documents', [DocumentController::class, 'store'])->name('store_document');
Route::get('/documents', [DocumentController::class, 'getDocuments'])->name('documents');*/

// For displaying the document list (dashboard)
//Route::get('/documents', [DocumentController::class, 'index'])->name('document_list');

// For creating a new document
/**oute::get('/documents/create', [DocumentController::class, 'create'])->name('create_document');*/

// For uploading the document (POST)
Route::get('/new_document',[DocumentController::class, 'create'])->name('new_document');
Route::get('/create_admin', [AdminController::class, 'store'])->name('create_admin');
Route::get('/edit_user/{id}', [AdminController::class, 'edit'])->name('edit_user');
Route::put('/edit_user/{id}', [AdminController::class, 'update'])->name('update_user');
Route::post('/document/detail/{documentId}', [CommentController::class, 'store'])->name('comment.store');

Route::get('/create_document', [DocumentController::class, 'store'])->name('upload_document');
Route::get('/edit_document/{id}', [DocumentController::class, 'edit'])->name('edit_document');
Route::put('/edit_document/{id}', [DocumentController::class, 'update'])->name('update_document');
/*Route::get('/document/detail/{id}', [DocumentController::class, 'show'])->name('Student.document_detail');*/

Route::delete('/documents_delete/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');

Route::get('/dashboard', function () {
    return view('Admin.dashboard');
})->name('document_dashboard');

