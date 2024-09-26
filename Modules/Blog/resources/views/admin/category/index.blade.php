@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه دسته بندی ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create categories')
                <a href="{{ route('admin.blog-categories.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت دسته بندی جدید
                    <i class="fa fa-plus"></i>
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="card-title">لیست همه دسته بندی ها ({{ $blog_categories->total() }})</div>
                    <div class="card-options">
                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                        <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <x-alert-danger></x-alert-danger>
                    <x-alert-success></x-alert-success>
                    <div class="table-responsive">
                        <table id="example-2" class="table table-striped table-bordered text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th class="border-top">ردیف</th>
                                    <th class="border-top">عنوان</th>
                                    <th class="border-top">نوع</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($blog_categories as $blog_category)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $blog_category->title }}</td>
                                <td class="text-center"><span>@if($blog_category->type == 'news'){{'خبری'}}@else {{'مقاله'}} @endif</span></td>
                                <td class="text-center">@include('includes.status',["status" => $blog_category->status])</td>
                                <td>{{verta($blog_category->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit categories')
                                    <button type="button" class="btn btn-warning btn-sm"
                                        data-toggle="modal"
                                        data-target="#edit-menu-{{ $blog_category->id }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete categories')
                                    <x-core::delete-btn route="admin.blog-categories.destroy" :model="$blog_category"  disabled="{{!$blog_category->isDeletable() }}" />
                                    @endcan
                                    </td>
                            </tr>
                                    @empty
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ دسته بندی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                        {{$blog_categories->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row closed -->
    <div class="modal fade"  id="addspecialtie">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('admin.blog-categories.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت دسته بندی</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label >عنوان<span class="text-danger">&starf;</span></label>
                            <input type="text" class="form-control" name="title"  placeholder="عنوان را اینجا وارد کنید" value="{{ old('title') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>نوع<span class="text-danger">&starf;</span></label>
                            <select class="form-control select2" name="type">
                                <option selected disabled>- انتخاب کنید  -</option>
                                <option value="news">خبری</option>
                                <option value="article">مقاله</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="control-label ">
                                وضعیت
                            </span>
                            <label class="custom-control custom-checkbox mr-1 mt-1">
                                <input style="cursor: pointer" type="checkbox" class="custom-control-input" name="status" value="1"  {{ old('status', 1) == 1 ? 'checked' : null }}>
                                <span class="custom-control-label">فعال</span>
                            </label>
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
    @include('blog::admin.category.edit')
@endsection

