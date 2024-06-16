@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه نظر مشتریان ها</li>
        </ol>
        <div class="mt-3">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @can('create customerReviews')
                <a href="{{ route('admin.customer-reviews.create') }}" data-toggle="modal" data-target="#addspecialtie" class="btn btn-indigo">
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
                <div class="card-header border-0">
                    <div class="card-title">لیست نظر مشتریان ({{ $customerReviews->total() }})</div>
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
                                    <th class="border-top">شهر</th>
                                    <th class="border-top">عکس</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($customerReviews as $customerReview)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $customerReview->name }}</td>
                                <td>{{ $customerReview->city }}</td>
                                <td class="text-center">
                                    <a href="{{ $customerReview->image['url'] }}" target="_blanck">
                                    <div class="bg-light pb-1 pt-1 img-holder img-show" style="max-height: 50px;border-radius: 4px;">
                                        <img src="{{ $customerReview->image['url'] }}" style="height: 40px;"  alt="{{ $customerReview->image['name'] }}">
                                    </div>
                                    </a>
                                </td>
                                <td>{{verta($customerReview->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('view customerReviews')
                                    <button type="button" class="btn btn-primary btn-sm ml-1"
                                    data-toggle="modal"
                                    data-target="#showspecialtie">
                                    <i class="fa fa-eye"></i>
                                    </button>
                                        {{-- <a href="{{ route('admin.articles.show',$article) }}" class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="نمایش"><i class="fa fa-eye"></i></a> --}}
                                    @endcan
                                    @can('edit customerReviews')
                                    <button type="button" class="btn btn-warning btn-sm ml-1"
                                    data-toggle="modal"
                                    data-target="#edit-menu-{{ $customerReview->id }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                    @endcan
                                    {{-- Delete--}}
                                    @can('delete customerReviews')
                                    <x-core::delete-btn route="admin.customer-reviews.destroy" :model="$customerReview"  />
                                    @endcan
                                    </td>
                                </tr>
                                <div class="modal fade"  id="showspecialtie">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                    <p class="modal-title font-weight-bolder">نمایش توضیحات</p>
                                                <button  class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="form-control" style="overflow: scroll">{{$customerReview->description}}</div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-outline-danger  text-right item-right" data-dismiss="modal">برگشت</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                        
                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ نظری یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>
                        {{$customerReviews->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
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
                <form action="{{route('admin.customer-reviews.store')}}" class="save" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ثبت نظر جدید</p>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">نام<span class="text-danger">&starf;</span></label>
                            <input type="text" class="form-control" name="name"  placeholder="نام را اینجا وارد کنید" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="city"class="control-label">شهر<span class="text-danger">&starf;</span></label>
                            <input type="text" id="city" name="city" class="form-control" name="city"  placeholder="شهر را اینجا وارد کنید" value="{{ old('city') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="label" class="control-label">تصویر</label><span class="text-danger">&starf;</span>
                            <input  class="form-control" type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label class="control-label">توضیحات<span class="text-danger">&starf;</span></label>
                            <textarea class="form-control" name="description" cols="61" rows="3"></textarea>
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
    @include('customerreview::admin.edit')
@endsection

