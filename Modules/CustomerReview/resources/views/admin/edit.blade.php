@foreach($customerReviews as $customerReview)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $customerReview->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('admin.customer-reviews.update', $customerReview->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                
                <div class="modal-header">
                    <p class="modal-title font-weight-bolder">ویرایش نظر</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="control-label">نام<span class="text-danger">&starf;</span></label>
                        <input type="text" class="form-control" name="name"  placeholder="نام را اینجا وارد کنید" value="{{ old('name', $customerReview->name) }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label  class="control-label">شهر<span class="text-danger">&starf;</span></label>
                        <input type="text" id="city"  class="form-control" name="city" placeholder="شهر را اینجا وارد کنید" value="{{ old('city', $customerReview->city) }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="label" >تصویر</label><span class="text-danger">&starf;</span>
                        <input  class="form-control" type="file" name="image">
                    </div>
                    <div class="form-group">
                        <label  class="control-label">توضیحات<span class="text-danger">&starf;</span></label>
                        <textarea class="form-control" name="description" cols="61" rows="3">{{$customerReview->description}}</textarea>
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