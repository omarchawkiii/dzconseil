<?php

use App\Http\Controllers\ListingsController;
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

Route::middleware('auth:sanctum')->group(function () {
    //Route::apiResource('listings', ListingsController::class);
});

Route::apiResource('listings', ListingsController::class);
/*Route::get('listings' , [ListingsController::class, 'index'])->name('listings');

Route::get('listings/{listing}/' ,  [ListingsController::class, 'show'])->name('listings.show') ;
Route::post('listings' ,  [ListingsController::class, 'store'])->name('listings.store') ;
Route::put('listings/{listing}' ,  [ListingsController::class, 'update'])->name('listings.update') ;
Route::delete('listings/{listing}' ,  [ListingsController::class, 'destroy'])->name('listings.destroy') ;
*/
/*Route::get('listings/{task}/edit' ,  [App\Http\Controllers\TaskController::class, 'edit'])->name('listings.edit') ;
Route::put('listings/{task}/update' ,  [App\Http\Controllers\TaskController::class, 'update'])->name('listings.update') ;
Route::delete('listings/{task}/destroy' ,  [App\Http\Controllers\TaskController::class, 'destroy'])->name('task.destroy') ;
Route::get('category/{category}/tasks' , [App\Http\Controllers\TaskController::class, 'getTaskByCategory'])->name('category.tasks');
Route::get('search/{task}/tasks' , [App\Http\Controllers\TaskController::class, 'getTasksWithTerms'])->name('search.tasks');
Route::get('order/{column}/{direction}/tasks' , [App\Http\Controllers\TaskController::class, 'orderBy'])->name('order.tasks');*/

