@extends('Main_layout')

@section('title')
    إضافة دورة جديد
@endsection

@section('content')
    <div class="col-md-12">
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
                {{ Session::get('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('training_courses.store') }}"
            style="width: 80%; margin: 0 auto; background-color: white">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label>الكورس المخصص للدورة</label>
                    <select name="courseID" id="courseID" class="form-control">
                        <option value="">اختر الكورس</option>
                        @if (!@empty($courses))
                            @foreach ($courses as $info)
                                <option value="{{ $info->id }}" @if (old('courseID') == $info->id) selected @endif>
                                    {{ $info->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('courseID')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">سعر الدورة</label>
                    <input type="text" name="price" class="form-control"
                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="price" value="{{ old('price') }}"
                        placeholder="أدخل سعر الدورة">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date">تاريخ بداية الدورة</label>
                    <input type="date" name="start_date" class="form-control" id="start_date"
                        value="{{ old('start_date') }}">
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">تاريخ انتهاء الدورة</label>
                    <input type="date" name="end_date" class="form-control" id="end_date" value="{{ old('end_date') }}">
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="note">ملاحظات</label>
                    <input type="text" name="note" class="form-control" id="note" value="{{ old('note') }}">
                </div>

            </div>
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" style="margin-bottom: 15px">أضف الدورة</button>
            </div>
    </div>
    <!-- /.card-body -->
    </form>
    </div>
@endsection
