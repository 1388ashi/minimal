<div class="col-md-12">
<div class="card ">
    <div class="card-header">
        <div class="card-title">فیلتر ها</div>
        <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                    class="fe fe-chevron-up"></i></a>
            <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i
                    class="fe fe-maximize"></i></a>
            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
    </div>
    <div class="card-body">
            <form action="{{ route("admin.products.index") }}">
                <div class="row">
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="form-group">
                            <label>عنوان:</label>
                            <input type="text" name="title" value="{{ request("title") }}" placeholder="عنوان را انتخاب کنید" class="form-control" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="form-group">
                            <label>دسته بندی :</label>
                            <select name="category_id" class="form-control">
                                <option value="">همه</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request("category_id") == $category->id)>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="form-group">
                            <label>تخفیف :</label>
                            <select name="discount" class="form-control">
                                <option value="">همه</option>
                                <option value="1" @selected(request("discount") == "1")>دارد</option>
                                <option value="0" @selected(request("discount") == "0")>ندارد</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="form-group">
                            <label>وضعیت :</label>
                            <select name="status" class="form-control">
                                <option value="">همه</option>
                                <option value="0" @selected(request("status") == "0")>غیر فعال</option>
                                <option value="1" @selected(request("status") == "1")>فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-12 col-md-6 col-xl-9">
                      <button class="btn btn-primary btn-block" type="submit">جستجو <i class="fa fa-search"></i></button>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                      <a href="{{ route('admin.products.index') }}"
                         class="btn btn-danger btn-block">حذف همه فیلتر ها <i class="fa fa-close"></i></a>
                    </div>

                  </div>
                </div>
            </form>
    </div>
</div>
</div>
@section('scripts')
<script>
    $('#payment_date_show').MdPersianDateTimePicker({
        targetDateSelector: '#payment_date',
        targetTextSelector: '#payment_date_show',
        englishNumber: false,
        toDate:true,
        enableTimePicker: false,
        dateFormat: 'yyyy-MM-dd',
        textFormat: 'yyyy-MM-dd',
        groupId: 'rangeSelector1',
    });
    $('#payment_date_show2').MdPersianDateTimePicker({
        targetDateSelector: '#payment_date2',
        targetTextSelector: '#payment_date_show2',
        englishNumber: false,
        toDate:true,
        enableTimePicker: false,
        dateFormat: 'yyyy-MM-dd',
        textFormat: 'yyyy-MM-dd',
        groupId: 'rangeSelector1',
    });
    </script>
    @endsection
