@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه پیشنهاد ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create products')
                <a href="{{ route('admin.suggestions.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
                    ثبت محصول پیشنهادی جدید
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
                    <div class="card-title">لیست همه پیشنهاد ها ({{ $suggestions->total() }})</div>
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
                                    <th class="border-top">محصول</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($suggestions as $suggestion)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="{{route('admin.products.show',[$suggestion->product_id])}}">{{ $suggestion->product->title }}</a>
                                </td>
                                <td>{{verta($suggestion->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    {{-- Delete--}}
                                    @can('delete products')
                                    <x-core::delete-btn route="admin.suggestions.destroy" :model="$suggestion" :disabled="false"  />
                                    @endcan
                                </td>
                            </tr>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ پیشنهادی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$suggestions->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.suggestions.store')}}" class="save" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت محصول جدید</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">محصول</label>
                        <select class="form-control custom-select select2" data-placeholder="Select Package" name="product_id">
                            <option selected disabled>- انتخاب کنید  -</option>
                            @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->title}}</option>
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

