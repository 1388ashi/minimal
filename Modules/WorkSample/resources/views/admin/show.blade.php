@extends('admin.layouts.master')
@section('content')
<div class="app-content main-content" style="margin-right:0px;margin-top:0px;align-items: center;justify-content: center;">
    <div class="side-app">
        <!--Page header-->
        <div class="page-header ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.work-samples.index') }}">لیست نمونه کار ها</a></li>
                <li class="breadcrumb-item active" aria-current="page">نمایش محصول</li>
            </ol>
        </div>

        <!--End Page header-->
        @php
        $vertaDate = verta($workSample->created_at);
        @endphp
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                    <p class="header p-3" style="font-size: 22px" data-sider-select-id="9307cbef-94b5-42d0-80a4-80f8306b0261">{{$workSample->title}}</p>
                        <div class="product-slider">
                            <div class="product-carousel">
                                <div id="carousel" class="carousel slide" data-ride="false">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <a href="{{ $workSample->image['url'] }}" target="_blanck">
                                            <img src="{{ $workSample->image['url'] }}" class="img-fluid"  alt="{{ $workSample->image['name'] }}">
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
                                            @foreach($workSample->galleries as $item)
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
        </div>
        <div class="card-body">
            <div class="icons">
                <a class="btn btn-danger icons" href="{{route('admin.work-samples.index')}}"> برگشت</a>
            </div>
        </div>
    @endsection
