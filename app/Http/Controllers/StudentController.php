<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
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
    public function create()
    {
        $countries = Countries::select("id", "name")->where('active', 1)->get();
        return view('students.create', ['countries' => $countries]);
    }
    public function store(CreateStudentRequest $request)
    {
        // لما يكون مسجل مادة ما بينفع نضيف غيرها
        $counter = Students::where('name', '=', $request->name)->count();
        if ($counter > 0) {
            return redirect()->back()->with(['error' => 'اسم الطالب موجود بالفعل'])->withInput();
        }
        $student = new Students();
        $student->name = $request->name;
        $student->country_id = $request->country_id;
        $student->phone = $request->phone;
        $student->nationalID = $request->nationalID;
        $student->address = $request->address;
        $student->note = $request->note;
        $student->active = $request->active;
        $student->save();
        return redirect()->route('student.index')->with('success', 'تم إضافة الطالب بنجاح.');
    }
}
