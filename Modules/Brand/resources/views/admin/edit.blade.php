@foreach($brands as $brand)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $brand->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('admin.brands.update', $brand->id)}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PATCH')
                
                <div class="modal-header">
                    <p class="modal-title font-weight-bolder">ویرایش برند</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="label">عنوان</label><span class="text-danger">&starf;</span>
                                <input class="form-control" type="text" name="title" value="{{old('title',$brand->title)}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="label" >تصویر بک گراند</label> 
                                <input  class="form-control" type="file" name="background">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="label" >لوگو سفید</label><span class="text-danger">&starf;</span>
                                <input  class="form-control" type="file" name="white_image">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="label" >لوگو مشکی</label><span class="text-danger">&starf;</span>
                                <input  class="form-control" type="file" name="dark_image">
                            </div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>توضیحات</label><span class="text-danger">&starf;</span>
                                <textarea name="description" class="form-control ckeditor" cols="100" rows="4">{{old('description',$brand->description)}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">دسته بندی ها</label><span class="text-danger">&starf;</span>
                                <select class="form-control selectMultiple" name="categories[]"
                                        required multiple>
                                    @foreach($allCategories as $id => $category)
                                        <option
                                            value="{{ $id }}" @selected($brand->categories->contains($id))>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="label" >اسلاگ</label><span class="text-danger">&starf;</span>
                                <input class="form-control" type="text" name="slug" value="{{old('slug',$brand->slug)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title_page" >عنوان صفحه</label>
                                <input type="text" class="form-control" name="title_page" id="title_page" placeholder="عنوان صفحه محتوا اینجا وارد کنید" value="{{old('title_page',$brand->title_page)}}" autofocus>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title_page">متا دسکریپشن</label>
                                <textarea name="meta_description"  class="form-control" id="">{{ old('meta_description',$brand->meta_description) }}</textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <span class="control-label ">
                                    وضعیت
                                </span>
                                <label class="custom-control custom-checkbox mr-1 mt-1">
                                    <input type="checkbox" class="custom-control-input" name="status" value="1" @checked($brand->status)>
                                    <span class="custom-control-label">فعال</span>
                                </label>
                            </div>
                        </div>
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