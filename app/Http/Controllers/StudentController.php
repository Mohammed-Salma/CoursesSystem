<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Models\Countries;
use App\Models\Students;
use App\Models\User;
use App\Notifications\CreateStudent;
use Illuminate\Http\Request;
use App\Traits\GeneralTraits;
use Illuminate\Support\Facades\Notification;

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
        try {
            // كود ممكن يتنفذ

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

            // ارسال اشعار لكل المستخدمسن في النظام
            $users = User::select('id')->get();
            $content = "تم اضافة طالب جديد باسم " . $request->name;
            Notification::send($users, new CreateStudent($request->name, $content));


            return redirect()->route('student.index')->with('success', 'تم إضافة الطالب بنجاح.');
        } catch (\Exception $e) {
            // كود هيتنفذ في حالة حدوث اي خطأ
            return redirect()->back()->with(['error' => 'حدث خطأ' . $e->getMessage()])->withInput();
        }
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
            $active_search = $request->active_search;
            if (empty($name)) {
                // اعمل شرط دائما يرجع قيمة true
                $filed1 = "id";
                $operator1 = ">";
                $value1 = 0;
            } else {
                $filed1 = "name";
                $operator1 = "LIKE";
                $value1 = "%{$name}%";
            }
            if ($active_search == "all") {
                $filed2 = "id";
                $operator2 = ">";
                $value2 = 0;
            } else {
                $filed2 = "active";
                $operator2 = "=";
                $value2 = $active_search;
            }
            $data = Students::where($filed1, $operator1, $value1)->where($filed2, $operator2, $value2)->paginate(1);
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
