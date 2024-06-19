@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
                <li class="breadcrumb-item active" aria-current="page">نمایش نظر</li>
            </ol>
            <div>
                @can('edit resumes')
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <button data-toggle="modal" data-target="#addspecialtie" class="btn btn-warning">
                        ویرایش وضعیت
                        <i class="fa fa-pencil"></i>
                    </button>
                </div>
                @endcan
            </div>
        </div>
    
        <!--End Page header-->
        @php
        $vertaDate = verta($resume->created_at);
        @endphp
        <div class="card">

            <div class="card-header border-0">
                <p class="card-title ml-2">مشخصات رزومه</p>
            </div>
            
            <div class="card-body">
    
                <div class="row">
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">نام و نام خانوادگی :</span>
                    <span class="fs-14 mr-1"> {{ $resume->name }} </span>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">شماره موبایل :</span>
                    <span class="fs-14 mr-1"> {{ $resume->mobile }} </span>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">شغل :</span>
                    <span class="fs-14 mr-1"> {{ $resume->job->title }} </span>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                        <span class="fs-16 font-weight-bold ml-1 ">وضعیت :</span>
                            @include('joboffer::admin.resumes.status', ['status' => $resume->status])
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                        <span class="fs-16 font-weight-bold ml-1">تاریخ ارسال :</span>
                        <span class="fs-14 mr-1"> {{ verta($resume->created_at)->format('Y/m/d') }} </span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                        <span class="fs-16 font-weight-bold ml-1">شناسه رزومه :</span>
                        <span class="fs-14 mr-1"> {{ $resume->id }}# </span>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
    @if ($resume->description)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="mt-1 d-flex">
                    <p class="font-weight-bold">
                        توضیحات رزومه :   
                    </p> 
                    <p>
                        {{$resume->description}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
        <div class="card-body">
            <div class="icons">
                <a class="btn btn-danger icons" href="{{route('admin.resumes.index')}}"> برگشت</a>
            </div>
        </div>
        <div class="modal fade"  id="addspecialtie">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <form action="{{route('admin.resumes.update',$resume)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="modal-header">
                            <p class="modal-title font-weight-bolder">ویرایش وضعیت</p>
                        <button  class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">وضعیت<span class="text-danger">&starf;</span></label>
                            <select class="form-control select2" name="status">
                                <option value="pending" @selected($resume->status == 'pending')>در حال بررسی</option>
                                <option value="confirm_interview" @selected($resume->status == 'confirm_interview')>تایید برای مصاحبه</option>
                                <option value="rejected" @selected($resume->status == 'rejected')>رد</option>
                                <option value="accepted" @selected($resume->status == 'accepted')>استخدام</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button  class="btn btn-primary  text-right item-right">ثبت</button>
                        <button class="btn btn-outline-danger  text-right item-right" data-dismiss="modal">برگشت</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
@endsection