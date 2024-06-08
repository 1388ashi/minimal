@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه نظرات</li>
            
        </ol>
    </div>

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md-12">
            <x-core::filter action="{{ route('admin.comments.index') }}" :inputs="$filterInputs"/>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">لیست همه نظرات ({{ $comments->total() }})</div>
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
                                    <th class="wd-20p border-bottom-0">نام</th>
                                    <th class="wd-20p border-bottom-0">محصول</th>
                                    <th class="wd-20p border-bottom-0">موبایل</th>
                                    <th class="wd-20p border-bottom-0">وضعیت</th>
                                    <th class="wd-25p border-bottom-0">تاریخ ثبت</th>
                                    <th class="wd-10p border-bottom-0">عملیات</th>
                                </tr>
                            </thead>
                        <tbody>
                            @forelse($comments as $comment)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $comment->name }}</td>
                                    <td>
                                        <a href="{{route('admin.products.show',[$comment->product_id])}}">{{ $comment->product->title }}</a>
                                    </td>
                                    <td>{{ $comment->mobile }}</td>
                                    {{-- <td>{{ __('custom.statuses.' .  $comment->status) }} --}}
                                    <td>
                                        @if($comment->status == 'pending')
                                        <span class="badge badge-primary ">در حال بررسی</span>
                                        @elseif($comment->status == 'rejected')
                                        <span class="badge badge-danger ">رد شده</span>
                                        @elseif($comment->status == 'accepted')
                                        <span class="badge badge-success ">تایید شده</span>
                                        @endif
                                    </td>
                                    {{-- <td class="text-center">@include('includes.status',["status" => $comment->status])</td> --}}
                                    <td>{{ verta($comment->created_at) }}</td>
                                    <td>
                                        {{-- Edit--}}
                                        @can('view comments')
                                        <a href="{{ route('admin.comments.show',$comment) }}" class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="نمایش"><i class="fa fa-eye"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger font-weight-bold">در حال حاضر هیچ نظری ای یافت نشد!</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$comments->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row closed -->
@endsection

