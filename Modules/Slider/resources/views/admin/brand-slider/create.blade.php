@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.sliders.index') }}">لیست اسلایدر های برند</a></li>
            <li class="breadcrumb-item active" aria-current="page">ثبت اسلایدر جدید</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ثبت اسلایدر جدید</p>
                </div>
                <div class="card-body">
                    <x-alert-danger></x-alert-danger>
                    <form action="{{ route('admin.brand-sliders.store') }}" method="post" class="save" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title" class="control-label">عنوان<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان اسلایدر اینجا وارد کنید" value="{{ old('title') }}" required autofocus>
                                </div>
                            </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">جایگاه<span class="text-danger">&starf;</span></label>
                                    <select class="form-control select2" name="type" required>
                                        <option selected disabled>-- انتخاب کنید --</option>
                                        <option value="up" @selected(old('type' == 'up'))>بالا</option>
                                        <option value="down" @selected(old('type' == 'down'))>پایین</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="link" class="control-label">لینک</label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="لینک اسلایدر اینجا وارد کنید" value="{{ old('link') }}"  autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="label" class="control-label">تصویر<span class="text-danger">&starf;</span></label>
                                    <input  class="form-control" type="file" name="image" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="label" class="control-label">لوگو<span class="text-danger">&starf;</span></label>
                                    <input  class="form-control" type="file" name="logo" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <span class="control-label ">
                                    وضعیت
                                </span>
                                <label style="cursor: pointer" class="custom-control custom-checkbox mr-1 mt-1">
                                    <input  type="checkbox" class="custom-control-input" name="status" value="1" {{ old('status', 1) == 1 ? 'checked' : null }}>
                                    <span class="custom-control-label">فعال</span>
                                </label>
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
