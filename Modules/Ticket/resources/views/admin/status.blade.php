@if($ticket->status == 'pending')
    <span title="وضعیت" class="badge badge-warning ">در حال بررسی</span>
@elseif($ticket->status == 'new')
    <span title="وضعیت" class="badge badge-primary ">جدید</span>
@elseif($ticket->status == 'accepted')
    <span title="وضعیت" class="badge badge-success ">تایید شده</span>
@endif
