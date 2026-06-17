@extends('Main_layout')

@section('title')
    إضافة طالب للدورة
@endsection

@section('content')
    <div class="col-md-12">
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
                {{ Session::get('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('training_courses.DoAddStudentToTrainingCourses', $data['id']) }}"
            style="width: 80%; margin: 0 auto; background-color: white">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label>بيانات الطلاب</label>
                    <select name="studentID" id="studentID" class="form-control">
                        <option value="">اختر الطالب</option>
                        @if (!@empty($students))
                            @foreach ($students as $info)
                                <option value="{{ $info->id }}" @if (old('studentID') == $info->id) selected @endif>
                                    {{ $info->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('courseID')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="enrolment_date">تاريخ تسجيله في الدورة</label>
                    <input type="date" name="enrolment_date" class="form-control" id="enrolment_date"
                        value="@php echo date("Y-m-d"); @endphp" value="{{ old('enrolment_date') }}">
                    @error('enrolment_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" style="margin-bottom: 15px">أضف الطالب</button>

                        <a href="{{ route('training_courses.details', $data['id']) }}" class="button"
                            style="background-color: #c70707; color: white; padding: 5px">الغاء</a>
            </div>
    </div>
    <!-- /.card-body -->
    </form>
    </div>
@endsection
