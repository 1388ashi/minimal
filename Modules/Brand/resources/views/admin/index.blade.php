@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه برند ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create brands')
                <a href="{{ route('admin.brands.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت برند جدید
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
                    <div class="card-title">لیست همه برند ها ({{ $brands->total() }})</div>
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
                                    <th class="border-top">تصویر</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td class="text-center">
                                    <a href="{{ $brand->image['url'] }}" target="_blanck">
                                    <div class="bg-light pb-1 pt-1 img-holder img-show" style="max-height: 50px;border-radius: 4px;">
                                        <img src="{{ $brand->image['url'] }}" style="height: 40px;"  alt="{{ $brand->image['name'] }}">
                                    </div>
                                    </a>
                                </td>
                                <td class="text-center">@include('includes.status',["status" => $brand->status])</td>
                                <td>{{verta($brand->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit brands')
                                    <button type="button" class="btn btn-warning btn-sm "
                                    data-toggle="modal"
                                    data-target="#edit-menu-{{ $brand->id }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete brands')
                                    <x-core::delete-btn route="admin.brands.destroy" :model="$brand" :disabled="false" />
                                    @endcan
                                    </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ برندی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$brands->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.brands.store')}}" class="save" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت برند جدید</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="label" >تصویر</label><span class="text-danger">&starf;</span>
                                <input  class="form-control" type="file" name="image">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label" for="label" >عنوان</label> 
                                <input class="form-control" type="text" name="title" value="{{old('title')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="label" >توضیحات</label><span class="text-danger">&starf;</span>
                                <textarea name="description" class="form-control" cols="30" rows="3">{{old('description')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <span class="control-label ">
                                    وضعیت
                                </span>
                                <label class="custom-control custom-checkbox mr-1 mt-1">
                                    <input type="checkbox" class="custom-control-input" name="status" value="1" checked>
                                    <span class="custom-control-label">فعال</span>
                                </label>
                            </div>
                        </div>
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
    @include('brand::admin.edit')
@endsection

