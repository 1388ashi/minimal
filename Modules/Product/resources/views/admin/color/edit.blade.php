@foreach($colors as $color)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $color->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('admin.colors.update', $color->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                
                <div class="modal-header">
                    <p class="modal-title font-weight-bolder">ویرایش رنگ</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label >عنوان<span class="text-danger">&starf;</span></label>
                        <input type="text" class="form-control" name="title"  placeholder="عنوان را اینجا وارد کنید" value="{{ old('title', $color->title) }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="color">رنگ را انتخاب کنید:</label>
                        <input type="color" id="color" name="code" value="{{$color->code}}" onchange="updateColor(this.value)">
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