<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/register', [UserController::class, "register"]);
Route::post('users/login', [UserController::class, "login"]);
Route::get('comments', [CommentController::class, "getAll"]);
Route::get('comments/{id}', [CommentController::class, "getOne"]);
Route::post('comments', [CommentController::class, "createComment"]);
Route::patch('comments/{id}', [CommentController::class, "updateComment"]);
Route::delete('comments/{id}', [CommentController::class, "deleteComment"]);
