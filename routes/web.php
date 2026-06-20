<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Training_coursesController;
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

// Students Route
Route::get('student', [StudentController::class, 'index'])->name('student.index');
Route::get('create_student', [StudentController::class, 'create'])->name('student.create');
Route::post('store_student', [StudentController::class, 'store'])->name('student.store');
Route::get('edit_student/{id}', [StudentController::class, 'edit'])->name('student.edit');
Route::post('update_student/{id}', [StudentController::class, 'update'])->name('student.update');
Route::get('destroy_student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
Route::post('ajax_search_student', [StudentController::class, 'ajax_search_student'])->name('student.ajax_search_student');

// training_courses Route
Route::get('training_courses', [Training_coursesController::class, 'index'])->name('training_courses.index');
Route::get('create_training_courses', [Training_coursesController::class, 'create'])->name('training_courses.create');
Route::post('store_training_courses', [Training_coursesController::class, 'store'])->name('training_courses.store');
Route::get('edit_training_courses/{id}', [Training_coursesController::class, 'edit'])->name('training_courses.edit');
Route::post('update_training_courses/{id}', [Training_coursesController::class, 'update'])->name('training_courses.update');
Route::get('destroy_training_courses/{id}', [Training_coursesController::class, 'destroy'])->name('training_courses.destroy');
Route::get('details_training_courses/{id}', [Training_coursesController::class, 'details'])->name('training_courses.details');
Route::get('AddStudentToTrainingCourses/{id}', [Training_coursesController::class, 'AddStudentToTrainingCourses'])->name('training_courses.AddStudentToTrainingCourses');
Route::post('DoAddStudentToTrainingCourses/{id}', [Training_coursesController::class, 'DoAddStudentToTrainingCourses'])->name('training_courses.DoAddStudentToTrainingCourses');
Route::get('DeleteAddStudentFromTrainingCourses/{id}', [Training_coursesController::class, 'DeleteAddStudentFromTrainingCourses'])->name('training_courses.DeleteAddStudentFromTrainingCourses');



Route::get('ar', function(){
    session()->put('locale', 'ar');
    return redirect()->back();
})->name('ar');

Route::get('en', function(){
    session()->put('locale', 'en');
    return redirect()->back();
})->name('en');
