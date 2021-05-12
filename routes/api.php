<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\MvComptableController;
use App\Http\Controllers\API\MailController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FolderComptableController;
use App\Http\Controllers\API\BilanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/password/email', [ForgotPasswordController::class,'sendResetLinkEmail']);
Route::post('/password/reset', [ResetPasswordController::class ,'reset']);

Route::middleware(['auth:api'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('mvcomptable', MvComptableController::class);
    Route::put('/rec/{id}', [MvComptableController::class, 'rec']);

    Route::get('/filter',  [MvComptableController::class, 'filter'] );

    Route::post('/sendEmail', [MailController::class , 'sendEmail']);

    Route::resource('users',UserController::class);

    Route::resource('folders',FolderComptableController::class);

    Route::resource('bilans',BilanController::class);



});

Route::get('/email/resend',[VerificationController::class,'resend'])->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class,'verify'])->name('verification.verify');
