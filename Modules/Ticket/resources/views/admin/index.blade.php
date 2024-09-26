@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header mx-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page">لیست همه تماس با ما</li>
        </ol>
    </div>

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md-12">
            <x-core::filter action="{{ route('admin.tickets.index') }}" :inputs="$filterInputs"/>
            <div class="card">
                <div class="card-header border-0">
                    <div class="card-title">لیست  تماس با ما ({{ $tickets->total() }})</div>
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
                                    <th class="border-top">موبایل</th>
                                    <th class="border-top">ایمیل</th>
                                    <th class="border-top">وضعیت</th>
                                    <th class="border-top">تاریخ ثبت</th>
                                    <th class="border-top">عملیات</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $ticket->name }}</td>
                                <td>{{ $ticket->mobile }}</td>
                                <td>{{ $ticket->email }}</td>
                                <td>@include('ticket::admin.status', ['status' => $ticket->status])</td>
                                <td>{{verta($ticket->created_at)->format('Y/m/d H:i')}}</td>
                                <td>
                                    {{-- Edit--}}
                                    @can('view tickets')
                                    <button type="button" class="btn btn-primary btn-sm "
                                    data-toggle="modal"
                                    onclick="showDescriptionModal({{$ticket}})"
                                    data-original-title="توضیحات">
                                    <i class="fa fa-eye"></i>
                                    </button>
                                    @endcan
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
                        {{$tickets->onEachSide(1)->links("vendor.pagination.bootstrap-4")}}
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    @include('ticket::admin.description')
    @endsection
@section('scripts')
<script>

    function showDescriptionModal (ticket) {

        let ticketId = ticket.id;
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '{{ route("admin.tickets.update") }}',
            type: 'PATCH',
            data: {ticket_id: ticketId},
            headers: {'X-CSRF-TOKEN': token},
        });

        let modal = $('#showDescriptionModal');
        modal.find('#description').text(`${ticket.description}` ?? '-');
        modal.modal('show');

    }
</script>
@endsection
