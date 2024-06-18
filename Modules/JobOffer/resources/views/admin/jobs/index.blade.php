@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه شغل ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create categories')
                <a href="{{ route('admin.jobs.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت شغل جدید
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
                    <div class="card-title">لیست همه شغل ها ({{ $jobs->total() }})</div>
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
                                    <th class="border-top">ساعت کاری</th>
                                    <th class="border-top">نوع</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->times }}</td>
                                <td>{{ __('custom.typeJob.' .  $job->type) }}</td>
                                <td class="text-center">@include('includes.status',["status" => $job->status])</td>
                                <td>{{verta($job->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit jobs')
                                    <button type="button" class="btn btn-warning btn-sm ml-1"
                                    data-toggle="modal"
                                    data-target="#edit-menu-{{ $job->id }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete jobs')
                                    <x-core::delete-btn route="admin.jobs.destroy" :model="$job"  disabled="{{ !$job->isDeletable() }}" />
                                    @endcan
                                    </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ شغلی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$jobs->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.jobs.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت شغل جدید</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label >عنوان<span class="text-danger">&starf;</span></label>
                                <input type="text" class="form-control" name="title"  placeholder="عنوان را اینجا وارد کنید" value="{{ old('title') }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label >ساعت کاری<span class="text-danger">&starf;</span></label>
                                <input type="text" class="form-control" name="times"  placeholder="ساعت کاری را اینجا وارد کنید" value="{{ old('times') }}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>نوع<span class="text-danger">&starf;</span></label>
                                <select class="form-control select2" name="type">
                                    <option selected disabled>- انتخاب کنید  -</option>
                                    <option value="part-time">پاره وقت</option>
                                    <option value="full-time">تمام وقت</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <span class="control-label ">
                                    وضعیت
                                </span>
                                <span class="text-danger">&starf;</span>
                                <label class="custom-control custom-checkbox mr-1 mt-2">
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
    @include('joboffer::admin.jobs.edit')
@endsection

