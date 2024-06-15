@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه رزومه ها</li>
        </ol>
    </div>

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md-12">
            <x-core::filter action="{{ route('admin.resumes.index') }}" :inputs="$filterInputs"/>
            <div class="card">
                <div class="card-header border-0">
                    <div class="card-title">لیست همه رزومه ها ({{ $resumes->total() }})</div>
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
                                    <th class="border-top">نام و نام خوانوادگی</th>
                                    <th class="border-top">شغل</th>
                                    <th class="border-top">موبایل</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ارسال</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($resumes as $resume)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $resume->name }}</td>
                                <td>{{ $resume->job->title }}</td>
                                <td>{{ $resume->mobile }}</td>
                                <td>@include('joboffer::admin.resumes.status', ['status' => $resume->status])</td>
                                <td>{{verta($resume->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    <a href="{{ route('admin.resumes.show',$resume) }}" class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="نمایش"><i class="fa fa-eye"></i></a>
                                    {{-- Delete--}}
                                    {{-- @can('delete resumes')
                                    <x-core::delete-btn route="admin.resumes.destroy" :model="$resumes"  />
                                    @endcan --}}
                                    </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ رزومه ای یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$resumes->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
@endsection 

