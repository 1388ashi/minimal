@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
                <li class="breadcrumb-item active" aria-current="page">نمایش خبر</li>
                
            </ol>
            <div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @can('edit blogs')
                    <a href="{{ route('admin.news.edit',$news) }}" class="btn btn-warning">
                        ویرایش {{$news->title}}
                        <i class="fa fa-pencil"></i>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    
        <!--End Page header-->
        @php
        $vertaDate = verta($news->created_at);
        $vertaDate2 = verta($news->published_at);
        @endphp
        <!-- Row -->
        <div class="row">
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="header p-3 " style="font-size: 20px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">اطلاعات اولیه</p>
                        <ul class="list-group">
                            <li class="list-group-item">عنوان:{{$news->title}}</li>
                            <li class="list-group-item"><b class="bold">نویسنده: </b>{{$news->writer}}</li>
                            <li class="list-group-item"><b class="bold">دسته بندی: </b>{{$news->category->title}}</li>
                                <li class="list-group-item"><b class="bold">ویژه
                                    : </b>@include('includes.status',["status" => $news->featured])
                                </li>
                                <li class="list-group-item"><b class="bold">وضعیت
                                    نمایش: </b>@include('includes.status',["status" => $news->status])
                                </li>
                            <li class="list-group-item">تاریخ ثبت: {{$vertaDate->format('Y/n/j')}} </li>
                            <li class="list-group-item">تاریخ انتشار: {{$vertaDate2->format('Y/n/j')}} </li>
                        </ul>
                        <div class="mt-1">
                            <label class="text-muted form-label">خلاصه توضیحات:</label><p class="bold">{!!$news->summary!!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="news-slider">
                            <div class="news-carousel">
                                <div id="carousel" class="carousel slide" data-ride="false">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <a href="{{ $news->image['url'] }}" target="_blanck">
                                            <img src="{{ $news->image['url'] }}" style="height: 310px" class="img-fluid"  alt="{{ $news->image['name'] }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($news->body)
        <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="header p-3 " style="font-size: 20px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">بدنه ی خبر:</p>
                    <div class="mt-1">
                        {!!$news->body!!}
                    </div>
                </div>
            </div>
        </div>
        </div>
        @endif
        <div class="card-body">
            <div class="icons">
                <a class="btn btn-danger icons" href="{{route('admin.news.index')}}"> برگشت</a>
            </div>
        </div>
@endsection