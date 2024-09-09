@extends('admin.layouts.master')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-home ml-1"></i>
                داشبورد</a></li>
    </ol>
</div>
@can('view dashboard stats')
<div class="row">
    <div class="col-xl-9 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <a href="{{route('admin.orders.index')}}">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold"> تعداد کل سفارشات : </span>
                                        <p class="mb-0 mt-1 text-primary fs-20"> {{ number_format($ordersCount) }}</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                            <div class="icon1 bg-primary-transparent my-auto float-left">
                                <i class="fe fe-users"></i>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <a href="{{route('admin.orders.index')}}">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold"> تعداد سفارشات امروز :</span>
                                        <p class="mb-0 mt-1 text-pink  fs-20">{{ number_format($orderCountToday) }}</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                <div class="icon1 bg-pink -transparent my-auto float-left">
                                    <i class="feather feather-box"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <a href="{{route('admin.orders.index')}}">
                            <div class="mt-0 text-right">
                            <span class="fs-16 font-weight-semibold"> میزان فروش امروز :</span>
                                <p class="mb-0 mt-1 text-success fs-20"> {{ number_format($totalSalesToday) == 0 ? number_format($totalSalesToday) : number_format($totalSalesToday) . 'تومان'  }} </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-3">
                    <div class="icon1 bg-success-transparent my-auto float-left">
                        <i class="feather feather-dollar-sign"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="card-title">آمار فروش</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <canvas id="barChart" width="400" height="200"></canvas>
                            <select id="dataSelect">
                                <option value="totalSales">فروش این ماه</option>
                                <option value="month">ماه</option>
                                <option value="year">فروش سال</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-12">
      <div class="card">
        <div class="card-header  border-0">
            <a href="">
                <div class="card-title">آخرین فعالیت ها</div>
            </a>
        </div>
        <div class="card-body">
            <div class="list-group">
                @php($i = null)
                @foreach ($activityLogs as $activityLog)
                @php($i++)
                @if ($i % 2 == 0)
                <div class="list-group-item d-flex pt-3 pb-3 align-items-center border-0 p-0 m-0">
                    <div class="ml-3 ml-xs-0">
                        <div class="calendar-icon icons" style="line-height:0;">
                            <div class="date_time bg-pink-transparent"> <span class="date" style="line-height: normal;">{{verta($activityLog->created_at)->format('m/d H:i')}}</span></div>
                        </div>
                    </div>
                    <div class="ml-1">
                        <div class=" mb-1"><span class="font-weight-normal">{{$activityLog->description}}</span></div>
                    </div>
                </div>
                @else
                <div class="list-group-item d-flex pt-3 pb-3 align-items-center border-0 p-0 m-0">
                    <div class="ml-3 ml-xs-0">
                        <div class="calendar-icon icons" style="line-height:0;">
                            <div class="date_time bg-info-transparent "><span class="date" style="line-height: normal;">{{verta($activityLog->created_at)->format('m/d H:i')}}</span></div>
                        </div>
                    </div>
                    <div class="ml-1">
                        <div class=" mb-1"><span class="font-weight-normal">{{$activityLog->description}}</span></div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
       </div>
    </div>
</div>
@endcan
<div class="row col-12">
    @can('view comments')
        <div class="col-6">
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
                                        <span class="badge bg-primary-transparent">در حال بررسی</span>
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
    <div class="col-6">
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
                                    <span class="badge bg-info-transparent">جدید</span>
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
@can('view resumes')
        <div class="row col-12">
            <div class="col-12">
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
@endcan
    @can('view purchase_advisors')
        <div class="row col-12">
            <div class="col-12">
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

@endcan
@endsection
