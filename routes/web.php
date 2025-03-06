<?php

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\postController;
use App\Http\Controllers\FreindController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\redrecteController;

use App\Http\Controllers\Auth\FacebookController;

use App\Http\Controllers\QrCodeController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/registre' ,[redrecteController::class ,'index']);
Route::get('/connection',[redrecteController::class,'connection']);
Route::get('/dashboard',[profileController::class,'dashboard'])->name('index');
Route::get('/reset',[redrecteController::class,'reset']);
Route::get('/Suggestions',[FreindController::class,'Suggestions']);
Route::get('/index',[postController::class,'getAllPosts']);
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::get('/amis',[FreindController::class,'mesAmies']);

Route::get('/invitations',[FreindController::class,'showRequestEnvoye']);

Route::get('/profile/{id}',[profileController::class,'ToProfile'])->name('consulteProfile');

Route::post('/registreForm',[AuthController::class,'store'])->name('registreForm');
Route::post('/connectionForm',[AuthController::class,'connection'])->name('connectionForm');
Route::post('/uploadImage',[profileController::class,'upload'])->name('uploadImage');
Route::post('/addPost',[postController::class,'store'])->name('poste.store');
Route::post('/addFreind',[FreindController::class,'addFreind'])->name('addFreind');

Route::delete('/posts/{id}', [postController::class, 'destroy'])->name('posts.destroy');
Route::put('/posts/{id}', [postController::class, 'update'])->name('posts.update');


//


Route::get('/forgot-password', [redrecteController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
// Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


Route::post('/accepter',[FreindController::class,'AccepterFreind'])->name('AccepterInvitation');
Route::post('/refuser',[FreindController::class,'RefuserFreind'])->name('RefuserFreind');


Route::post('/addcomment',[CommentController::class,'store'])->name('addComment');

Route::post('/addLike',[LikeController::class,'store'])->name('addLike');


Route::get("auth/google", [GoogleController::class, "redirectToGoogle"])->name("redirect.google");
Route::get("auth/google/callback", [GoogleController::class, "handleGoogleCallback"]);

Route::get("auth/facebook", [FacebookController::class, "redirectToFacebook"])->name("redirect.facebook");
Route::get("auth/facebook/callback", [FacebookController::class, "handleFacebookCallback"]);

Route::get('/generate-qrcode', [QrCodeController::class, 'generate']);
Route::get('/add-friend/{user}', [FreindController::class, 'addFriendFromQr'])
    ->name('qrcode.addFriend');

