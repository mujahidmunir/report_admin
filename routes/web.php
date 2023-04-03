<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
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

});

Route::group(['middleware' => ['auth:web', 'role:admin'], 'prefix' => 'admin'], function () {
        Route::get('report', [\App\Http\Controllers\Admin\ReportController::class, 'index']);
        Route::get('article', [\App\Http\Controllers\Admin\ReportController::class, 'article']);


});


