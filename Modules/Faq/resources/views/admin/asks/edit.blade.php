@extends('admin.layouts.master')
@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.asks.index') }}">لیست سوال </a></li>
            <li class="breadcrumb-item active" aria-current="page">ویرایش سوال</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ویرایش سوال</p>
                </div>
                <div class="card-body">

                    <x-alert-danger></x-alert-danger>

                    <form action="{{ route('admin.asks.update',$ask) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" >سوال<span class="text-danger">&starf;</span></label>
                                    <textarea class="form-control" name="question" cols="600" rows="3">{!!$ask->question!!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" >جواب<span class="text-danger">&starf;</span></label>
                                    <textarea class="form-control" name="reply" cols="800" rows="4">{!!$ask->reply!!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span class="control-label ">
                                        وضعیت
                                    </span>
                                    <span class="text-danger">&starf;</span>
                                    <label class="custom-control custom-checkbox mr-1 mt-1">
                                        <input type="checkbox" class="custom-control-input" name="status" value="1" @checked($ask->status)>
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