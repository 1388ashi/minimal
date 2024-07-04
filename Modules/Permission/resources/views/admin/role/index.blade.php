@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه نقش ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create roles')
                <a href="{{ route('admin.roles.create') }}" class="btn btn-indigo">
                    ثبت نقش جدید
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
                    <div class="card-title">لیست همه نقش ها ({{ $roles->total() }})</div>
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
                                    <th class="border-top">نام قابل مشاهده</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->label }}</td>
                                    <td>
                                        {{verta($role->created_at)}}
                                    </td>
                                    <td>
                                        {{-- Edit--}}
                                        @can('edit roles')
                                        <a href="{{ route('admin.roles.edit', [$role->id]) }}" style="pointer-events: {{$role->name == 'super_admin' ?'none':null;}}" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-original-title="ویرایش"><i class="fa fa-pencil"></i></a>
                                        @endcan

                                        @can('delete roles')
                                        <x-core::delete-btn route="admin.blog-categories.destroy" :model="$role"  disabled="{{ !$role->isDeletable() }}" />
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-danger"><strong>در حال حاضر هیچ نقشی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$roles->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
