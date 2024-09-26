@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i>داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه نمونه کار ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create workSample')
                <a href="{{route('admin.work-samples.index')}}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت نمونه کار جدید
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
                    <div class="card-title">لیست نمونه کار ({{ $workSamples->total() }})</div>
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
                                    <th class="border-top">تصویر</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($workSamples as $workSample)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $workSample->title }}</td>
                                <td class="text-center">
                                    <a href="{{ $workSample->image['url'] }}" target="_blanck">
                                    <div class="bg-light pb-1 pt-1 img-holder img-show w-100" style="max-height: 50px;border-radius: 4px;">
                                        <img src="{{ $workSample->image['url'] }}" style="height: 40px;"  alt="{{ $workSample->image['name'] }}">
                                    </div>
                                    </a>
                                </td>
                                <td>{{verta($workSample->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    <a href="{{ route('admin.work-samples.show', [$workSample->id]) }}" class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="نمایش">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @can('edit workSample')
                                        <button type="button" class="btn btn-warning  btn-sm "
                                        data-toggle="modal"
                                        data-target="#edit-menu-{{ $workSample->id }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete workSample')
                                    <x-core::delete-btn route="admin.work-samples.destroy" :model="$workSample" :disabled="false " />
                                    @endcan
                                    </td>
                                </tr>
                                    @empty

                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ نمونه کاری یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                        {{$workSamples->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.work-samples.store')}}" class="save" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت نمونه کار جدید</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">عنوان<span class="text-danger">&starf;</span></label>
                        <input type="text" class="form-control" name="title"  placeholder="عنوان را اینجا وارد کنید" value="{{ old('title') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="label" class="control-label">تصویر</label><span class="text-danger">&starf;</span>
                        <input  class="form-control" type="file" name="image" required>
                    </div>
                    <div class="form-group">
                        <label for="label" class="control-label">گالری</label>
                        <input class="form-control"  type="file" name="galleries[]" class="form-control" multiple="multiple">
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-primary  text-right item-right">ثبت</button>
                    <button class="btn btn-outline-danger  text-right item-right" data-dismiss="modal">برگشت</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    @include('worksample::admin.edit')
@endsection
@section('scripts')
<script>

    function showDescriptionModal (customerReview) {
        let modal = $('#showDescriptionModal');
        modal.find('#description').text(`${customerReview.description}` ?? '-');
        modal.modal('show');
    }
</script>
@endsection



