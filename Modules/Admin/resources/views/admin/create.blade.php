@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.admins.index') }}">لیست ادمین ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ثبت ادمین جدید</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ثبت ادمین جدید</p>
                </div>
                <div class="card-body">
                    <x-alert-danger></x-alert-danger>
                    <form action="{{ route('admin.admins.store') }}" method="post" class="save">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">نام<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="نام ادمین اینجا وارد کنید" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="label" class="control-label">شماره موبایل<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="شماره موبایل اینجا وارد کنید" value="{{ old('mobile') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">نقش ادمین</label><span class="text-danger">&starf;</span>
                                    <select class="form-control custom-select select2" data-placeholder="Select Package" name="role">
                                        <option selected disabled>- انتخاب کنید  -</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">کلمه عبور</label><span class="text-danger">&starf;</span>
                                    <input type="password" name="password" class="form-control" placeholder="کلمه عبور را اینجا وارد کنید" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"> تکرار کلمه عبور</label><span class="text-danger">&starf;</span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="کلمه عبور را دوباره اینجا وارد کنید" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label mr-3">وضعیت</label><span class="text-danger">&starf;</span>
                                    <br>
                                    <input type="checkbox" class="mt-1 mr-3" name="status" value="1" checked><span class="mr-2">فعال</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button class="btn btn-pink" type="submit">ثبت و ذخیره</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- col end -->
    </div>
    <!-- row closed -->
@endsection
