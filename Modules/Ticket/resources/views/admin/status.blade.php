@if($ticket->status == 'pending')
    <p title="وضعیت" class="badge badge-warning ">در حال بررسی</p>
@elseif($ticket->status == 'new')
    <p title="وضعیت" class="badge badge-primary ">جدید</p>
@elseif($ticket->status == 'accepted')
    <p title="وضعیت" class="badge badge-success ">تایید شده</p>
@endif
