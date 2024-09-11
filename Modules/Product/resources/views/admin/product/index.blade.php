@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه محصول ها</li>

        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create products')
                <a href="{{ route('admin.products.create') }}" class="btn btn-indigo">
                    ثبت محصول جدید
                    <i class="fa fa-plus"></i>
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- row opened -->
    <div class="row">
        @include('product::admin.product.filter')
        <div class="col-md-12 row">
            <div class="card">
                <div class="card-header border-0">
                    <div class="card-title">لیست همه محصول ها ({{ $products->total() }})</div>
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
                                    {{-- <th class="border-top">تصویر</th> --}}
                                    <th class="border-top">دسته بندی (ها)</th>
                                    <th class="border-top">قیمت(تومان)</th>
                                    <th class="border-top">تخفیف(تومان)</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{Str::limit($product->title,40,'...')}}</td>
                                    <td>
                                        @foreach($product->categories as $key => $item)
                                        {{$item->title}}
                                        @if($key < $product->categories->count() - 1),@endif
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($product->price) }}</td>
                                    <td>
                                        @if ($product->discount)
                                        {{ number_format($product->discount) }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center">@include('includes.status',["status" => $product->status])</td>
                                    <td>
                                        {{ verta($product->created_at)->format('Y/m/d H:i') }}
                                    </td>
                                    <td>
                                        {{-- Edit--}}
                                        @can('view products')
                                        <a href="{{ route('admin.products.show', [$product->id]) }}" class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="نمایش"><i class="fa fa-eye"></i></a>
                                        @endcan
                                        @can('edit products')
                                        <a href="{{ route('admin.products.edit', [$product->id]) }}" class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-original-title="ویرایش"><i class="fa fa-pencil"></i></a>
                                        @endcan
                                        @can('delete products')
                                        <x-core::delete-btn route="admin.products.destroy" :model="$product" :disabled="false"  />
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ محصولی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$products->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row closed -->
@endsection

