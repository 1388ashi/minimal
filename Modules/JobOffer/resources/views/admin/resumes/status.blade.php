@if($resume->status == 'pending')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-warning ">در حال بررسی</p>
@elseif($resume->status == 'rejected')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-danger ">رد شده</p>
@elseif($resume->status == 'accepted')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-success ">تایید شده</p>
@elseif($resume->status == 'new')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-info ">جدید</p>
@elseif($resume->status == 'confirm_interview')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-primary ">تایید برای مصاحبه</p>
@endif