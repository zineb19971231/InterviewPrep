<?php


use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Route;
// Route::post('/domains', [DomainController::class, 'store']);
Route::resource('domains', DomainController::class)->except(['show']);

Route::get('/', function () {
    return view('welcome');
});