@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.articles.index') }}">لیست محتوا </a></li>
            <li class="breadcrumb-item active" aria-current="page">ویرایش محتوا</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ویرایش محتوا</p>
                </div>
                <div class="card-body">

                    <x-alert-danger></x-alert-danger>

                    <form action="{{ route('admin.articles.update',$article) }}" method="post"  enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">عنوان<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="title" placeholder="عنوان محتوا اینجا وارد کنید" value="{{ old('title', $article->title) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>دسته بندی ها</label><span class="text-danger">&starf;</span>
                                    <select class="form-control select2" name="category_id">
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}"  @selected($category->id == $article->category_id)>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">زمان انتشار</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div>
                                        <input class="form-control fc-datepicker" id="payment_date_show" placeholder="تاریخ انتشار" type="text" autocomplete="off" value=" @if(old('published_at')) {{verta(old('published_at', today()->format('Y-m-d')))->format('Y-m-d') }} @else{{$article->published_at}} @endif">
                                        <input name="published_at" id="payment_date" type="hidden" value="{{ old('published_at', today()->format('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label >خلاصه توضیحات</label> <span class="text-danger">&starf;</span>
                                    <textarea class="form-control" name="summary" cols="86" rows="3">{{$article->summary}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="label" >تصویر اصلی</label>
                                    <input class="form-control" type="file" name="image">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label >توضیحات</label><span class="text-danger">&starf;</span>
                            <textarea name="body" class="form-control ckeditor" cols="100" rows="4">{{$article->body}}</textarea>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>نوع محتوا</label><span class="text-danger">&starf;</span>
                                    <select class="form-control select2" name="type">
                                        <option @selected($article->type == "article") value="article">محتوا</option>
                                        <option @selected($article->type == "news") value="news">خبر</option>
                                        <option @selected($article->type == "trend") value="trend">ترند</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="read" >زمان خواندن<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="read" id="read" placeholder="زمان خواندن محتوا اینجا وارد کنید" value="{{ old('read', $article->read) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="writer" >نویسنده<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="writer" id="writer" placeholder="نویسنده محتوا اینجا وارد کنید" value="{{ old('writer', $article->writer) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span class="control-label ">
                                        ویژه
                                    </span>
                                    <label class="custom-control custom-checkbox mr-1 mt-1">
                                        <input type="checkbox" class="custom-control-input" name="featured" value="1" @checked(old('featured',$article->featured) == '1')>
                                        <span class="custom-control-label">فعال</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span class="control-label ">
                                    وضعیت
                                </span>
                                <label class="custom-control custom-checkbox mr-1 mt-1">
                                    <input type="checkbox" class="custom-control-input" name="status" value="1" @checked(old('status',$article->status) == '1') >
                                    <span class="custom-control-label">فعال</span>
                                </label>
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
@endsection
@section('scripts')
<script>
    $('#payment_date_show').MdPersianDateTimePicker({
        targetDateSelector: '#payment_date',
        targetTextSelector: '#payment_date_show',
        englishNumber: false,
        toDate:true,
        enableTimePicker: false,
        dateFormat: 'yyyy-MM-dd',
        textFormat: 'yyyy-MM-dd',
        groupId: 'rangeSelector1',
    });
</script>
@endsection
