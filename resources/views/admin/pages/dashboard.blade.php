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
 @can('view dashboard stats')
    <div class="col-xl-12">
        <div class="row" >
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
                                            class="fa fa-briefcase"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endcan
<div class="col-xl-12 d-flex justify-content-center">
<div class="row" >
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
                            <th class="text-center">عملیات</th>
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
                                    <a href="{{route('admin.products.show',[$comment->product_id])}}">{{Str::limit($comment->product->title,18,'...')}}</a>
                                </td>
                                <td class="text-center">
                                        <span class="badge bg-primary-transparent">جدید</span>
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
                                    <p class="text-danger" style="display: flex;justify-content: center !important"><strong>در حال حاضر هیچ نظری یافت نشد!</strong></p>
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
                            <th class="text-center">نام</th>
                            <th class="text-center">موبایل</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">تاریخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            <tr class="border-bottom">
                                <td class="text-center">
                                    <span
                                        class="avatar avatar-sm brround">{{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $ticket->name }}</td>
                                <td class="text-center">{{ $ticket->mobile }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary-transparent">جدید</span>
                                </td>
                                <td class="text-center">{{verta($ticket->created_at)->format('Y/m/d H:i')}}</td>
                            </tr>
                            @empty

                            <tr>
                                <td colspan="8">
                                    <p class="text-danger" style="display: flex;justify-content: center !important"><strong>در حال حاضر هیچ پیامی یافت نشد!</strong></p>
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
</div>
@can('view resumes')
    <div class="row" >
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <p class="card-title">رزومه ها (جدید) </p>
                        <div class="card-options ">
                            <a href="{{ route('admin.resumes.index') }}" class="btn btn-outline-light ml-3">مشاهده
                                همه</a>
                        </div>
                    </div>
                    <div class="table-responsive attendance_table mt-4 border-top">
                        <table class="table mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">نام و نام خوانوادگی</th>
                                <th class="text-center">شغل</th>
                                <th class="text-center">موبایل</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">تاریخ ارسال</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($resumes as $resume)
                                <tr class="border-bottom">
                                    <td class="text-center">
                                        <span
                                            class="avatar avatar-sm brround">{{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $resume->name }}</td>
                                    <td class="text-center">{{ $resume->job->title }}</td>
                                    <td class="text-center">{{ $resume->mobile }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-transparent">در حال بررسی</span>
                                    </td>
                                    <td class="text-center">{{verta($resume->created_at)->format('Y/m/d H:i')}}</td>
                                    <td class="text-center">
                                        <a  href="{{ route('admin.resumes.show',$resume) }}"
                                        class="action-btns" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="مشاهده"><i
                                             class="feather feather-eye text-azure"></i></a>
                                    </td>
                                </tr>
                                @empty

                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger" style="display: flex;justify-content: center !important"><strong>در حال حاضر هیچ رزومه ای یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
@can('view purchase_advisors')
    <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <p class="card-title">مشاوره های خرید (تماس گرفته نشده) </p>
                        <div class="card-options ">
                            <a href="{{ route('admin.purchase-advisors.index') }}" class="btn btn-outline-light ml-3">مشاهده
                                همه</a>
                        </div>
                    </div>
                    <div class="table-responsive attendance_table mt-4 border-top">
                        <table class="table mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">نام</th>
                                <th class="text-center">موبایل</th>
                                <th class="text-center">محصول</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($advisors as $advisor)
                                <tr class="border-bottom">
                                    <td class="text-center">
                                        <span
                                            class="avatar avatar-sm brround">{{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $advisor->name }}</td>
                                    <td class="text-center">{{ $advisor->mobile }}</td>
                                    <td class="text-center">{{ $advisor->product->title }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger-transparent">تماس گرفته نشده</span>
                                    </td>
                                    <td class="text-center">{{verta($advisor->created_at)->format('Y/m/d H:i')}}</td>
                                </tr>
                                @empty

                                <tr>
                                    <td colspan="8">
                                        <p class="text-danger" style="display: flex;justify-content: center !important"><strong>در حال حاضر هیچ مشاوره ای یافت نشد!</strong></p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
@endsection
