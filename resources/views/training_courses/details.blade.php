@extends('Main_layout')

@section('title')
    تعديل دورة
@endsection

@section('content')
    <div class="col-md-12">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert" style="margin-top: 10px;">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="card-body" style="background-color: white !important">
            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <th>اسم الكورس</th>
                    <td>{{ $data['course_name'] }}</td>
                </tr>
                <tr>
                    <th>السعر</th>
                    <td>{{ $data['price'] * 1 . ' ILS' }}</td>
                </tr>
                <tr>
                    <th>تاريخ البداية</th>
                    <td>{{ $data['start_date'] }}</td>
                </tr>
                <tr>
                    <th>تاريخ الانتهاء</th>
                    <td>{{ $data['end_date'] }}</td>
                </tr>
                <tr>
                    <th>ملاحظات</th>
                    <td>{{ $data['note'] }}</td>
                </tr>
                <tr>
                    <th>عدد الطلاب المسجلين بالدورة</th>
                    <td>{{ $data['studentCounter'] * 1 }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="{{ route('training_courses.AddStudentToTrainingCourses', $data['id']) }}" class="button"
                            style="background-color: #04AA6D; color: white; padding: 5px">إضافة طالب للدورة</a>
                    </td>
                </tr>
            </table>
            @if (
                @isset($training_courses_enrolments) and
                    !@empty($training_courses_enrolments) and
                    count($training_courses_enrolments) > 0)
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>تاريخ التسجيل</th>
                            <th>تاريخ الإضافة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($training_courses_enrolments as $info)
                            <tr>
                                <td>{{ $info->student_name }}</td>
                                <td>{{ $info->enrolment_date }}</td>
                                <td>{{ $info->created_at }}</td>

                                <td>
                                    <a href="{{ route('training_courses.DeleteAddStudentFromTrainingCourses', $info->id) }}" class="button"
                                        style="background-color: #aa0704; color: white; padding: 5px">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: brown; margin-top: 10px">لا توجد بيانات لعرضها</p>
            @endif

        </div>


    </div>
@endsection
