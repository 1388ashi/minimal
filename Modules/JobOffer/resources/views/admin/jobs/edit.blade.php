@foreach($jobs as $job)
    <div class="modal fade mt-5" tabindex="-1" id="edit-menu-{{ $job->id }}" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('admin.jobs.update', $job->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                
                <div class="modal-header">
                    <p class="modal-title font-weight-bolder">ویرایش شغل</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label >عنوان<span class="text-danger">&starf;</span></label>
                                <input type="text" class="form-control" name="title"   placeholder="عنوان را اینجا وارد کنید" value="{{ old('title', $job->title) }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label >ساعت کاری<span class="text-danger">&starf;</span></label>
                                <input type="text" class="form-control" name="times"  placeholder="ساعت کاری را اینجا وارد کنید" value="{{ old('times', $job->times) }}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label >نوع<span class="text-danger">&starf;</span></label>
                                <select class="form-control select2" name="type">
                                    <option value="part-time" @selected($job->type == 'part-time')>پاره وقت</option>
                                    <option value="full-time" @selected($job->type == 'full-time') >تمام وقت</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <span class="control-label ">
                                    وضعیت
                                </span>
                                <span class="text-danger">&starf;</span>
                                <label  style="cursor: pointer" class="custom-control custom-checkbox mr-1 mt-1">
                                    <input type="checkbox" class="custom-control-input" name="status" value="1" @checked($job->status)>
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