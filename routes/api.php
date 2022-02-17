<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

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
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/trip', [Apicontroller::class, 'index'])->middleware('jwt.verify');
Route::get('/trip/delete/{id}', [Apicontroller::class, 'delete'])->middleware('jwt.verify');
Route::post('/trip/store', [Apicontroller::class, 'store'])->middleware('jwt.verify');
Route::post('/trip/update/{id}', [Apicontroller::class, 'update'])->middleware('jwt.verify');
