@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i>
                    داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.products.index') }}">لیست
                    محصول ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ثبت محصول جدید</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ثبت محصول جدید</p>
                </div>
                <div class="card-body">
                    <x-alert-danger></x-alert-danger>
                    <form action="{{ route('admin.products.store') }}" method="post" class="save"
                          enctype="multipart/form-data">
                        @csrf

                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="control-label">عنوان<span
                                                class="text-danger">&starf;</span></label>
                                        <input type="text" class="form-control" name="title" id="title"
                                               placeholder="نام محصول اینجا وارد کنید" value="{{ old('title') }}"
                                               required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">دسته بندی ها</label><span class="text-danger">&starf;</span>
                                        <select class="form-control select2" id="categories" name="categories[]" required multiple>
                                            @foreach($allCategories as $id => $category)
                                                <option value="{{ $id }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">قیمت(تومان)</label><span class="text-danger">&starf;</span>
                                        <input type="text" class="comma form-control" placeholder="مبلغ را وارد کنید"
                                               name="price" value="{{old('price')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="label" class="control-label">تصویر اصلی</label><span
                                            class="text-danger">&starf;</span>
                                        <input class="form-control" type="file" name="image" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">ویدیو</label>
                                        <input class="form-control" type="file" name="video">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">تخفیف(تومان)</label>
                                        <input type="text" name="discount" class="comma form-control"
                                               placeholder="تخفیف را اینجا وارد کنید" value="{{old('discount')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="control-label">خلاصه توضیحات</label>
                                            <textarea class="form-control" name="summary" cols="134"
                                                      rows="3">{{old('summary')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">توضیحات</label><span class="text-danger">&starf;</span>
                                        <textarea name="description" class="form-control ckeditor" rows="4"
                                                  required>{{old('description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">گالری تصویر</label>
                                        <input type="file" name="galleries[]" class="form-control" multiple="multiple">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">برند</label><span class="text-danger">&starf;</span>
                                        <select class="form-control select2" name="brand_id">
                                            <option selected disabled>- انتخاب کنید  -</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <span class="control-label ">
                                            وضعیت
                                        </span>
                                        <label style="cursor: pointer" class="custom-control custom-checkbox mr-1 mt-1">
                                            <input type="checkbox" class="custom-control-input" name="status"
                                                   value="1"  {{ old('status', 1) == 1 ? 'checked' : null }}>
                                            <span class="custom-control-label">فعال</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p>رنگ ها</p>
                            <div class="row">
                                @foreach ($colors as $color)
                                    <div class="d-flex ml-5">
                                        <div
                                            style="background-color:{{$color->code}};width: 25px;height:25px;border-radius: 50%;margin-left: 6px;justify-content: center; border: 1px solid black;"></div>
                                        <div class="form-group">
                                            <label style="cursor: pointer"
                                                   class="custom-control custom-checkbox mr-1 mb-5">
                                                <input type="checkbox" class="custom-control-input" name="colors[]"
                                                       value="{{$color->id}}" @checked(old('colors') == $color->id)>
                                                <span class="custom-control-label">فعال</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <p>مشخصه ها</p>
                            <hr>
                            <div id="specifications">
                                <!-- Insert html with jQuery -->
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

@section('scripts')
    <script>
        $(document).ready(function () {

            $('#categories').on('input', function () {
                let categoryIds = $(this).val();
                $.post('/admin/get-specifications', {"categoryIds" : categoryIds}, function (data, status) {
                    let specifications = data.specifications;
                    let $html = '';

                    for (let i = 0; i < specifications.length; i++) {
                        $html += '<div class="row">';
                        $html += '<div class="col-1"><label class="mt-2">' + specifications[i].name + '</label></div>';
                        $html += '<div class="col-9"><div class="form-group">';
                        $html += '<input type="text" class="form-control" placeholder="مقدار را وارد کنید" name="specifications['+ specifications[i].id +']">';
                        $html += '</div></div>';
                        $html += '</div>';
                    }

                    $("#specifications").empty().html($html);

                }).fail(function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus);
                });
            });

        });

    </script>
@endsection
