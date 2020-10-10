<?php

use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\ConversationReplyController;
use App\Http\Controllers\Api\ConversationUserController;
use App\Http\Controllers\ConversationController as ConservationView;
use App\Models\User;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {


   // User::factory()->count(50)->create();

    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('conversations',                [ConservationView::class, 'index']);
Route::get('conversations/{conversation}', [ConservationView::class, 'show']);



Route::group(['prefix' => 'webapi', 'namespace' => 'Api'], function () {
    Route::get('conversations',                       [ConversationController::class, 'index']);
    Route::post('conversations',                      [ConversationController::class, 'store']);
    Route::get('conversations/{conversation}',        [ConversationController::class, 'show']);

    Route::post('conversations/{conversation}/reply', [ConversationReplyController::class, 'store']);
    Route::post('conversations/{conversation}/users', [ConversationUserController::class, 'store']);


});
