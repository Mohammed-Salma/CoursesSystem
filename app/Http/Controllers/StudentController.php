<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Students;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $data = Students::all();
        if (!empty($data)) {
            foreach ($data as $info) {
                // بهاي الطريقة ممكن نجيب اسم الدولة بدل ما نعرض رقم الدولة يعني بنقدر نستخدمها اذا بدي اجيب عمود واحد من الجدول واعطيه القيمة الي بدي ياها يلي هي اسم العمود
                $info->country_name = Countries::where('id', '=', $info->country_id)->value('name');
            }
        }
        return view('students.index', ['data' => $data]); //تمرير البيانات الى صفحة العرض + ممكن بدل كوباكت احط ['data' => $data]
    }
}
