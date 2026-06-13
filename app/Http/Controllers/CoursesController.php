<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseValidationRequest;
use Illuminate\Http\Request;
use App\Models\Courses;

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
}
