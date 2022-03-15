<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\RegisterController;
use \App\Http\Controllers\ContactController;
use \App\Http\Controllers\VolunteersController;
use \App\Http\Controllers\CriticalCasesController;
use \App\Http\Controllers\UsersController;
use \App\Http\Controllers\InboxController;
use \App\Http\Controllers\Admin\UsersManagement;
use \App\Http\Controllers\Admin\CriticalCasesManagement;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('isauthenticated', [AuthController::class, 'isAuthenticated']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'contact'
], function ($router) {
    Route::post('send', [ContactController::class, 'store']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'volunteers'
], function ($router) {
    Route::get('/', [VolunteersController::class, 'index']);
    Route::post('/', [VolunteersController::class, 'store']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'criticalcases'
], function ($router) {
    Route::post('/', [CriticalCasesController::class, 'store']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function ($router) {
    Route::patch('/', [UsersController::class, 'update']);
    Route::delete('/', [UsersController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'inbox'
], function($router) {
   Route::get('/', [InboxController::class, 'getNotifications']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'admin'
], function ($router) {
    Route::get('/users', [UsersManagement::class, 'index']);
    Route::delete('/users/{id}', [UsersManagement::class, 'delete']);
    Route::get('/criticalcases', [CriticalCasesManagement::class, 'index']);
    Route::get('/criticalcases/{id}', [CriticalCasesManagement::class, 'show']);
    Route::delete('/criticalcases/{id}', [CriticalCasesManagement::class, 'delete']);
    Route::patch('/criticalcases/{id}', [CriticalCasesManagement::class, 'update']);
    Route::get('/checkadmin', [UsersManagement::class, 'checkAdmin']);
});
