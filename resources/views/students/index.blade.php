@extends('Main_layout')

@section('title')
    الطلاب
@endsection

@section('content')
    <div class="col-12" style="background-color: white; padding: 15px;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="text-align: center; float: none;">بيانات الطلاب
                    <a href="{{ route('ar') }}">ar</a>
                    <a href="{{ route('en') }}">en</a>

                    {{-- Call Component and the first step is <x-component-name /> --}}
                    {{-- <x-alert /> --}}

                    <x-info-lable type="success" message="تم إضافة الطالب بنجاح." />
                    <x-info-lable type="error" message="تم حذف الطالب بنجاح." />

                    <x-info-lable-slot type="info">
                        Call Component With Slot
                    </x-info-lable-slot>


                    <a href="{{ route('student.create') }}" class="button"
                        style="background-color: #04AA6D; color: white; padding: 10px; float: left;">{{ __('mycustom.ADDNEW') }}</a>
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
                <div class="row">
                    <div class="col-md-3">
                        <label for="">بحث باسم الطالب</label>
                        <input type="text" name="searchByName" id="searchByName" placeholder="بحث باسم الطالب"
                            class="form-control">
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>البحث بحالة التفعيل</label>
                            <select name="active_search" id="active_search" class="form-control">
                                <option value="all">-- الكل --</option>
                                <option value="1">مفعل</option>
                                <option value="0">غير مفعل</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="height: auto;" id= "ajax_response_div">

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
                                        <td><img style="width: 70px; height: 70px;"
                                                src="{{ asset('uploads/' . $info->image) }}">
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
                                            <a href="{{ route('student.edit', $info->id) }}" class="button"
                                                style="background-color: #04AA6D; color: white; padding: 5px">تعديل</a>
                                            <a href="{{ route('student.destroy', $info->id) }}" class="button"
                                                style="background-color: #aa0704; color: white; padding: 5px">حذف</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="col-md-12">
                            <br>
                            {{ $data->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <p style="text-align: center; color: brown; margin-top: 10px">لا توجد بيانات لعرضها</p>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {

                function make_search() {
                    var name = $('#searchByName').val();
                    var active_search = $('#active_search').val();
                    jQuery.ajax({
                        url: '{{ route('student.ajax_search_student') }}',
                        type: 'POST',
                        'dataType': 'html',
                        cache: false,
                        data: {
                            "_token": '{{ csrf_token() }}',
                            name: name,
                            active_search: active_search
                        },
                        success: function(data) {
                            $("#ajax_response_div").html(data);
                        },
                        error: function() {

                        }
                    });
                }

                $(document).on('change', '#active_search', function(e) {

                    make_search();
                });

                $(document).on('input', '#searchByName', function(e) {
                    make_search();

                });
                $(document).on('click', '#ajax_pagination_in_search a', function(e) {
                    e.preventDefault();
                    var name = $('#searchByName').val();
                    var active_search = $('#active_search').val();
                    var url = $(this).attr('href');
                    jQuery.ajax({
                        url: url,
                        type: 'POST',
                        'dataType': 'html',
                        cache: false,
                        data: {
                            "_token": '{{ csrf_token() }}',
                            name: name,
                            active_search: active_search
                        },
                        success: function(data) {
                            $("#ajax_response_div").html(data);
                        },
                        error: function() {

                        }
                    });


                });
            });
        </script>
    @endsection

    {{-- @section('script')
    <script>
        $(document).ready(function() {
            $('#searchByName').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#example2 tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection --}}
