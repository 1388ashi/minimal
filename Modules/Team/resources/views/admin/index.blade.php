@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه تیم ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                 <button id="submitButton" type="submit" class="btn btn-teal align-items-center"><span>ذخیره مرتب سازی</span><i
                    class="fe fe-code ml-1 font-weight-bold"></i></button>
                @can('create teams')
                <a href="{{ route('admin.teams.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت تیم جدید
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
                    <div class="card-title">لیست همه تیم ها ({{ count($teams) }})</div>
                    <div class="card-options">
                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                        <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <x-alert-danger></x-alert-danger>
                    <x-alert-success></x-alert-success>
                    <form id="myForm" action="{{ route('admin.teams.sort') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="table-responsive">
                            <table id="example-2" class="table table-striped table-bordered text-nowrap text-center">
                                <thead>
                                    <tr>
                                        <th class="border-top">انتخاب</th>
                                        <th class="border-top">ردیف</th>
                                        <th class="border-top">نام</th>
                                        <th class="border-top">سمت</th>
                                        <th class="border-top">عکس</th>
                                        <th class="border-top">تاریخ ثبت</th>
                                        <th class="border-top">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody id="items">
                                    @forelse($teams as $team)
                                    <tr>
                                        <td class="text-center"><i class="fe fe-move glyphicon-move text-dark"></i></td>
                                        <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                        <input type="hidden" value="{{ $team->id }}" name="teams[]">
                                        <td>{{ $team->name }}</td>
                                        <td>{{ $team->role }}</td>
                                        <td class="text-center">
                                            <a href="{{ $team->image['url'] }}" target="_blanck">
                                                <div class="bg-light pb-1 pt-1 img-holder img-show w-100" style="max-height: 50px;border-radius: 4px;">
                                                <img src="{{ $team->image['url'] }}" style="height: 40px;"  alt="{{ $team->image['name'] }}">
                                            </div>
                                            </a>
                                        </td>
                                        <td>{{verta($team->created_at)->format('Y/m/d H:i')}}</td>
                                        <td>
                                            {{-- Edit--}}
                                            @can('edit teams')
                                            <button type="button" class="btn btn-warning btn-sm "
                                            data-toggle="modal"
                                            data-target="#edit-menu-{{ $team->id }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                            @endcan
                                            {{-- Delete--}}
                                            @can('delete teams')
                                            <x-core::delete-btn route="admin.teams.destroy" :model="$team" :disabled="false" />
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
                        </div>
                        <button class="btn btn-teal mt-5" type="submit">ذخیره مرتب سازی</button>
                    </form>
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
@section('scripts')
    <script>
        var items = document.getElementById('items');
        var sortable = Sortable.create(items, {
            handle: '.glyphicon-move',
            animation: 150
        });
        document.getElementById('submitButton').addEventListener('click', function() {
            document.getElementById('myForm').submit();
        });
    </script>
@endsection