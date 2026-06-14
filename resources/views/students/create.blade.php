@extends('Main_layout')

@section('title')
    إضافة كورس جديد
@endsection

@section('content')
    <div class="col-md-12">
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
                {{ Session::get('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('courses.store') }}" style="width: 80%; margin: 0 auto; background-color: white">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">اسم الكورس</label>
                    <input autofocus type="text" name="name" class="form-control" id="name"
                        value="{{ old('name') }}" placeholder="ادخل اسم الكورس">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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
            </div>
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" style="margin-bottom: 15px">إضافة كورس</button>
            </div>
    </div>
    <!-- /.card-body -->
    </form>
    </div>
@endsection
