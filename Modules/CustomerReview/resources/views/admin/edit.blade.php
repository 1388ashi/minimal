@foreach($customerReviews as $customerReview)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $customerReview->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('admin.customer-reviews.update', $customerReview->id)}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PATCH')

                <div class="modal-header">
                    <p class="modal-title font-weight-bolder">ویرایش نظر</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label  class="control-label">نام<span class="text-danger">&starf;</span></label>
                            <input type="text" class="form-control" name="name"  placeholder="نام را اینجا وارد کنید" value="{{ old('name', $customerReview->name) }}" required autofocus>
                        </div>
                        <div class="form-group col-lg-6">
                            <label  class="control-label">شهر<span class="text-danger">&starf;</span></label>
                            <input type="text" id="city"  class="form-control" name="city" placeholder="شهر را اینجا وارد کنید" value="{{ old('city', $customerReview->city) }}" required autofocus>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label" for="label" >تصویر</label>
                            <input  class="form-control" type="file" name="image" >
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label">ویدیو</label>
                            <input class="form-control" type="file" name="video">
                        </div>
                    </div>
                        @if ($customerReview->video['url'])
                        <div class="col-lg-6 d-flex" style="margin-top: 2rem">  
                            <button type="button" class="btn btn-danger btn-sm ml-1 d-flex" style="height: fit-content; justify-content: center; align-items: center;" onclick="confirmDelete('delete-video-{{ $customerReview->id }}')">  
                                <i class="fa fa-trash-o"></i>  
                            </button>  
                            <br>  
                            <figure class="figure">  
                                <a target="blank" href="{{ $customerReview->video['url'] }}">  
                                    {{ $customerReview->video['name'] }}  
                                </a>  
                            </figure>  
                        </div>  
                        @endif
                        <div class="form-group">
                            <label  class="control-label col-12">توضیحات<span class="text-danger">&starf;</span></label>
                            <textarea class="form-control" name="description" cols="61" rows="3" required>{{$customerReview->description}}</textarea>
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
    @if ($customerReview->video['url'])
         <form  
            action="{{ route('admin.customer-reviews.video.destroy', $customerReview) }}"  
            id="delete-video-{{$customerReview->id}}"  
            method="POST"  
            style="display: none;">  
            @csrf  
            @method("DELETE")  
        </form>
    @endif
@endforeach
