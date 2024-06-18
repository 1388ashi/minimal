@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه رنگ ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create colors')
                <a href="{{ route('admin.colors.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت رنگ جدید
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
                <div class="card-header  border-0">
                    <div class="card-title">لیست همه رنگ ها ({{ $colors->total() }})</div>
                    <div class="card-options">
                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                        <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <x-alert-danger></x-alert-danger>
                    <x-alert-success></x-alert-success>
                    <div class="table-responsive ">
                        <table id="example-2" class="table table-striped table-bordered text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th class="border-top">ردیف</th>
                                    <th class="border-top">عنوان</th>
                                    <th class="border-top">کد رنگ</th>
                                    <th class="border-top">رنگ</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($colors as $color)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $color->title }}</td>
                                <td>{{ $color->code }}</td>
                                <td><a class="d-flex " style="justify-content: center;"><div style="background-color:{{$color->code}};width: 25px;height:25px;border-radius: 50%;margin-left: 6px;justify-content: center;"></div></a></td>
                                <td>{{verta($color->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit colors')
                                    <button type="button" class="btn btn-warning btn-sm ml-1"
                                    data-toggle="modal"
                                    data-target="#edit-menu-{{ $color->id }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete colors')
                                    <x-core::delete-btn route="admin.colors.destroy" :model="$color" disabled="{{ !$color->isDeletable() }}"  />
                                    @endcan
                                    </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ رنگ یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$colors->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.colors.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت رنگ</p>
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
                            <label for="color">رنگ را انتخاب کنید:</label>
                            <input type="color" id="color" name="code" onchange="updateColor(this.value)">
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
    @include('product::admin.color.edit')
@endsection
@section('scripts')
<script>
    function updateColor(value) {
        var output = document.getElementById("output");
        output.textContent = "Selected color: " + value;
    }
</script>
@endsection

