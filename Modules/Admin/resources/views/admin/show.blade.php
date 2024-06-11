@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
                <li class="breadcrumb-item active" aria-current="page">نمایش ادمین</li>
                
            </ol>
            <div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @can('edit faq')
                    <a href="{{ route('admin.admins.edit',$admin) }}" class="btn btn-warning">
                        ویرایش  {{$admin->name}}
                        <i class="fa fa-pencil"></i>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        <!--End Page header-->

        <!-- Row -->
        <div class="card">

            <div class="card-header border-0">
                <p class="card-title ml-2">مشخصات ادمین</p>
            </div>
            
            <div class="card-body">
    
                <div class="row">
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">شناسه کاربر :</span>
                    <span class="fs-14 mr-1"> {{ $admin->id }} </span>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">نام و نام خانوادگی :</span>
                    <span class="fs-14 mr-1"> {{ $admin->name }} </span>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">شماره موبایل :</span>
                    <span class="fs-14 mr-1"> {{ $admin->mobile }} </span>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">نقش :</span>
                    @foreach($admin->roles as $role)
                    <span class="fs-14 mr-1"> {{ $role->label }} </span>
                    @endforeach
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">وضعیت :</span>
                    <x-core::badge
                        type="{{ $admin->status ? 'success' : 'danger' }}"
                        text="{{ $admin->status ? 'فعال' : 'غیر فعال' }}"
                    />
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="d-flex align-items-center my-1">
                    <span class="fs-16 font-weight-bold ml-1">تاریخ ثبت :</span>
                    <span class="fs-14 mr-1"> {{ verta($admin->created_at)->format('Y/m/d') }} </span>
                    </div>
                </div>
    
                </div>
    
            </div>
    
            </div>
            <div class="card mb-0">
                <div class="card-header border-0">
                    <p class="card-title" style="font-size: 16px">فعالیت ادمین ها</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example-2" class="table table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center border-top text-muted">توضیحات</th>
                                    <th class="text-center border-top text-muted">تاریخ عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logActivitys as $item)
                                <tr>
                                    <td class="text-right">{{$item->description}}</td>
                                    <td class="text-center">{{verta($admin->created_at)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endsection