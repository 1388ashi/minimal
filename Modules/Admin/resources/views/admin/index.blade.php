@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه ادمین ها</li>
            
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create admins')
                <a href="{{ route('admin.admins.create') }}" class="btn btn-indigo">
                    ثبت ادمین جدید
                    <i class="fa fa-plus"></i>
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="card-title">لیست همه ادمین ها ({{ $admins->total() }})</div>
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
                        <table class="table table-striped table-bordered text-nowrap text-center">
                            <thead>
                                <tr>
                                <th class="border-top">ردیف</th>
                                <th class="border-top">نام</th>
                                <th class="border-top">شماره موبایل</th>
                                <th class="border-top">نقش</th>
                                <th class="border-top">وضعیت</th>
                                <th class="border-top">تاریخ ثبت</th>
                                <th class="border-top">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->mobile }}</td>
                                    @foreach($admin->roles as $role)
                                    <td>{{ $role->label }}</td>
                                    @endforeach
                                    <td class="text-center">@include('includes.status',["status" => $admin->status])</td>
                                    <td>
                                        {{verta($admin->created_at)->format('Y/m/d H:i')}}
                                    </td>
                                    <td>
                                        {{-- Edit--}}
                                        @can('view admins')
                                        <a href="{{ route('admin.admins.show', [$admin->id]) }}" class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="نمایش"><i class="fa fa-eye"></i></a>
                                        @endcan
                                        @can('edit admins')
                                        <a href="{{ route('admin.admins.edit', [$admin->id]) }}" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-original-title="ویرایش"><i class="fa fa-pencil"></i></a>
                                        @endcan
                                        {{-- Delete
                                        <button class="btn btn-danger btn-sm text-white" onclick="confirmDelete('delete-{{ $role->id }}')" @disabled(!$role->isDeletable())><i class="fa fa-trash-o"></i></button>
                                        <form action="{{ route('admin.admins.destroy', $role->id) }}" method="post" id="delete-{{ $role->id }}" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form> --}}
                                        @can('delete admins')
                                        @if ($admin->name == 'مدیر کل')
                                        <button type="button" class="btn btn-danger btn-sm text-white" data-original-title="حذف" @disabled(true)  onclick="confirmDelete('delete-{{ $admin->id }}')" >
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-danger btn-sm text-white" data-original-title="حذف" @disabled(false)  onclick="confirmDelete('delete-{{ $admin->id }}')" >
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        @endif
                                        @endcan
                                        <form 
                                        action="{{ route("admin.admins.destroy",$admin)}}" 
                                        id="delete-{{$admin->id}}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        @method("DELETE")
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-danger"><strong>در حال حاضر هیچ ادمینی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$admins->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('scripts')
<script>
    $(document).ready(function (){
        $(".item-delete").click(function (){
            $("#item_id").val($(this).data('id'));
            $("#delete_title").html($(this).data('title'));
            
            $("#delete-form").slideDown();
        });
        
        
        $("#delete-cancel").click(function (e){
            e.preventDefault();
            $("#item_id").val('');
            $("#delete_title").html('');
            
            $("#delete-form").slideUp();
            return false;
        });
        
    });
</script>
@endsection
