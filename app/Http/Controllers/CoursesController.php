<?php

namespace App\Http\Controllers;

use App\Events\CourseAddEvent;
use App\Http\Requests\CreateCourseValidationRequest;
use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class CoursesController extends Controller
{
    public function index()
    {
        $data = Courses::all();
        return view('courses.index', compact('data')); //تمرير البيانات الى صفحة العرض + ممكن بدل كوباكت احط ['data' => $data]
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(CreateCourseValidationRequest $request)
    {
        // لما يكون مسجل مادة ما بينفع نضيف غيرها
        $counter = Courses::where('name', '=', $request->name)->count();
        if ($counter > 0) {
            return redirect()->back()->with(['error' => 'اسم الكورس موجود بالفعل'])->withInput();
        }
        $course = new Courses();
        $course->name = $request->name;
        $course->active = $request->active;
        $course->save();
        // نعمل اطلاق الجدث event
        event(new CourseAddEvent($request->name));

        //Send Email
        $data = [
            'name' => 'Mohamed',
            'email' => 'mohsalma.mt@gmail.com',
            'level' => 'advanced',
            'courses' => ['laravel', 'php', 'mysql'],
        ];
        Mail::to('mohsalma.mt@gmail.com')->send(new WelcomeMail($data));

        return redirect()->route('courses.index')->with('success', 'تم إضافة الكورس بنجاح.');


        // // هذا طريقة ممكن نستعملها برضه
        // $dataToInsert['name'] = $request->name;
        // $dataToInsert['active'] = $request->active;
        // Courses::create($dataToInsert);
        // return redirect()->route('courses.index')->with('success', 'Course created successfully.');


        // // هذا طريقة ممكن نستعملها برضهValidate the request data
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'active' => 'required|boolean',
        // ]);
        // // Create a new course using the validated data
        // Courses::create($validatedData);
        // // Redirect to the courses index page with a success message
        // return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit($id)
    {
        $data = Courses::find($id);
        if (empty($data)) {
            return redirect()->route('courses.index')->with('error', 'الكورس غير موجود');
        }
        return view('courses.edit', ['data' => $data]);
    }

    public function update(CreateCourseValidationRequest $request, $id)
    {
        $dataCourse = Courses::find($id);
        if (empty($dataCourse)) {
            return redirect()->route('courses.index')->with('error', 'الكورس غير موجود');
        }
        // لما يكون مسجل مادة ما بينفع نضيف غيرها
        $counter = Courses::where('name', '=', $request->name)->where('id', '!=', $id)->count();
        if ($counter > 0) {
            return redirect()->back()->with(['error' => 'اسم الكورس موجود بالفعل'])->withInput();
        }
        $dataCourse->name = $request->name;
        $dataCourse->active = $request->active;
        $dataCourse->save();
        return redirect()->route('courses.index')->with('success', 'تم تعديل الكورس بنجاح.');
    }

        public function destroy($id)
    {
        $dataCourse = Courses::find($id);
        if (empty($dataCourse)) {
            return redirect()->route('courses.index')->with('error', 'الكورس غير موجود');
        }
        $dataCourse->delete();
        return redirect()->route('courses.index')->with('success', 'تم حذف الكورس بنجاح.');
    }

}
