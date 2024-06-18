@foreach($blog_categories as $blog_category)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $blog_category->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('admin.blog-categories.update', $blog_category->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                
                <div class="modal-header">
                    <p class="modal-title font-weight-bolder">ویرایش دسته بندی</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label >عنوان<span class="text-danger">&starf;</span></label>
                        <input type="text" class="form-control" name="title"  placeholder="عنوان را اینجا وارد کنید" value="{{ old('title', $blog_category->title) }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label >نوع<span class="text-danger">&starf;</span></label>
                        <select class="form-control select2" name="type">
                            <option value="news" @selected($blog_category->type == 'news')>خبری</option>
                            <option value="article" @selected($blog_category->type == 'article') >مقاله</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <span class="control-label ">
                            وضعیت
                        </span>
                        <label class="custom-control custom-checkbox mr-1 mt-1">
                            <input style="cursor: pointer" type="checkbox" class="custom-control-input" name="status" value="1" @checked(old('status',$blog_category->status) == '1')>
                            <span class="custom-control-label">فعال</span>
                        </label>
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