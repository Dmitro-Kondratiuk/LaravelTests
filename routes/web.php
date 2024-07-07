<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'index'])->name('user');
Route::get('/user/getUsers', [UserController::class, 'getUsers'])->name('user.getUsers');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/add', [UserController::class, 'add'])->name('user.add');
