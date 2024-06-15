@if($purchaseAdvisor->status == 'called')
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-success ">تماس گرفته شده</p>
@else
    <p data-placement="top" data-toggle="tooltip" title="وضعیت" class="badge badge-danger ">تماس نگرفته</p>
@endif