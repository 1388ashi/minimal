@if($resume->status == 'pending')
    <span data-toggle="tooltip" title="وضعیت" class="badge badge-warning ">در حال بررسی</span>
@elseif($resume->status == 'rejected')
    <span data-toggle="tooltip" title="وضعیت" class="badge badge-danger ">رد شده</span>
@elseif($resume->status == 'accepted')
    <span data-toggle="tooltip" title="وضعیت" class="badge badge-success ">استخدام شده</span>
@elseif($resume->status == 'new')
    <span data-toggle="tooltip" title="وضعیت" class="badge badge-info ">جدید</span>
@elseif($resume->status == 'confirm_interview')
    <span data-toggle="tooltip" title="وضعیت" class="badge badge-primary ">تایید برای مصاحبه</span>
@endif