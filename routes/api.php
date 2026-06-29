<?php

use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Students;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//test
Route::get('/student_from_api', function () {
    return response()->json([
        'Students' => Students::all()
    ]);
});


// هنعمل بشكل يدوي النوع اليدوي
//api manual
//courses api
Route::get('courses', [CourseController::class, 'index']);
Route::post('courses_store', [CourseController::class, 'store']);
Route::get('courses_show/{id}', [CourseController::class, 'show']);
Route::post('courses_update/{id}', [CourseController::class, 'update']);
Route::get('courses_delete/{id}', [CourseController::class, 'destroy']);
