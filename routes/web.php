<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WorkScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth:web']], function (){
    Route::get('/', [DashboardController::class,'index']);
    Route::get('sub_cat/{id}', [ReportController::class, 'subCat']);
    Route::post('category', [ReportController::class, 'addCategory'])->name('addCategory');
    Route::resource('report', ReportController::class)->names('report');

    Route::get(
        '/work-schedules/events',
        [WorkScheduleController::class, 'events']
    )->name('work-schedules.events');

    Route::get(
        '/work-schedules/by-date',
        [WorkScheduleController::class, 'byDate']
    )->name('work-schedules.by-date');

    Route::post(
        '/work-schedules',
        [WorkScheduleController::class, 'store']
    )->name('work-schedules.store');

    Route::put(
        '/work-schedules',
        [WorkScheduleController::class, 'update']
    )->name('work-schedules.update');

    Route::delete(
        '/work-schedules/destroy-by-date',
        [WorkScheduleController::class, 'destroyByDate']
    )->name('work-schedules.destroy-by-date');

    Route::delete(
        '/work-schedules/{id}',
        [WorkScheduleController::class, 'destroy']
    )->name('work-schedules.destroy');

    Route::post(
        '/work-schedules/user-color',
        [WorkScheduleController::class, 'updateUserColor']
    )->name('work-schedules.user-color');
});

Route::group(['middleware' => ['auth:web', 'role:admin'], 'prefix' => 'admin'], function () {
        Route::get('report', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.report');
        Route::get('article', [\App\Http\Controllers\Admin\ReportController::class, 'article'])->name('admin.article');


});


