@foreach($purchaseAdvisors as $purchaseAdvisor)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $purchaseAdvisor->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('admin.purchase-advisors.update', $purchaseAdvisor->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                <div class="modal-header">
                    <p class="modal-title font-weight-bolder">ویرایش وضعیت {{$purchaseAdvisor->name}}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="select2" name="status">
                            <option value="called" @selected($purchaseAdvisor->status == 'called')>تماس گرفته شده</option>
                            <option value="notcalled" @selected($purchaseAdvisor->status == 'notcalled')>تماس گرفته نشده</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button  class="btn btn-warning text-right item-right">به روزرسانی</button>
                    <button class="btn btn-outline-danger  text-right item-right" data-dismiss="modal">برگشت</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endforeach