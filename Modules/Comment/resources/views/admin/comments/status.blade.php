@if($comment->status == 'pending')
    <span class="badge badge-primary ">در حال بررسی</span>
@elseif($comment->status == 'rejected')
    <span class="badge badge-danger ">رد شده</span>
@elseif($comment->status == 'accepted')
    <span class="badge badge-success ">تایید شده</span>
@endif