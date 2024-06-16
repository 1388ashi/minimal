@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header mx-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.articles.index') }}">لیست مقاله </a></li>
                <li class="breadcrumb-item active" aria-current="page">نمایش مقاله</li>
                
            </ol>
            <div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @can('edit blogs')
                    <a href="{{ route('admin.articles.edit',$article) }}" class="btn btn-warning">
                        ویرایش  {{$article->title}}
                        <i class="fa fa-pencil"></i>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    
        <!--End Page header-->
        @php
        $vertaDate = verta($article->created_at);
        @endphp
        <!-- Row -->
        <div class="row">
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="header p-3" style="font-size: 20px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">اطلاعات اولیه</p>
                        <ul class="list-group">
                            <li class="list-group-item"><b class="bold">عنوان: </b>{{$article->title}}</li>
                            <li class="list-group-item"><b class="bold">نویسنده: </b>{{$article->writer}}</li>
                            <li class="list-group-item"><b class="bold">دسته بندی: </b>{{$article->category->title}}</li>
                            <li class="list-group-item"><b class="bold">زمان خواندن: </b>{{$article->read}}</li>
                            <li class="list-group-item"><b class="bold">ویژه
                                : </b>@include('includes.status',["status" => $article->featured])
                            </li>
                            <li class="list-group-item"><b class="bold">وضعیت
                                    نمایش: </b>@include('includes.status',["status" => $article->status])
                                </li>
                                <li class="list-group-item"><b>تاریخ ثبت: </b>{{$vertaDate->format('Y/n/j')}}</li>
                            </ul>
                            <div class="mt-1">
                                <label class=" form-label">خلاصه توضیحات:</label><p class="bold">{!!$article->summary!!}</p>
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
                                            <a href="{{ $article->image['url'] }}" target="_blanck">
                                                <img src="{{ $article->image['url'] }}" style="height: 310px" class="img-fluid"  alt="{{ $article->image['name'] }}">
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
        @if ($article->body)
        <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="header p-3 " style="font-size: 20px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">بدنه ی مقاله:</p>
                    <div class="mt-1">
                        {!!$article->body!!}
                    </div>
                </div>
            </div>
        </div>
        </div>
        @endif
        <div class="card-body">
            <div class="icons">
                <a class="btn btn-danger icons" href="{{route('admin.articles.index')}}"> برگشت</a>
            </div>
        </div>
@endsection