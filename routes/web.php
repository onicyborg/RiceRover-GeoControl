<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LahanController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('login');

Route::get('/registrasi', function(){
    return view('registrasi');
});

Route::post('/registrasi', [AuthController::class, 'registrasi']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'role:user'], function () {
    Route::get('/user/dashboard', function () {
        return view('users.dashboard');
    });
    Route::get('/user/data-lahan', [LahanController::class, 'index']);
    Route::get('/user/add-lahan', function(){
        return view('users.input-data-lahan');
    });
    Route::post('/submit-data-lahan', [LahanController::class, 'store']);
    Route::get('/user/update-data-lahan/{id}', [LahanController::class, 'edit_lahan']);
    Route::put('/update-data-lahan/{id}', [LahanController::class, 'update']);
});

Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/admin/dashboard', function () {
        //
    });
});
