@extends('Main_layout')

@section('title')
    الطلاب
@endsection

@section('content')
    <div class="col-12" style="background-color: white; padding: 15px;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="text-align: center; float: none;">بيانات الطلاب
                    <a href="{{ route('student.create') }}" class="button"
                        style="background-color: #04AA6D; color: white; padding: 10px; float: left;">إضافة طالب جديد</a>
                </h3>

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
            </div>
            <div class="card-body table-responsive p-0" style="height: auto;">

                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>اسم الطالب</th>
                                <th>الدولة</th>
                                <th>العنوان</th>
                                <th>الهاتف</th>
                                <th>الصورة</th>
                                <th>ملاحظات</th>
                                <th>حالة التفعيل</th>
                                <th>تاريخ الإضافة</th>
                                <th>تاريخ التحديث</th>
                                <th>التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->name }}</td>
                                    <td>{{ $info->country_name }}</td>
                                    <td>{{ $info->address }}</td>
                                    <td>{{ $info->phone }}</td>
                                    <td><img style="width: 70px; height: 70px;" src="{{ asset('uploads/mohamed.png') }}">
                                    </td>
                                    <td>{{ $info->note }}</td>
                                    <td>
                                        @if ($info->active == 1)
                                            مفعل
                                        @else
                                            معطل
                                        @endif
                                    </td>
                                    <td>{{ $info->created_at }}</td>
                                    <td>{{ $info->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('courses.edit', $info->id) }}" class="button"
                                            style="background-color: #04AA6D; color: white; padding: 5px">تعديل</a>
                                        <a href="{{ route('courses.destroy', $info->id) }}" class="button"
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
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
