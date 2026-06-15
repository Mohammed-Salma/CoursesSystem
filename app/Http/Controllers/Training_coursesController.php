<?php

namespace App\Http\Controllers;

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
}
