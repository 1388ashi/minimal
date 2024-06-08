@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-3">
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
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
                        <table id="example-2" class="table table-striped table-bordered text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th class="wd-20p border-bottom-0">ردیف</th>
                                    <th class="wd-20p border-bottom-0">نام</th>
                                    <th class="wd-20p border-bottom-0">شماره موبایل</th>
                                    <th class="wd-20p border-bottom-0">نقش</th>
                                    <th class="wd-20p border-bottom-0">وضعیت</th>
                                <th class="wd-25p border-bottom-0">تاریخ ثبت</th>
                                <th class="wd-10p border-bottom-0">عملیات</th>
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
                                        {{verta($admin->created_at)}}
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
                                        <button  class="btn btn-danger btn-sm item-delete text-white" data-toggle="modal" data-target="#deleteModal" data-title="{{$admin->name}}" data-original-title="حذف" data-id="{{$admin->id}}">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @if ($admin->name !== 'مدیر کل')
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                
                                                <div>
                                                    <span>آیا از حذف</span>
                                                    <mark id="delete_title"></mark>
                                                    <span>مطمئن هستید؟</span>
                                                </div>
                                
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.admins.destroy',$admin)}}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="type" value="cat_delete">
                                                    <input type="hidden" name="item_id" id="item_id" value="">
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">انصراف</button>
                                                    <button type="submit" class="btn btn-danger">حذف شود</button>
                                                </form>                    
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
