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
                @can('edit comments')
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
        $vertaDate = verta($comment->created_at);
        @endphp
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <x-alert-danger></x-alert-danger>
                        <x-alert-success></x-alert-success>
                        <h4 class="header p-3" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">{{ $comment->name }} </h4>
                        <div class="mt-1">
                            متن نظر:
                            {!!$comment->text!!}
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <p class="mb-0 ">شناسه نظر: {{ $comment->id}}#</p>
                                <p class="mb-0 ">شناسه محصول: <a class="text-info" href="{{route('admin.products.show',[$comment->product_id])}}">{{ $comment->product_id }}#</a></p>
                            </div>
                            <p class="badge badge-warning ml-1" data-placement="top" data-toggle="tooltip" title="ستاره">{{$comment->star}}</p>
                            <p class="badge badge-light mr-l" data-placement="top" data-toggle="tooltip" title="وضعیت">{{ __('custom.statuses.' .  $comment->status) }}</p>
                            <div class="col col-auto">
                                <li class="mt-1" style="list-style-type: none;" data-placement="top" data-toggle="tooltip" title="تاریخ ساخت نظر">
                                    <a class="icons" > <i class="feather feather-calendar"></i>{{$vertaDate->format('Y/n/j')}}</a>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($comment->description)
                
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-1 text-danger">
                            توضیحات ادمین:
                            {{$comment->description}}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card-body">
            <div class="icons">
                <a class="btn btn-danger icons" href="{{route('admin.comments.index')}}"> برگشت</a>
            </div>
        </div>
        <div class="modal fade"  id="addspecialtie">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <form action="{{route('admin.comments.update',$comment)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="modal-header">
                            <p  class="modal-title font-weight-bolder">ویرایش وضعیت</p>
                        <button  class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>وضعیت<span class="text-danger">&starf;</span></label>
                            <select class="form-control select2" name="status">
                                <option value="rejected" @selected($comment->status == 'rejected')>رد</option>
                                <option value="accepted" @selected($comment->status == 'accepted')>تایید</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label >توضیحات</labeld>
                            <textarea name="description" cols="61" rows="3"></textarea>
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