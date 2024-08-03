<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BMIController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/bmi', [BMIController::class, 'showForm'])->name('bmi.form');
Route::post('/bmi/calculate', [BMIController::class, 'calculate'])->name('bmi.calculate');