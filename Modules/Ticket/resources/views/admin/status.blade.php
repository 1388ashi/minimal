@if($ticket->status == 'pending')
    <span title="وضعیت" class="badge badge-danger ">خوانده نشده</span>
@elseif($ticket->status == 'accepted')
    <span title="وضعیت" class="badge badge-success ">خوانده شده</span>
@endif
