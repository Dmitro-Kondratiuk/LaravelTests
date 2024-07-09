<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'index'])->name('user');
Route::get('/user/getUsers', [UserController::class, 'getUsers'])->name('user.getUsers');
Route::get('/user/getPositionsUsers', [UserController::class, 'getPositionsUsers'])->name('user.getPositionsUsers');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::post('/user/add', [UserController::class, 'add'])->name('user.add');
