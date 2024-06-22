@extends('admin.layouts.master')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i>
                داشبورد</a></li>
    </ol>
    <div class="mt-3 mt-lg-0">
        <div class="d-flex align-items-center flex-wrap text-nowrap">

        </div>
    </div>
</div>
{{--
@can('view dashboard stats')
    <div class="row" style="justify-content: center">
        <div class="col-xl-9 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: 110px">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right"><span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><a href="{{route('admin.products.index')}}" >تعداد محصولات</a></span>
                                        <p class="ps-20">{{$products}}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-secondary-transparent brround my-auto  float-left"> <i class="fa fa-shopping-bag"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: 110px">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"> <a href="{{route('admin.comments.index')}}" >نظرات محصولات</a></span>
                                        <p class="ps-20">{{$commentsCount}}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-success-transparent my-auto  float-left"> <i class="fa fa-comment"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: 110px">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><a href="{{route('admin.articles.index')}}" >وبلاگ</a></span>
                                        <p class="ps-20">{{$weblog}}</p>
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
                        <div class="card-body" style="height: 110px">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><a href="{{route('admin.resumes.index')}}" >رزومه ها</a></span>
                                        <p class="ps-20">{{$resumesCount}}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-warning-transparent my-auto  float-left"> <i class="fa fa-briefcase"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
        <div class="row" style="justify-content: center">
        @can('view comments')
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <p class="card-title">آخرین نظرات محصول</p>
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
                                <th class="text-center">نام</th>
                                <th class="text-center">محصول</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">تاریخ</th>
                                <th class="text-left">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($comments as $comment)
                                <tr class="border-bottom">
                                    <td class="text-center">
                                        <span
                                            class="avatar avatar-sm brround">{{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{$comment->name}}</td>
                                    <td class="text-center">
                                        <a href="{{route('admin.products.show',[$comment->product_id])}}">{{ $comment->product->title }}</a>
                                    </td>
                                    <td class="text-center">
                                        <span>
                                            @include('comment::admin.comments.status', ['status' => $comment->status])
                                        </span>
                                    </td>
                                    <td class="text-center">{{verta($comment->created_at)->format('Y/m/d H:i')}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.comments.show',$comment) }}"
                                        class="action-btns" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="مشاهده"><i
                                             class="feather feather-eye text-azure"></i></a>
                                    </td>
                                </tr>
                                @empty

                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ پیامی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endcan
        @can('view tickets')
        <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <p class="card-title">تماس با ما</p>
                        <div class="card-options ">
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-light ml-3">مشاهده
                                همه</a>
                        </div>
                    </div>
                    <div class="table-responsive attendance_table mt-4 border-top">
                        <table class="table mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="border-top">نام</th>
                                <th class="border-top">موبایل</th>
                                <th class="border-top">ایمیل</th>
                                <th class="border-top">وضعیت</th>
                                <th class="border-top">تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($tickets as $ticket)
                                <tr class="border-bottom">
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{ $ticket->name }}</td>
                                    <td class="text-center">{{ $ticket->mobile }}</td>
                                    <td class="text-center">{{ $ticket->email }}</td>
                                    <td class="text-center">@include('ticket::admin.status', ['status' => $ticket->status])</td>
                                    <td class="text-center">{{verta($ticket->created_at)->format('Y/m/d H:i')}}</td>
                                </tr>
                                @empty

                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger"><strong>در حال حاضر هیچ پیامی یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endcan
        </div>
    </div>


















 --}}
 @can('view dashboard stats')
    <div class="col-xl-12">
        <div class="row" style="width: 80%;margin-right: auto;margin-left: auto;">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <a href="{{ route('admin.products.index') }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">تعداد محصولات</span>
                                        <p class="mb-0 mt-1 text-primary fs-25">{{ number_format($products) }}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-primary-transparent my-auto float-left"><i
                                            class="fa fa-shopping-bag"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <a href="{{ route('admin.comments.index') }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">نظرات محصولات</span>
                                        <p class="mb-0 mt-1 text-success fs-25">{{ number_format($commentsCount) }}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-success-transparent my-auto float-left"><i
                                            class="fa fa-comment"></i></div>
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
                                        <p class="mb-0 mt-1 text-danger fs-25">{{ number_format($weblog) }}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-danger-transparent my-auto  float-right"><i
                                            class="fa fa-newspaper-o"></i></div>
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
                                        <p class="mb-0 mt-1 text-warning fs-25">{{ number_format($resumesCount) }}</p>
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
<div class="row" style="justify-content: center;width: 80%">
    @can('view comments')
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <p class="card-title">آخرین نظرات محصول</p>
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
                            <th class="text-center">نام</th>
                            <th class="text-center">محصول</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">تاریخ</th>
                            <th class="text-left">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($comments as $comment)
                            <tr class="border-bottom">
                                <td class="text-center">
                                    <span
                                        class="avatar avatar-sm brround">{{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="text-center">{{$comment->name}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.products.show',[$comment->product_id])}}">{{ $comment->product->title }}</a>
                                </td>
                                <td class="text-center">
                                    <span>
                                        @include('comment::admin.comments.status', ['status' => $comment->status])
                                    </span>
                                </td>
                                <td class="text-center">{{verta($comment->created_at)->format('Y/m/d H:i')}}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.comments.show',$comment) }}"
                                    class="action-btns" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="مشاهده"><i
                                         class="feather feather-eye text-azure"></i></a>
                                </td>
                            </tr>
                            @empty

                            <tr>
                                <td colspan="8">
                                    <p class="text-danger"><strong>در حال حاضر هیچ پیامی یافت نشد!</strong></p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endcan
    @can('view tickets')
    <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <p class="card-title">تماس با ما</p>
                    <div class="card-options ">
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-light ml-3">مشاهده
                            همه</a>
                    </div>
                </div>
                <div class="table-responsive attendance_table mt-4 border-top">
                    <table class="table mb-0 text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="border-top">نام</th>
                            <th class="border-top">موبایل</th>
                            <th class="border-top">ایمیل</th>
                            <th class="border-top">وضعیت</th>
                            <th class="border-top">تاریخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            <tr class="border-bottom">
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{ $ticket->name }}</td>
                                <td class="text-center">{{ $ticket->mobile }}</td>
                                <td class="text-center">{{ $ticket->email }}</td>
                                <td class="text-center">@include('ticket::admin.status', ['status' => $ticket->status])</td>
                                <td class="text-center">{{verta($ticket->created_at)->format('Y/m/d H:i')}}</td>
                            </tr>
                            @empty

                            <tr>
                                <td colspan="8">
                                    <p class="text-danger"><strong>در حال حاضر هیچ پیامی یافت نشد!</strong></p>
                                </td>
                            </tr>
                        @endforelse
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
</div> --}}

    @endsection
