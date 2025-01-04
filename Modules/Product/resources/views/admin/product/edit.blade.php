@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i>
                    داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.products.index') }}">لیست
                    محصول ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ویرایش محصول</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ویرایش محصول</p>
                </div>
                <div class="card-body">

                    <x-alert-danger></x-alert-danger>

                    <form action="{{ route('admin.products.update',$product) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div id="app">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="control-label">عنوان<span
                                                class="text-danger">&starf;</span></label>
                                        <input type="text" class="form-control" name="title"
                                               placeholder="عنوان محصول اینجا وارد کنید"
                                               value="{{ old('title', $product->title) }}" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">دسته بندی ها</label><span class="text-danger">&starf;</span>
                                        <select class="form-control select2" id="categories" name="categories[]"
                                                required multiple>
                                            @foreach($allCategories as $id => $category)
                                                <option
                                                    value="{{ $id }}" @selected($product->categories->contains($id))>{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">قیمت(تومان)</label><span class="text-danger">&starf;</span>
                                        <input type="text" class="comma form-control" placeholder="مبلغ را وارد کنید"
                                               name="price" value="{{old('price', number_format($product->price))}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="label" class="control-label">تصویر</label>
                                        <input class="form-control" type="file" name="image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">تخفیف(تومان)</label>
                                        <input type="text" name="discount" class="comma form-control"
                                               placeholder="تخفیف را اینجا وارد کنید"
                                               value="{{old('discount', number_format($product->discount))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ویدیو</label>
                                        <input class="form-control" type="file" name="video">
                                    </div>
                                </div>
                                @if ($product->video['url'])
                                    <div class="col-md-6 d-flex" style="margin-top: 2rem">
                                        <button type="button" class="btn btn-danger btn-sm ml-1 d-flex"
                                                style="height: fit-content;justify-content: center;align-items: center;"
                                                onclick="confirmDelete('delete-video-{{ $product->id }}')">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        <br>
                                        <figure class="figure">
                                            <a target="blank" href="{{ $product->video['url'] }}">
                                                {{$product->video['name']}}
                                            </a>
                                        </figure>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="control-label">خلاصه توضیحات</label>
                                            <textarea class="form-control" name="summary" cols="134"
                                                rows="3">{{old('summary', $product->summary)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="control-label">توضیحات</label><span
                                            class="text-danger">&starf;</span>
                                        <textarea name="description" class="form-control ckeditor" rows="4"
                                            required>{{old('description', $product->description)}}</textarea>
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
                                @if ($product->galleries)
                                    @foreach($product->galleries as $item)
                                        <button type="button" style="height: fit-content;" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('delete-galleries-{{$item['id'] }}')">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <br>
                                        <figure class="figure">
                                            <a target="_blank" href="{{ $item['url'] }}">
                                                <img src="{{ $item['url'] }}" class="img-thumbnail"
                                                     style="width: 70px;height: 70px;"/>
                                            </a>
                                        </figure>
                                    @endforeach
                                @endif
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">برند</label><span class="text-danger">&starf;</span>
                                        <select class="form-control select2" name="brand_id">
                                        @if (!$product->brand_id)
                                             <option value="" selected>- انتخاب کنید -</option>
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" 
                                                @selected($brand->id == $product->category_id)>{{$brand->title}}</option>
                                            @endforeach
                                        @else
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" 
                                                @selected($brand->id == $product->category_id)>{{$brand->title}}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                        <span class="control-label ">
                                            وضعیت
                                        </span>
                                            <label style="cursor: pointer"
                                                   class="custom-control custom-checkbox mr-1 mt-1">
                                                <input type="checkbox" class="custom-control-input" name="status"
                                                       value="1" @checked(old('status',$product->status) == '1') checked>
                                                <span class="custom-control-label">فعال</span>
                                            </label>
                                        </div>
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
                                            <label class="custom-control custom-checkbox mr-1 mb-5">
                                                <input type="checkbox" class="custom-control-input" name="colors[]"
                                                       value="{{$color->id}}" @checked(in_array($color->id, old('colors', $product->colors->pluck('id')->all())) == $color->id)>
                                                <span class="custom-control-label">فعال</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <p class="ps-20">مشخصه ها</p>
                            <hr>
                            <div id="specifications">
                                @if($specifications)
                                    @foreach($specifications as $specification)
                                        <div class="row">
                                            <div class="col-1">
                                                <label class="mt-2">{{ $specification->name }}</label>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                           placeholder="مقدار را وارد کنید"
                                                           name="specifications[{{ $specification->id }}]"
                                                           value="{{ $product->specifications->contains($specification->id) ? $product->specifications->where('id', $specification->id)->first()->pivot->value : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <!-- Insert html with jQuery -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button class="btn btn-warning" type="submit">به روزرسانی</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- col end -->
    </div>
    <!-- row closed -->
    @if ($product->video['url'])
        <form
            action="{{ route('admin.products.video.destroy', $product) }}"
            id="delete-video-{{$product->id}}"
            method="POST"
            style="display: none;">
            @csrf
            @method("DELETE")
        </form>
    @endif
    @if ($product->galleries)
        @foreach ($product->galleries as $media)
            <form
                action="{{ route('admin.products.galleries.destroy', $media) }}"
                id="delete-galleries-{{$media['id']}}"
                method="POST"
                style="display: none;">
                @csrf
                @method("DELETE")
            </form>
        @endforeach
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            $('#categories').on('input', function () {
                let categoryIds = $(this).val();
                $.post('/admin/get-specifications', {
                    "categoryIds": categoryIds,
                    "productId": "{{ $product->id }}"
                }, function (data, status) {
                    let specifications = data.specifications;
                    let $html = '';

                    for (let i = 0; i < specifications.length; i++) {
                        $html += '<div class="row">';
                        $html += '<div class="col-1"><label class="mt-2">' + specifications[i].name + '</label></div>';
                        $html += '<div class="col-9"><div class="form-group">';
                        $html += '<input type="text" class="form-control" placeholder="مقدار را وارد کنید" name="specifications[' + specifications[i].id + ']" value="' + specifications[i].value + '">';
                        $html += '</div></div>';
                        $html += '</div>';
                    }

                    $("#specifications").html($html);

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                });
            });

        });

    </script>
@endsection
