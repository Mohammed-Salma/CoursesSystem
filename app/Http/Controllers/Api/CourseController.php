<?php

namespace App\Http\Controllers\Api;

use App\Models\Courses;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCourseValidationRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $data = Courses::paginate(6);
        return response()->json([
            'status' => true,
            'message' => 'تم استرجاع الكورسات بنجاح',
            'data' => $data
        ], 200);
    }
    public function store(CreateCourseValidationRequest $request)
    {
        // لما يكون مسجل مادة ما بينفع نضيف غيرها
        $counter = Courses::where('name', '=', $request->name)->count();
        if ($counter > 0) {
            return response()->json([
                'status' => false,
                'message' => 'اسم الكورس موجود بالفعل',
            ], 422);
        }
        $course = new Courses();
        $course->name = $request->name;
        $course->active = $request->active;
        $course->save();

        return response()->json([
            'status' => true,
            'message' => 'تم اضافه الكورس بنجاح',
            'data' => $course
        ], 201);
    }

    public function show($id)
    {
        $data = Courses::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'الكورس غير موجود',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
