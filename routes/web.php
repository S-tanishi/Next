<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCreateController;
use App\Http\Controllers\CalendarController;

Route::get('/', function(){
    return view('welcome');
});

/**
 * カレンダー一覧表示
 */
Route::get('/next', [CalendarController::class, 'show'])->name("calendar");
/**
 * form遷移処理
 */
Route::get('/next/create', [TaskCreateController::class, 'showCreateForm']);
Route::post('/next/create', [TaskCreateController::class, 'store'])->name("store_task");
/**
 * 詳細表示機能
 */
Route::get('/next/tasks/{id}', [TaskController::class, 'show']);

Route::get('/{any}', function() {
    return view('app');
})->where('any', '.*');