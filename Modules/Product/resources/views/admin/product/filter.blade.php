<div class="card">
    <div class="card-header border-0">
        <p class="card-title" style="font-weight: bolder;">جستجو پیشرفته</p>
    </div>
    <div class="card-body">
        <div class="row">
            <form action="{{ route("admin.products.index") }}" class="col-12">
                <div class="row">
                    <div class="col-3 form-group">
                        <label class="font-weight-bold">عنوان:</label>
                        <input type="text" name="title" value="{{ request("title") }}" placeholder="عنوان را انتخاب کنید" class="form-control" />
                    </div>
                    <div class="col-3 form-group">
                        <label class="font-weight-bold">دسته بندی :</label>
                        <select name="category_id" class="form-control select2">
                            <option value="">همه</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request("category_id") == $category->id)>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 form-group">
                        <div class="form-group">
                            <label class="font-weight-bold">تخفیف :</label>
                            <select name="discount" class="form-control">
                                <option value="">همه</option>
                                <option value="1" @selected(request("discount") == "1")>دارد</option>
                                <option value="0" @selected(request("discount") == "0")>ندارد</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 form-group">
                        <div class="form-group">
                            <label class="font-weight-bold">وضعیت :</label>
                            <select name="status" class="form-control">
                                <option value="">همه</option>
                                <option value="0" @selected(request("status") == "0")>غیر فعال</option>
                                <option value="1" @selected(request("status") == "1")>فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-9">
                            <button class="col-12 btn btn-primary align-self-center">جستجو</button>
                        </div>
                        <div class="col-3">
                            <a href="{{route('admin.products.index')}}" class="col-12 btn btn-danger align-self-center">حذف فیلتر ها</a>
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