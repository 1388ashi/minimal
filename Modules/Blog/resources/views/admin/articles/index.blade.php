@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه محتوا</li>
            
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create blogs')
                <a href="{{ route('admin.articles.create') }}" class="btn btn-indigo">
                    ثبت محتوا جدید
                    <i class="fa fa-plus"></i>
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md-12">
            <x-core::filter action="{{ route('admin.articles.index') }}" :inputs="$filterInputs"/>
            <div class="card">
                <div class="card-header border-0">
                    <div class="card-title">لیست همه محتوا ({{ $articles->total() }})</div>
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
                                    <th class="border-top">دسته بندی</th>
                                    {{-- <th class="border-top">تصویر</th> --}}
                                    <th class="border-top">ویژه</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{Str::limit($article->title,40, '...') }}</td>
                                    <td>{{$article->category->title}}</td>
                                    <td class="text-center">@include('includes.status',["status" => $article->featured])</td>
                                    <td class="text-center">@include('includes.status',["status" => $article->status])</td>
                                    <td>
                                        {{ verta($article->created_at)->format('Y/m/d H:i') }}
                                    </td>
                                    <td>
                                        {{-- Edit--}}
                                        @can('view blogs')
                                        <a href="{{ route('admin.articles.show',$article) }}" class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="نمایش"><i class="fa fa-eye"></i></a>
                                        @endcan
                                        @can('edit blogs')
                                        <a href="{{ route('admin.articles.edit',$article) }}" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-original-title="ویرایش"><i class="fa fa-pencil"></i></a>
                                        @endcan
                                        {{-- Delete
                                            <button class="btn btn-danger btn-sm text-white" onclick="confirmDelete('delete-{{ $role->id }}')" @disabled(!$role->isDeletable())><i class="fa fa-trash-o"></i></button>
                                            <form action="{{ route('admin.admins.destroy', $role->id) }}" method="article" id="delete-{{ $role->id }}" style="display: none">
                                                @csrf
                                            @method('DELETE')
                                        </form> --}}
                                        @can('delete blogs')
                                        <x-core::delete-btn route="admin.articles.destroy" :model="$article" :disabled="false" />
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ محتوا ای یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$articles->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row closed -->
@endsection

