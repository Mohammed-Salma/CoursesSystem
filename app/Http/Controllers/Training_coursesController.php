<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTrainingCoursesRequest;
use App\Http\Requests\DoAddStudentToCourse;
use App\Models\Courses;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Models\Training_courses;
use App\Models\training_courses_enrolments;

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

    public function edit($id)
    {
        $data = Training_courses::find($id);
        if (empty($data)) {
            return redirect()->route('training_courses.index')->with('error', 'الدورة غير موجودة');
        }
        $courses = Courses::select("id", "name")->where('active', 1)->get();
        return view('training_courses.edit', ['data' => $data, 'courses' => $courses]);
    }

    public function update(CreateTrainingCoursesRequest $request, $id)
    {
        $dataCourse = Training_courses::find($id);
        if (empty($dataCourse)) {
            return redirect()->route('training_courses.index')->with('error', 'الدورة غير موجودة');
        }
        $dataCourse->courseID = $request->courseID;
        $dataCourse->start_date = $request->start_date;
        $dataCourse->end_date = $request->end_date;
        $dataCourse->price = $request->price;
        $dataCourse->note = $request->note;
        $dataCourse->save();
        return redirect()->route('training_courses.index')->with('success', 'تم تعديل الدورة بنجاح.');
    }

    public function destroy($id)
    {
        $dataCourse = Training_courses::find($id);
        if (empty($dataCourse)) {
            return redirect()->route('training_courses.index')->with('error', 'الدورة غير موجودة');
        }
        $dataCourse->delete();
        return redirect()->route('training_courses.index')->with('success', 'تم حذف الدورة بنجاح.');
    }

    public function details($id)
    {
        $dataCourse = Training_courses::find($id);
        if (empty($dataCourse)) {
            return redirect()->route('training_courses.index')->with('error', 'الدورة غير موجودة');
        }
        $dataCourse['course_name'] = Courses::where('id', '=', $dataCourse['courseID'])->value('name');
        $dataCourse['studentCounter'] = training_courses_enrolments::where('training_course_id', '=', $dataCourse['id'])->count();
        $training_courses_enrolments = training_courses_enrolments::select('*')->where('training_course_id', '=', $dataCourse['id'])->get();
        if (!empty($training_courses_enrolments)) {
            foreach ($training_courses_enrolments as $info) {
                $info->student_name = Students::where('id', '=', $info->studentID)->value('name');
            }
        }
        return view('training_courses.details', ['data' => $dataCourse, 'training_courses_enrolments' => $training_courses_enrolments]);
    }

    public function AddStudentToTrainingCourses($id)
    {
        $dataCourse = Training_courses::find($id);
        if (empty($dataCourse)) {
            return redirect()->route('training_courses.index')->with('error', 'عذرا غير قادر على الوصول للبيانات المطلوبة');
        }
        $students = Students::select("id", "name")->where('active', 1)->get();
        return view('training_courses.AddStudentToTrainingCourses', ['students' => $students, 'data' => $dataCourse]);
    }

    public function DoAddStudentToTrainingCourses($id, DoAddStudentToCourse $request)
    {
        $dataCourse = Training_courses::find($id);
        if (empty($dataCourse)) {
            return redirect()->route('training_courses.index')->with('error', 'عذرا غير قادر على الوصول للبيانات المطلوبة');
        }
        $studentCounter = training_courses_enrolments::where('training_course_id', '=', $dataCourse['id'])->where('studentID', '=', $request->studentID)->count();
        if ($studentCounter > 0) {
            return redirect()->route('training_courses.details', $id)->with('error', 'الطالب مسجل بالفعل في هذه الدورة');
        }
        $dataToInsert['training_course_id'] = $dataCourse['id'];
        $dataToInsert['studentID'] = $request->studentID;
        $dataToInsert['enrolment_date'] = $request->enrolment_date;
        training_courses_enrolments::insert($dataToInsert);
        return redirect()->route('training_courses.details', $id)->with('success', 'تم تسجيل الطالب في الدورة بنجاح.');
    }

    public function DeleteAddStudentFromTrainingCourses($id)
    {
        $data_training_courses_enrolments = training_courses_enrolments::find($id);
        if (empty($data_training_courses_enrolments)) {
            return redirect()->route('training_courses.index')->with('error', 'عذرا غير قادر على الوصول للبيانات المطلوبة');
        }
        $data_training_courses_enrolments->delete();
        return redirect()->route('training_courses.details', $data_training_courses_enrolments->training_course_id)->with('success', 'تم حذف الطالب من الدورة بنجاح.');
    }
}
