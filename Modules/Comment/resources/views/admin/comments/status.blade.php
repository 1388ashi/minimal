@if($comment->status == 'pending')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-primary ">در حال بررسی</p>
@elseif($comment->status == 'rejected')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-danger ">رد شده</p>
@elseif($comment->status == 'accepted')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-success ">تایید شده</p>
@endif