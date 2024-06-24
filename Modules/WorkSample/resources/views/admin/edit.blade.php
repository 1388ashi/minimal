@foreach($workSamples as $workSample)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $workSample->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('admin.work-samples.update', $workSample->id)}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="modal-header">
                        <p class="modal-title font-weight-bolder">ویرایش نمونه کار</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label  class="control-label">عنوان<span class="text-danger">&starf;</span></label>
                                <input type="text" class="form-control" name="title"  placeholder="عنوان را اینجا وارد کنید" value="{{ old('title', $workSample->title) }}" required autofocus>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="control-label" for="label" >تصویر</label>
                                <input  class="form-control" type="file" name="image" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">گالری تصویر</label>
                            <input type="file" name="galleries[]" class="form-control" multiple="multiple">
                        </div>
                        <div class="row">
                            <div class="form-group d-flex">
                            @if ($workSample->galleries)
                            @foreach($workSample->galleries as $item)
                                <button type="button" style="height: fit-content;" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-galleries-{{$item['id'] }}')">
                                    <i class="fa fa-times"></i>
                                </button>
                                <br>
                                <figure class="figure">
                                    <a target="_blank" href="{{ $item['url'] }}">
                                        <img src="{{ $item['url'] }}" class="img-thumbnail" style="width: 70px;height: 70px;" />
                                    </a>
                                </figure>
                                @endforeach
                                @endif
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
    @if ($workSample->galleries)
    @foreach ($workSample->galleries as $media)
        <form
        action="{{ route('admin.work-samples.galleries.destroy', $media) }}"
        id="delete-galleries-{{$media['id']}}"
        method="POST"
        style="display: none;">
        @csrf
        @method("DELETE")
        </form>
    @endforeach
    @endif
@endforeach
