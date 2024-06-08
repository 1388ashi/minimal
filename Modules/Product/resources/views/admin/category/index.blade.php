@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه دسته بندی ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create categories')
                <a href="{{ route('admin.categories.create') }}" class="btn btn-indigo">
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
                <div class="card-header">
                    <div class="card-title">لیست همه دسته بندی ها ({{ $categories->total() }})</div>
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
                                    <th class="wd-20p border-bottom-0">ردیف</th>
                                    <th class="wd-20p border-bottom-0">عنوان</th>
                                    <th class="wd-20p border-bottom-0">دسته بندی والد</th>
                                    <th class="wd-20p border-bottom-0">تصویر</th>
                                    <th class="wd-20p border-bottom-0">ویژه</th>
                                    <th class="wd-20p border-bottom-0">وضعیت</th>
                                    <th class="wd-25p border-bottom-0">تاریخ ثبت</th>
                                    <th class="wd-10p border-bottom-0">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $category->title }}</td>
                                @if (!empty($category->parent->title))<td>{{ $category->parent->title}}</td>@else<td>-</td>@endif
                                <td class="text-center"><a href="{{ $category->image['url'] }}" target="_blanck"><img src="{{ $category->image['url'] }}" style="width: 80px;height: 60px;"  alt="{{ $category->image['name'] }}"></a></td>
                                <td class="text-center">@include('includes.status',["status" => $category->featured])</td>
                                <td class="text-center">@include('includes.status',["status" => $category->status])</td>
                                <td>{{verta($category->created_at)}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit categories')
                                    <a href="{{ route('admin.categories.edit', [$category->id]) }}" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-original-title="ویرایش"><i class="fa fa-pencil"></i></a>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete categories')
                                    <x-core::delete-btn route="admin.categories.destroy" :model="$category"  />
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
                        {{$categories->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row closed -->
    
@endsection

