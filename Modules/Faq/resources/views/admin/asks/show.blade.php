@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.asks.index') }}">لیست سوال </a></li>
                <li class="breadcrumb-item active" aria-current="page">نمایش سوال</li>
                
            </ol>
            <div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @can('edit faq')
                    <a href="{{ route('admin.asks.edit',$ask) }}" class="btn btn-warning">
                        ویرایش  {!! Str::limit($ask->question,30, '...')!!}
                        <i class="fa fa-pencil"></i>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    
        <!--End Page header-->
        @php
        $vertaDate = verta($ask->created_at);
        @endphp
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="header font-weight-bold p-3" style="font-size: 18px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">{!!$ask->question!!} </p>
                        <div class="mt-1 d-flex">
                            <b class="ml-1">  جواب :  </b> 
                            {!! $ask->reply !!}
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <a class="mb-0">شناسه سوال : {{ $ask->id}}#</a>
                            </div>
                            <div class="col col-auto">
                                <li class="ml-5" style="list-style-type: none;" data-placement="top" data-toggle="tooltip" title="تاریخ ساخت سوال">
                                    <a class="icons" > <i class="feather feather-calendar"></i>{{ verta($ask->created_at)->format('Y/m/d H:i') }}</a>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="icons">
                <a class="btn btn-danger icons" href="{{route('admin.asks.index')}}"> برگشت</a>
            </div>
        </div>
@endsection