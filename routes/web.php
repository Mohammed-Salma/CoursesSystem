<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/mohamed/{last}/{age}', function ($last, $age) {
//     return 'welcome ' . $last . ' you are ' . $age . ' years old';
// })->where(['last' => '[A-Za-z]+', 'age' => '[0-9]+']);

Route::prefix('country')->group(function () {

    Route::get('/name/{name}', function ($name) {
        return 'welcome to ' . $name;
    });

    Route::get('/number/{number}', function ($number) {
        return 'welcome to country number ' . $number;
    });
});

// Courses Route
Route::get('courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('create_courses', [CoursesController::class, 'create'])->name('courses.create');
Route::post('store_courses', [CoursesController::class, 'store'])->name('courses.store');
Route::get('edit_courses/{id}', [CoursesController::class, 'edit'])->name('courses.edit');
Route::post('update_courses/{id}', [CoursesController::class, 'update'])->name('courses.update');
Route::get('destroy_courses/{id}', [CoursesController::class, 'destroy'])->name('courses.destroy');
