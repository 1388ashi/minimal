@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه مشخصات ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create specifications')
                <a href="{{ route('admin.specifications.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت مشخصات جدید
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
                    <div class="card-title">لیست همه مشخصات ها ({{ $specifications->total() }})</div>
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
                                    <th class="wd-20p border-bottom-0">دسته بندی ها</th>
                                    <th class="wd-25p border-bottom-0">تاریخ ثبت</th>
                                    <th class="wd-10p border-bottom-0">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($specifications as $specification)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $specification->name }}</td>
                                <td>
                                    @foreach($specification->categories as $key => $item)
                                    {{$item->title}}
                                    @if($key < $specification->categories->count() - 1),@endif
                                    @endforeach
                                </td>
                                <td>{{verta($specification->created_at)}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('edit specifications')
                                    <a href="{{ route('admin.specifications.edit',$specification) }}" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-original-title="ویرایش"><i class="fa fa-pencil"></i></a>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete specifications')
                                    <x-core::delete-btn route="admin.specifications.destroy" :model="$specification"  />
                                    @endcan
                                    </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ مشخصه ای یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$specifications->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.specifications.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت مشخصات</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="control-label">نام<span class="text-danger">&starf;</span></label>
                            <input type="text" class="form-control" name="name"  placeholder="نام مشخصه اینجا وارد کنید" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="control-label">دسته بندی<span class="text-danger">&starf;</span></label>
                            <select class="form-control select2" name="categories[]" id="tags" multiple="multiple">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                                        <!-- نمایش دادن فرزندان هر والد -->
                                    @if($category->has('recursiveChildren'))
                                        @foreach($category->recursiveChildren as $item)
                                            <option value="{{ $item->id }}">-{{ $item->title }} </option>
                                            @if($item->has('children'))
                                            @foreach($item->children as $child)
                                                <option value="{{ $child->id }}"> --{{ $child->title }}</option>
                                            @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.js-tags-example').select2({
                tags:false
            });
        });
    </script>
@endsection

