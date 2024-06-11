@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه اسلایدر ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create sliders')
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-indigo">
                    ثبت اسلایدر جدید
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
                    <div class="card-title">لیست همه اسلایدر ها ({{ $sliders->total() }})</div>
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
                                    <th class="border-top">لینک</th>
                                    <th class="border-top">تصویر</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($sliders as $slider)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $slider->title }}</td>
                                <td>{{ $slider->link }}</td>
                                <td class="text-center"><a href="{{ $slider->image['url'] }}" target="_blanck"><img src="{{ $slider->image['url'] }}" style="width: 80px;height: 60px;"  alt="{{ $slider->image['name'] }}"></a></td>
                                <td class="text-center">@include('includes.status',["status" => $slider->status])</td>
                                <td>{{verta($slider->created_at)}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit sliders')
                                    <a href="{{ route('admin.sliders.edit', [$slider->id]) }}" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-original-title="ویرایش"><i class="fa fa-pencil"></i></a>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete sliders')
                                    <x-core::delete-btn route="admin.sliders.destroy" :model="$slider"  />
                                    @endcan
                                    </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ اسلایدری یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row closed -->
    
@endsection

