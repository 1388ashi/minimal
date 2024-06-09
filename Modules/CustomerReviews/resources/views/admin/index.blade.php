@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه نظر مشتریان ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create customerRaviews')
                <a href="{{ route('admin.customer-raviews.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت نظر جدید
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
                    <div class="card-title">لیست نظر مشتریان ({{ $teams->total() }})</div>
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
                                    <th class="wd-20p border-bottom-0">شهر</th>
                                    <th class="wd-20p border-bottom-0">عکس</th>
                                    <th class="wd-25p border-bottom-0">تاریخ ثبت</th>
                                    <th class="wd-10p border-bottom-0">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($teams as $team)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->role }}</td>
                                <td class="text-center"><a href="{{ $team->image['url'] }}" target="_blanck"><img src="{{ $team->image['url'] }}" style="width: 80px;height: 60px;"  alt="{{ $team->image['name'] }}"></a></td>
                                <td>{{verta($team->created_at)}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit teams')
                                    <button type="button" class="btn btn-warning btn-sm ml-1"
                                    data-toggle="modal"
                                    data-target="#edit-menu-{{ $team->id }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete teams')
                                    <x-core::delete-btn route="admin.teams.destroy" :model="$team"  />
                                    @endcan
                                    </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ عضوی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$teams->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.teams.store')}}" class="save" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت عضو جدید</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label >عنوان<span class="text-danger">&starf;</span></label>
                            <input type="text" class="form-control" name="name"  placeholder="نام را اینجا وارد کنید" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="role">سمت عضو<span class="text-danger">&starf;</span></label>
                            <input type="text" id="role" name="role" class="form-control" name="role"  placeholder="سمت را اینجا وارد کنید" value="{{ old('role') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="label" >تصویر</label><span class="text-danger">&starf;</span>
                            <input  class="form-control" type="file" name="image">
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
    @include('team::admin.edit')
@endsection

