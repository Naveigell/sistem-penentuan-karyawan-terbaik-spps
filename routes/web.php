<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/employees');
Route::name('admin.')->prefix('admin')->group(function () {
    Route::resource('criteria', \App\Http\Controllers\Admin\CriteriaController::class)->except('show');
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class)->except('show');
    Route::resource('employees.criteria', \App\Http\Controllers\Admin\EmployeeCriteriaController::class)
        ->shallow()
        ->parameters(['employee-criteria' => 'employee'])
        ->only('index', 'store');

    Route::name('decision-support-systems.')->prefix('decision-support-systems')->group(function () {
        Route::resource('topsis', \App\Http\Controllers\Admin\DecisionSupportSystem\TopsisController::class)->only('index');
    });
});
