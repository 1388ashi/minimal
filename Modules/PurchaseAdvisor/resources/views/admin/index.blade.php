@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه مشاوره خرید</li>
        </ol>
    </div>

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md-12">
            <x-core::filter action="{{ route('admin.purchase-advistors.index') }}" :inputs="$filterInputs"/>
            <div class="card">
                <div class="card-header border-0">
                    <div class="card-title">لیست مشاوره خرید ({{ $purchaseAdvisors->total() }})</div>
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
                                    <th class="border-top">موبایل</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($purchaseAdvisors as $purchaseAdvisor)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $purchaseAdvisor->name }}</td>
                                <td>{{ $purchaseAdvisor->mobile }}</td>
                                <td>{{ $purchaseAdvisor->status }}</td>
                                <td>{{verta($purchaseAdvisor->created_at)}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('view purchase_advisors')
                                    <button type="button" class="btn btn-primary btn-sm ml-1"
                                    data-toggle="modal"
                                    onclick="showDescriptionModal('{{$purchaseAdvisor->description}}')"
                                    data-original-title="توضیحات">
                                    <i class="fa fa-eye"></i>
                                    </button> 
                                    @endcan
                                    @can('edit purchase_advisors')
                                    <button data-toggle="modal" data-original-title="ویرایش" data-target="#edit-menu-{{ $purchaseAdvisor->id }}"  class="btn btn-warning btn-sm text-white">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    @endcan 
                                    </td>
                                </tr>
                                    @empty
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ مشاوره ای یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$purchaseAdvisors->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    @include('purchaseadvisor::admin.description')
    @include('purchaseadvisor::admin.edit')
@endsection
@section('scripts')
<script>
    function showDescriptionModal (description) {
        let modal = $('#showDescriptionModal');
        modal.find('#description').text(description ?? '-');
        modal.modal('show');
    }
</script>
@endsection