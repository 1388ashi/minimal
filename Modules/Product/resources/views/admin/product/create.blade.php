    @extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.products.index') }}">لیست محصول ها</a></li>
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
                    <form action="{{ route('admin.products.store') }}" method="post" class="save" enctype="multipart/form-data">
                        @csrf
                        
                        <div id="app" >
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="control-label">عنوان<span class="text-danger">&starf;</span></label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="نام محصول اینجا وارد کنید" value="{{ old('title') }}" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">دسته بندی ها</label><span class="text-danger">&starf;</span>
                                        <select class="form-control select2-example" name="categories[]" v-model="categories" v-on:change="getSpecifications" multiple>             
                                            @foreach($categories as $category)
                                            <option  value="{{$category->id}}" @if(is_array(old('categories')) && in_array($category->id, old('categories'))) selected @endif>{{$category->title}}</option>
                                                    <!-- نمایش دادن فرزندان هر والد -->
                                                @if($category->has('recursiveChildren'))
                                                    @foreach($category->recursiveChildren as $item)
                                                        <option value="{{ $item->id }}" @if(is_array(old('categories')) && in_array($item->id, old('categories'))) selected @endif>-{{ $item->title }} </option>
                                                        @if($item->has('children'))
                                                        @foreach($item->children as $child)
                                                            <option value="{{ $child->id }}" @if(is_array(old('categories')) && in_array($child->id, old('categories'))) selected @endif> --{{ $child->title }}</option>
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
                                        <input type="text" class="comma form-control" placeholder="مبلغ را وارد کنید" name="price" value="{{old('price')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="label" class="control-label">تصویر اصلی</label><span class="text-danger">&starf;</span>
                                        <input  class="form-control" type="file" name="image" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">ویدیو</label>
                                        <input class="form-control" type="file" name="video" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">تخفیف(تومان)</label>
                                        <input type="text" name="discount" class="comma form-control" placeholder="تخفیف را اینجا وارد کنید" value="{{old('discount')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label">خلاصه توضیحات</label>
                                    <textarea class="form-control" name="summary" cols="134" rows="3" >{{old('summary')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="form-group">
                                <label class="control-label">توضیحات</label><span class="text-danger">&starf;</>
                                <textarea name="description" id="editor2" cols="100" rows="4" required>{{old('description')}}</textarea>
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
                                        <span class="control-label ">
                                            وضعیت
                                        </span>
                                        <span class="text-danger">&starf;</span>
                                        <label class="custom-control custom-checkbox mr-1 mt-1">
                                            <input type="checkbox" class="custom-control-input" name="status" value="1" checked>
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
                                        <div style="background-color:{{$color->code}};width: 25px;height:25px;border-radius: 50%;margin-left: 6px;justify-content: center;"></div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox mr-1 mb-5">
                                                <input type="checkbox" class="custom-control-input" name="colors[]" value="1">
                                                <span class="custom-control-label">فعال</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            <hr>
                            <p>مشخصه ها</p>
                            <hr>
                            <div v-for="specification in specifications">
                                <div class="row">
                                    <div class="col-1">
                                        <label class="mt-2">@{{ specification.name }}</label>
                                    </div>
    
                                    <div class="col-9">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="مقدار را وارد کنید" :name="'specifications[' + specification.id + ']'" >
                                        </div>
                                    </div>
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
@section('scripts')
    <script>
        var app = new Vue({
            el: "#app",
            data: {
                categories: [],
                specifications: []
            },
            methods: {
                getSpecifications() {
                    let self = this;
                    axios.post('/admin/get-specifications', {
                        categoryIds: this.categories
                    })
                        .then(function (response) {
                            // handle success
                            let data = response.data;
                            self.specifications = data.specifications;
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
