<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::prefix('comments')->group(function () {
    Route::get('/', [CommentController::class, "getAll"]);
    Route::get('/{id}', [CommentController::class, "getOne"]);
    Route::post('/', [CommentController::class, "createComment"]);
    Route::patch('/{id}', [CommentController::class, "updateComment"]);
    Route::delete('/{id}', [CommentController::class, "deleteComment"]);
});
