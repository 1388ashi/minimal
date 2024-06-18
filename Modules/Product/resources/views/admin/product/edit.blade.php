@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.products.index') }}">لیست محصول ها</a></li>
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

                    <form action="{{ route('admin.products.update',$product) }}" method="post">
                        @csrf
                        @method('PATCH')
                    <div id="app">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">عنوان<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="title" placeholder="عنوان محصول اینجا وارد کنید" value="{{ old('title', $product->title) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">دسته بندی ها</label><span class="text-danger">&starf;</span>
                                    <select class="form-control select2-example" name="categories[]" v-model="categories" v-on:change="getSpecifications" multiple>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}"  @selected(in_array($category->id, old('categories', $product->categories->pluck('id')->all())))>{{$category->title}}</option>
                                                <!-- نمایش دادن فرزندان هر والد -->
                                            @if($category->has('recursiveChildren'))
                                                @foreach($category->recursiveChildren as $item)
                                                    <option value="{{ $item->id }}"  @selected(in_array($item->id, old('categories', $product->categories->pluck('id')->all())))>-{{ $item->title }} </option>
                                                    @if($item->has('children'))
                                                    @foreach($item->children as $child)
                                                        <option value="{{ $child->id }}"  @selected(in_array($child->id, old('categories', $product->categories->pluck('id')->all())))>--{{ $child->title }}</option>
                                                    @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">قیمت(تومان)</label><span class="text-danger">&starf;</span>
                                    <input type="text" class="comma form-control" placeholder="مبلغ را وارد کنید" name="price" value="{{old('price', number_format($product->price))}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="label" class="control-label">تصویر</label>
                                    <input  class="form-control" type="file" name="image">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">ویدیو</label>
                                    <input class="form-control" type="file" name="video">
                                </div>
                            </div>
                            @if ($product->video['url'])
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-video-{{ $product->id }}')">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">تخفیف(تومان)</label>
                                    <input type="text" name="discount" class="comma form-control" placeholder="تخفیف را اینجا وارد کنید" value="{{old('discount', number_format($product->discount))}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label">خلاصه توضیحات</label>
                                    <textarea class="form-control" name="summary" cols="134" rows="3">{{$product->summary}}</textarea>
                                </div>
                            </div>
                            </div>
                        <div class="row">
                            <label class="control-label">توضیحات</label><span class="text-danger">&starf;</span>
                            <textarea name="description" id="editor2" class="form-control" cols="100"  rows="4">{{$product->description}}</textarea>
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
                            onclick="confirmDelete('delete-galleries-{{ $product->id }}')">
                                <i class="fa fa-times"></i>
                            </button>
                                <br>
                                <figure class="figure">
                                    <a target="blank" href="{{ $item['url'] }}">
                                    <img src="{{ $item['url'] }}" class="img-thumbnail" style="width: 70px;height: 70px;" />
                                    </a>
                                </figure>
                                @endforeach
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <span class="control-label ">
                                            وضعیت
                                        </span>
                                        <label class="custom-control custom-checkbox mr-1 mt-1">
                                            <input type="checkbox" class="custom-control-input" name="status" value="1"  @checked(old('status',$product->status) == '1')>
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
                                    <div style="background-color:{{$color->code}};width: 25px;height:25px;border-radius: 50%;margin-left: 6px;justify-content: center;"></div>
                                    <div class="form-group">
                                        <label class="custom-control custom-checkbox mr-1 mb-5">
                                            <input type="checkbox" class="custom-control-input" name="colors[]" value="{{$color->id}}" @checked(in_array($color->id, old('colors', $product->colors->pluck('id')->all())) == $color->id)>
                                            <span class="custom-control-label">فعال</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        <hr>    
                        <p class="ps-20">مشخصه ها</p>
                        <hr>
                        <div v-for="specification in specifications">
                            <div class="row">
                                <div class="col-1">
                                    <label class="mt-2">@{{ specification.name }}</label>
                                </div>

                                <div class="col-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="مقدار را وارد کنید"
                                        :name="'specifications[' + specification.id + ']'" :value="specification.value">
                                    </div>
                                </div>
                            </div>
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
        <form 
            action="{{ route('admin.products.galleries.destroy', $product) }}" 
            id="delete-galleries-{{$product->id}}" 
            method="POST" 
            style="display: none;">
            @csrf
            @method("DELETE")
        </form>
    @endif
@endsection
@section('scripts')
<script src="{{ asset('assets/plugins/vuejs/vue.js') }}"></script>
<script src="{{ asset('assets/plugins/vuejs/axios.min.js') }}"></script>
    <script>
        var app = new Vue({
            el: "#app",
            data: {
                categories: [],
                specifications: {!! json_encode($specifications)!!}

            },
            methods: {
                getSpecifications() {
                    let self = this;
                    self.specifications = [];
                    axios.post('/admin/get-specifications', {
                        categoryIds: this.categories,
                        productId: {{$product->id}}
                    })
                        .then(function (response) {
                            // handle success
                            let data = response.data;
                            self.specifications = data.specifications;
                            console.log(data.specifications)
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                }
            },
            mounted() {
                // $('.select2-example').select2({
                //     minimumResultsForSearch: Infinity,
                //     tags: true
                // });
                // var editor1 = new RichTextEditor("#editor2", {
                //     skin: "rounded-corner",
                //     toolbar: "full",
                // });
            },
            updated() {
                // $('.select2-example').select2({
                //     minimumResultsForSearch: Infinity,
                //     tags: true
                // });
                // var editor1 = new RichTextEditor("#editor2", {
                //     skin: "rounded-corner",
                //     toolbar: "full",
                // });
            }
        });


        $(document).ready(function () {

            $('input.comma').on('keyup', function(event) {
                if(event.which >= 37 && event.which <= 40) return;
                $(this).val(function(index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });
        });
    </script>
@endsection