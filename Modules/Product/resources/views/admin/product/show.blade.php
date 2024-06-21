@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.products.index') }}">لیست محصول ها</a></li>
                <li class="breadcrumb-item active" aria-current="page">نمایش محصول</li>
                
            </ol>
            <div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @can('edit products')
                    <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-warning">
                        ویرایش محصول {{$product->title}}
                        <i class="fa fa-pencil"></i>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    
        <!--End Page header-->
        @php
        $vertaDate = verta($product->created_at);
        @endphp
        <!-- Row -->
        <div class="row">
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="header p-3" style="font-size: 22px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">اطلاعات اولیه</p>
                        <ul class="list-group">
                            <li class="list-group-item"><b class="bold">عنوان: </b>{{$product->title}}</li>
                            <li class="list-group-item"><b class="bold">قیمت: </b>{{ number_format($product->price) }}</li>
                            <li class="list-group-item"><b class="bold">تخفیف : </b>  
                                @if ($product->discount){{ number_format($product->discount) }}@else-@endif</li>
                            <li class="list-group-item"><b class="bold">قیمت نهایی: </b>{{number_format($product->totalPriceWithDiscount())}}</li>
                            <li class="list-group-item"><b class="bold">دسته بندی: </b> 
                                @foreach($product->categories as $key => $item)
                                {{$item->title}}
                                @if($key < $product->categories->count() - 1),@endif
                                @endforeach</li>
                                @if ($product->colors)
                                <li class="list-group-item d-flex"><b class="bold">رنگ ها: </b> 
                                @foreach($product->colors as $color)
                                    <div class="mr-1 mb-0" style="background-color:{{$color->code}};width: 25px;height:25px;border-radius: 50%;margin-left: 6px;justify-content: center;"></div>
                                @endforeach</li>
                                    @endif
                                    <li class="list-group-item"><b class="bold">وضعیت
                                    نمایش: </b>@include('includes.status',["status" => $product->status])
                            </li>
                            <li class="list-group-item"><b>تاریخ ثبت: </b>{{$vertaDate->format('Y/n/j')}}</li>
                        </ul>
                        <div class="mt-1">
                            <b class="font-weight-bold form-label">توضیحات محصول:</b><p>{!!$product->description!!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="product-slider">
                            <div class="product-carousel">
                                <div id="carousel" class="carousel slide" data-ride="false">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <a href="{{ $product->image['url'] }}" target="_blanck">
                                            <img src="{{ $product->image['url'] }}" class="img-fluid"  alt="{{ $product->image['name'] }}">
                                            </a>
                                            {{-- <img src="../../assets/images/products/item1.png" alt="img" class="img-fluid"> --}}
                                        </div>
                                        {{-- <div class="carousel-item"><img src="../../assets/images/products/item2.png" alt="img" class="img-fluid"></div>
                                        <div class="carousel-item"><img src="../../assets/images/products/item3.png" alt="img" class="img-fluid"></div>
                                        <div class="carousel-item"><img src="../../assets/images/products/item4.png" alt="img" class="img-fluid"></div>
                                        <div class="carousel-item"><img src="../../assets/images/products/item5.png" alt="img" class="img-fluid"></div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-slider">
                                <div id="thumbcarousel" class="carousel slide" data-interval="false">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            @foreach($product->galleries as $item)
                                            <div class="thumb my-2 active">
                                                <a href="{{ $item['url'] }}" target="_blanck">
                                                <img src="{{ $item['url'] }}" class="img-fluid"  alt="{{ $item['name'] }}">
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (is_null($product->specifications))
                
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="header p-3" style="font-size: 22px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">مشخصات</p>
                        <div class="table-responsive">
                            <table class="table mb-0 border-top table-bordered text-nowrap">
                                <tbody>
                                    @foreach ($product->specifications as  $specification)
                                    <tr>
                                        <th scope="row">{{$specification->name}}</th>
                                        <td>{{$specification->pivot->value}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if ($product->video['url'])
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="product-slider bg">
                            <div class="product-carousel">
                                <div id="carousel" class="carousel slide" data-ride="false">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <a href="{{ $product->video['url'] }}" target="_blanck">
                                            <video src="{{ $product->video['url'] }}" controls></video>
                                        </a>
                                        {{-- <img src="../../assets/images/products/item1.png" alt="img" class="img-fluid"> --}}
                                    </div>
                                    {{-- <div class="carousel-item"><img src="../../assets/images/products/item2.png" alt="img" class="img-fluid"></div>
                                    <div class="carousel-item"><img src="../../assets/images/products/item3.png" alt="img" class="img-fluid"></div>
                                    <div class="carousel-item"><img src="../../assets/images/products/item4.png" alt="img" class="img-fluid"></div>
                                    <div class="carousel-item"><img src="../../assets/images/products/item5.png" alt="img" class="img-fluid"></div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card-body">
            <div class="icons">
                <a class="btn btn-danger icons" href="{{route('admin.products.index')}}"> برگشت</a>
            </div>
        </div>
        @endsection