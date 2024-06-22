@extends('admin.layouts.master')
@section('content')
<div class="page-header d-xl-flex d-block mr-3">
    <div class="page-leftheader">
        <h4 class="page-title">داشبورد<span class="font-weight-normal text-muted ml-2"></span></h4>
    </div>
</div>

@can('view dashboard stats')
    <div class="col-xl-12">
        <div class="row" style="justify-content: center">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <a href="{{route('admin.products.index')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">تعداد محصولات</span>
                                        <h3 class="mb-0 mt-1 text-primary fs-25">{{ number_format($products) }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-primary-transparent my-auto float-left"><i
                                            class="las la-video"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <a href="{{route('admin.comments.index')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">نظرات محصولات</span>
                                        <h3 class="mb-0 mt-1 text-success fs-25">{{ number_format($commentsCount) }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-success-transparent my-auto float-left"><i
                                            class="ri-newspaper-fill"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <a href="{{ route('admin.articles.index') }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">وبلاگ</span>
                                        <h3 class="mb-0 mt-1 text-danger fs-25">{{ number_format($weblog) }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-danger-transparent my-auto  float-right"><i
                                            class="fa fa-podcast"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <a href="{{ route('admin.resumes.index') }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">رزومه ها</span>
                                        <h3 class="mb-0 mt-1 text-warning fs-25">{{ number_format($resumesCount) }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-warning-transparent my-auto  float-right"><i
                                            class="fa fa-users"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endcan
{{--
<div class="row">

    <div class="col-xl-6 col-lg-12 col-md-12">
        @can('view orders')
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">آخرین سفارش های موفق دوره ها</h3>
                    <div class="card-options ">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light ml-3">مشاهده
                            همه</a>
                    </div>
                </div>
                <div class="table-responsive attendance_table mt-4 border-top">
                    <table class="table mb-0 text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">دوره</th>
                            <th class="text-center">مبلغ (تومان)</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">تاریخ</th>
                            <th class="text-left">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($successOrders as $successOrder)
                            <tr class="border-bottom">
                                <td class="text-center"><span
                                        class="avatar avatar-sm brround">{{ $loop->iteration }}</span></td>
                                <td class="font-weight-semibold fs-14">{{ Str::limit($successOrder->course->title, 30) }}</td>
                                <td class="text-center">@numberFmt($successOrder->amount)</td>
                                <td class="text-center"><span class="badge bg-success-transparent">موفق</span>
                                </td>
                                <td class="text-center">@jalaliDate($successOrder->created_at)</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $successOrder->id) }}"
                                       class="action-btns" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="مشاهده"><i
                                            class="feather feather-eye text-azure"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12">
        @can('view consultations')
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">آخرین درخواست های مشاوره جدید</h3>
                    <div class="card-options ">
                        <a href="{{ route('admin.consultations.index') }}" class="btn btn-outline-light ml-3">مشاهده
                            همه</a>
                    </div>
                </div>
                <div class="table-responsive attendance_table mt-4 border-top">
                    <table class="table mb-0 text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام و نام خانوادگی</th>
                            <th class="text-center">شماره تلفن</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newConsultations as $newConsultation)
                            <tr class="border-bottom">
                                <td class="text-center"><span
                                        class="avatar avatar-sm brround">{{ $loop->iteration }}</span></td>
                                <td class="font-weight-semibold fs-14">{{ $newConsultation->name }}</td>
                                <td class="font-weight-semibold fs-14">{{ $newConsultation->phone_number }}</td>
                                <td class="text-center"><span class="badge bg-primary-transparent">جدید</span>
                                <td class="text-center">@jalaliDate($newConsultation->created_at)</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.consultations.index', ['id' => $newConsultation->id]) }}"
                                       class="action-btns" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="مشاهده"><i
                                            class="feather feather-eye text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-12 col-md-12">
        @can('view course_comments')
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">نظرات دوره های جدید</h3>
                    <div class="card-options ">
                        <a href="{{ route('admin.course-comments.index') }}" class="btn btn-outline-light ml-3">مشاهده
                            همه</a>
                    </div>
                </div>
                <div class="table-responsive attendance_table mt-4 border-top">
                    <table class="table mb-0 text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام و نام خانوادگی</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">نوع نظر</th>
                            <th class="text-center">تاریخ ثبت</th>
                            <th class="text-left">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newCourseComments as $newCourseComment)
                            <tr class="border-bottom">
                                <td class="text-center"><span
                                        class="avatar avatar-sm brround">{{ $loop->iteration }}</span></td>
                                <td class="font-weight-semibold fs-14">{{ $newCourseComment->user->name }}</td>
                                <td class="text-center"><span class="badge bg-primary-transparent">جدید</span>
                                </td>
                                <td class="text-center">{{ __('custom.' . $newCourseComment->comment_type) }}</td>
                                <td class="text-center">@jalaliDate($newCourseComment->created_at)</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.course-comments.show', $newCourseComment->id) }}"
                                       class="action-btns" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="مشاهده"><i
                                            class="feather feather-eye text-purple"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12">
        @can('view course_comments')
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">نظرات جدید</h3>
                    <div class="card-options ">
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-light ml-3">مشاهده
                            همه</a>
                    </div>
                </div>
                <div class="table-responsive attendance_table mt-4 border-top">
                    <table class="table mb-0 text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام و نام خانوادگی</th>
                            <th class="text-center">شماره تماس</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">تاریخ ثبت</th>
                            <th class="text-left">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newComments as $newComment)
                            <tr class="border-bottom">
                                <td class="text-center"><span
                                        class="avatar avatar-sm brround">{{ $loop->iteration }}</span></td>
                                <td class="font-weight-semibold fs-14">{{ $newComment->name }}</td>
                                <td class="font-weight-semibold fs-14">{{ $newComment->phone_number ?: '-' }}</td>
                                <td class="text-center"><span class="badge bg-primary-transparent">جدید</span></td>
                                <td class="text-center">@jalaliDate($newComment->created_at)</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.comments.show', $newComment->id) }}"
                                       class="action-btns" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="مشاهده"><i
                                            class="feather feather-eye text-purple"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
    </div>
</div>

 --}}







<div class="page-header d-xl-flex d-block mr-3">
    <div class="page-leftheader">
        <h4 class="page-title">داشبورد<span class="font-weight-normal text-muted ml-2"></span></h4>
    </div>
</div>
<!--End Page header-->
<!--Row-->
<div class="row" style="justify-content: center">
    <div class="col-xl-9 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mt-0 text-right"><span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><a href="{{route('admin.products.index')}}" >تعداد محصولات</a></span>
                                    <h3 class="">{{$products}}</h3>
                                        <span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="icon1 bg-secondary-transparent brround my-auto  float-left"> <i class="fa fa-newspaper-o"></i> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"> <a href="{{route('admin.comments.index')}}" >نظرات محصولات</a></span>
                                    <h3 class="">{{$commentsCount}}</h3>
                                        <span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="icon1 bg-success-transparent my-auto  float-left"> <i class="fa fa-book"></i> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><a href="{{route('admin.articles.index')}}" >وبلاگ</a></span>
                                    <h3 class="">{{$weblog}}</h3>
                                        <span class="text-info fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="icon1 bg-primary-transparent my-auto  float-left"> <i class="fa fa-sliders"></i> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><a href="{{route('admin.resumes.index')}}" >رزومه ها</a></span>
                                    <h3 class="">{{$resumesCount}}</h3>
                                        <span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="icon1 bg-warning-transparent my-auto  float-left"> <i class="fa fa-th"></i> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
