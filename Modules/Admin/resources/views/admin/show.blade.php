@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">{{$admin->name}} نمایش ادمین</h4>
            </div>
            <div class="page-leftheader mr-md-auto">
                <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                    <div class="btn-list">
                        <a href="{{route('admin.admins.create')}}" class="btn btn-primary " data-toggle="modal" data-target="#addjobmodal"><i class="feather feather-plus fs-15 my-auto ml-2"></i>اضافه کردن ادمین</a>
                        <button  class="btn btn-light" data-toggle="tooltip" data-placement="top" title="E-mail"> <i class="feather feather-mail"></i> </button>
                        <button  class="btn btn-light" data-placement="top" data-toggle="tooltip" title="Contact"> <i class="feather feather-phone-call"></i> </button>
                        <button  class="btn btn-primary" data-placement="top" data-toggle="tooltip" title="Info"> <i class="feather feather-info"></i> </button>
                    </div>
                </div>
            </div>
        </div>
        <!--End Page header-->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-4 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5 ">
                            <a class="text-dark" href="#">
                            <p style="font-size: 15px" class="mb-2">{{$admin->name}}</p></a>
                        </div>
                                @php
                                $vertaDate = verta($admin->created_at);
                                @endphp
                        <p class="mb-3 mt-5  text-muted font-weight-semibold">اطلاعات ادمین</p>
                        <div class="table-responsive">
                            <table class="table row table-borderless w-100 m-0 text-nowrap">
                                <tbody class="col-lg-12 col-xl-6 p-0">
                                    <tr>
                                        @foreach($admin->roles as $role)
                                        <td><span class="font-weight-semibold">نقش ادمین :</span>{{ $role->label}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-semibold">شماره موبایل :</span>{{$admin->mobile}}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-semibold">وضعیت :</span>@include('includes.status',["status" => $admin->status])</td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-semibold">وضعیت :</span>{{$vertaDate->format('Y/n/j')}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-id">
                            <div class="row">
                                <div class="col">
                                    <a class="mb-0">شناسه ادمین :{{ $admin->id}}#</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="icons">
                            <a class="btn btn-danger icons" href="{{route('admin.admins.index')}}"> برگشت</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card mb-0">
                            <div class="card-header border-0">
                                <p class="card-title" style="font-size: 16px"><a href="{{route('admin.admins.index')}}">فعالیت ادمین ها</a></p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example-2" class="table table-striped table-bordered text-nowrap text-center">
                                        <thead>
                                            <tr>
                                                <th class="wd-20p border-bottom-0 text-muted">توضیحات</th>
                                                <th class="wd-20p border-bottom-0 text-muted">تاریخ عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logActivitys as $item)
                                            <tr>
                                                <td>{{$item->description}}</td>
                                                <td>{{verta($admin->created_at)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection