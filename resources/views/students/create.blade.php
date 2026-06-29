@extends('Main_layout')

@section('title')
    إضافة طالب جديد
@endsection

@section('content')
    <div class="col-md-12">
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
                {{ Session::get('error') }}
            </div>
        @endif
        <form method="POST" enctype="multipart/form-data" action="{{ route('student.store') }}"
            style="width: 80%; margin: 0 auto; background-color: white">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">اسم الطالب</label>
                    <input autofocus type="text" name="name" class="form-control" id="name"
                        value="{{ old('name') }}" placeholder="أدخل اسم الطالب">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الدولة</label>
                    <select name="country_id" id="country_id" class="form-control">
                        <option value="">اختر الدولة</option>
                        @if (!@empty($countries))
                            @foreach ($countries as $info)
                                <option @if (old('country_id') == $info->id) selected @endif value="{{ $info->id }}">
                                    {{ $info->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('country_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nationalID">الرقم القومي للهوية</label>
                    <input type="text" name="nationalID" class="form-control" id="nationalID"
                        value="{{ old('nationalID') }}" placeholder="أدخل الرقم القومي للهوية">
                    @error('nationalID')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">الهاتف</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}"
                        placeholder="أدخل هاتف الطالب">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}"
                        placeholder="أدخل عنوان الطالب">
                </div>

                <div class="form-group">
                    <label for="note">ملاحظات</label>
                    <input type="text" name="note" class="form-control" id="note" value="{{ old('note') }}">
                </div>

                <div class="form-group">
                    <label>حالة التفعيل</label>
                    <select name="active" id="active" class="form-control">
                        <option value="">اختر الحالة</option>
                        <option value="1" @if (old('active') == 1) selected @endif>مفعل</option>
                        <option value="0" @if (old('active') == 0 && old('active') != '') selected @endif>غير مفعل</option>
                    </select>
                    @error('active')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo">صورة الطالب</label>
                    <input type="file" name="photo" class="form-control" id="photo">
                </div>

            </div>
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" style="margin-bottom: 15px">أضف الطالب</button>
            </div>
    </div>
    <!-- /.card-body -->
    </form>
    </div>
@endsection
