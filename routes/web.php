<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KreditController;

Route::get('/', function () {
    return view('simulasi-kredit');
});


Route::get('/simulasi-kredit', [KreditController::class, 'index'])->name('simulasi-kredit.index');
Route::post('/simulasi-kredit', [KreditController::class, 'hitung'])->name('simulasi-kredit.hitung');
