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
                <div class="card-header border-0">
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
                                    <th class="border-top">ردیف</th>
                                    <th class="border-top">نام</th>
                                    <th class="border-top">محصول</th>
                                    <th class="border-top">موبایل</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
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
                                        @include('comment::admin.comments.status', ['status' => $comment->status])
                                    </td>
                                    {{-- <td class="text-center">@include('includes.status',["status" => $comment->status])</td> --}}
                                    <td>{{ verta($comment->created_at)->format('Y/m/d H:i') }}</td>
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

