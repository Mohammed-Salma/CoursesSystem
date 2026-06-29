<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateStudentRequest;
use App\Models\Countries;
use App\Models\Students;
use App\Models\User;
use App\Notifications\CreateStudent;
use App\Traits\GeneralTraits;
use Illuminate\Support\Facades\Notification;

class StudentController extends Controller
{
    public function index()
    {
        $data = Students::paginate(4);
        if (!empty($data)) {
            foreach ($data as $info) {
                // بهاي الطريقة ممكن نجيب اسم الدولة بدل ما نعرض رقم الدولة يعني بنقدر نستخدمها اذا بدي اجيب عمود واحد من الجدول واعطيه القيمة الي بدي ياها يلي هي اسم العمود
                $info->country_name = Countries::where('id', '=', $info->country_id)->value('name');
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'تم جلب البيانات بنجاح',
            'data' => $data
        ], 200);
    }

    public function store(CreateStudentRequest $request)
    {
        try {
            // كود ممكن يتنفذ

            // لما يكون مسجل مادة ما بينفع نضيف غيرها
            $counter = Students::where('name', '=', $request->name)->count();
            if ($counter > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'اسم الطالب موجود بالفعل'
                ], 404);
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


            return response()->json([
                'status' => true,
                'message' => 'تم إضافة الطالب بنجاح',
                'data' => $student
            ], 200);
        } catch (\Exception $ex) {
            // كود هيتنفذ في حالة حدوث اي خطأ
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ' . $ex->getMessage()
            ], 500);
        }
    }

    public function update(CreateStudentRequest $request, $id)
    {
        $dataStudent = Students::find($id);
        if (empty($dataStudent)) {
            return response()->json([
                'status' => false,
                'message' => 'الطالب غير موجود'
            ], 404);
        }
        $dataStudent->name = $request->name;
        $dataStudent->country_id = $request->country_id;
        $dataStudent->phone = $request->phone;
        $dataStudent->nationalID = $request->nationalID;
        $dataStudent->address = $request->address;
        $dataStudent->note = $request->note;
        $dataStudent->active = $request->active;

        $dataStudent->save();

        return response()->json([
            'status' => true,
            'message' => 'تم تعديل الطالب بنجاح',
            'data' => $dataStudent
        ], 200);
    }

    public function destroy($id)
    {
        $dataStudent = Students::find($id);
        if (empty($dataStudent)) {
            return response()->json([
                'status' => false,
                'message' => 'الطالب غير موجود'
            ], 404);
        }
        $dataStudent->delete();
        return response()->json([
            'status' => true,
            'message' => 'تم حذف الطالب بنجاح',
        ], 200);
    }
}
