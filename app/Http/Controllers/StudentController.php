<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Models\Countries;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Traits\GeneralTraits;

class StudentController extends Controller
{
    use GeneralTraits;
    public function index()
    {
        // هنا لما بدي استخدم دوال عليها طلب كثير وبستخدمها كثير عندي بالكود برضه بلجأ لطريقة التريت
        $this->mohamed();

        // بهاي الطريقة بقدر استدعي اي دالة انا بسويها وبقدر استخدمها باي مكان بالكود عندي
        // mohamed_soft();
        session()->put('locale', 'ar');
        $data = Students::paginate(2);
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
        // mohamed_soft();
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
        // Upload the image if it exists
        if ($request->hasFile('photo')) {
            $image = $request->photo;
            $extension = strtolower($image->extension());
            $filename = time() . rand(1, 1000) . '.' . $extension;
            // $image->getClientOriginalName = $filename;
            $image->move(public_path('uploads'), $filename);
            $student->image = $filename;
        }
        $student->save();
        return redirect()->route('student.index')->with('success', 'تم إضافة الطالب بنجاح.');
    }

    public function edit($id)
    {
        $data = Students::find($id);
        if (empty($data)) {
            return redirect()->route('student.index')->with('error', 'الكورس غير موجود');
        }
        $countries = Countries::select("id", "name")->where('active', 1)->get();
        return view('students.edit', ['data' => $data, 'countries' => $countries]);
    }

    public function update(CreateStudentRequest $request, $id)
    {
        $dataStudent = Students::find($id);
        if (empty($dataStudent)) {
            return redirect()->route('student.index')->with('error', 'الطالب غير موجود');
        }
        $dataStudent->name = $request->name;
        $dataStudent->country_id = $request->country_id;
        $dataStudent->phone = $request->phone;
        $dataStudent->nationalID = $request->nationalID;
        $dataStudent->address = $request->address;
        $dataStudent->note = $request->note;
        $dataStudent->active = $request->active;
        // Upload the image if it exists
        if ($request->hasFile('photo')) {
            $image = $request->photo;
            $extension = strtolower($image->extension());
            $filename = time() . rand(1, 1000) . '.' . $extension;
            // $image->getClientOriginalName = $filename;
            $image->move(public_path('uploads'), $filename);
            $dataStudent->image = $filename;
        }
        $dataStudent->save();
        return redirect()->route('student.index')->with('success', 'تم تعديل الطالب بنجاح.');
    }

    public function destroy($id)
    {
        $dataStudent = Students::find($id);
        if (empty($dataStudent)) {
            return redirect()->route('student.index')->with('error', 'الطالب غير موجود');
        }
        $dataStudent->delete();
        return redirect()->route('student.index')->with('success', 'تم حذف الطالب بنجاح.');
    }

    public function ajax_search_student(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->name;
            $data = Students::where('name', 'LIKE', "%{$name}%")->paginate(1);
            if (!empty($data)) {
                foreach ($data as $info) {
                    // بهاي الطريقة ممكن نجيب اسم الدولة بدل ما نعرض رقم الدولة يعني بنقدر نستخدمها اذا بدي اجيب عمود واحد من الجدول واعطيه القيمة الي بدي ياها يلي هي اسم العمود
                    $info->country_name = Countries::where('id', '=', $info->country_id)->value('name');
                }
            }
            return view('students.ajax_search_student', ['data' => $data]);
        }
    }
}
