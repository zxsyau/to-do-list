<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'postLogin'])->name('postLogin');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('users')->group(function () {
    Route::get('/', [AdminController::class,'users'])->name('users');
    Route::get('/user-create', [AdminController::class,'createuser'])->name('createuser');
    Route::post('/user-create', [AdminController::class,'postUsers'])->name('postUsers');
    Route::get('/user-edit/{id}', [AdminController::class,'edituser'])->name('edituser');
    Route::post('/user-edit/{id}', [AdminController::class,'postEditUser'])->name('postEditUser');
    Route::delete('/user-delete/{id}', [AdminController::class,'postDeleteUser'])->name('postDeleteUser');
});

Route::prefix('job')->group(function () {
    Route::get('/detail{id}', [JobController::class,'detail'])->name('detail');
    Route::get('/create', [JobController::class,'createJob'])->name('createJob');
    Route::post('/create', [JobController::class,'postJob'])->name('postJob');
    Route::get('/{id}/edit', [JobController::class,'editJob'])->name('editJob');
    Route::post('/{id}/edit', [JobController::class,'postEditJob'])->name('postEditJob');
    Route::delete('/{id}/delete', [JobController::class,'deleteJob'])->name('deleteJob');
});

Route::prefix('task')->group(function () {
    Route::get('/{id}/detail', [TaskController::class,'detailTask'])->name('detailTask');
    Route::get('/{job_id}/create', [TaskController::class,'createTask'])->name('createTask');
    Route::post('/{job_id}/create', [TaskController::class,'postTask'])->name('postTask')   ;
    Route::get('/{id}/edit', [TaskController::class,'editTask'])->name('editTask');
    Route::post('/{id}/edit', [TaskController::class,'postEditTask'])->name('postEditTask');
    Route::delete('/{id}/delete', [TaskController::class,'deleteTask'])->name('deleteTask');
    Route::get('/{id}/assign', [TaskController::class,'assignWorker'])->name('assignWorker');
    Route::post('/{id}/assign', [TaskController::class,'postAssign'])->name('postAssign');
    Route::get('/{id}/upload-proof', [TaskController::class, 'uploadProof'])
        ->middleware('auth')
        ->name('uploadProof');
    Route::post('/{id}/upload-proof', [TaskController::class, 'postProof'])
        ->middleware('auth')
        ->name('postProof');
});
