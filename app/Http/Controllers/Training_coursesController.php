<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTrainingCoursesRequest;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Models\Training_courses;

class Training_coursesController extends Controller
{
    public function index()
    {
        $data = Training_courses::all();
        if (!empty($data)) {
            foreach ($data as $info) {
                // بهاي الطريقة ممكن نجيب اسم الدولة بدل ما نعرض رقم الدولة يعني بنقدر نستخدمها اذا بدي اجيب عمود واحد من الجدول واعطيه القيمة الي بدي ياها يلي هي اسم العمود
                $info->course_name = Courses::where('id', '=', $info->courseID)->value('name');
            }
        }
        return view('training_courses.index', ['data' => $data]); //تمرير البيانات الى صفحة العرض + ممكن بدل كوباكت احط ['data' => $data]
    }

    public function create()
    {
        $courses = Courses::select("id", "name")->where('active', 1)->get();
        return view('training_courses.create', ['courses' => $courses]);
    }

    public function store(CreateTrainingCoursesRequest $request)
    {

        $course = new Training_courses();
        $course->courseID = $request->courseID;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->price = $request->price;
        $course->note = $request->note;
        $course->save();
        return redirect()->route('training_courses.index')->with('success', 'تم إضافة الدورة بنجاح.');
    }
}
