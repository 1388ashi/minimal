@extends('admin.layouts.master')

@section('content')
<div class="page-header mx-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i>
                داشبورد</a></li>
        <li class="breadcrumb-item active" aria-current="page">ویرایش درباره ما</li>
    </ol>
    <div class="mt-lg-0 mx-3">
        <div class="row">
            <div class="col">
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-setting">
                        حذف کلید
                        <i class="fa fa-trash"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="delete-setting" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">حذف کلید</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.about-us.destroy') }}" class="save" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">نام کلید <span class="text-danger">&starf;</span></label>
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="نام کلید را به انگلیسی اینجا وارد کنید" value="{{ old('name') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="text-center">
                                                    <button class="btn btn-danger" type="submit">حذف</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-setting">
                        ثبت کلید جدید
                        <i class="fa fa-plus"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="create-setting" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                            aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ثبت کلید جدید</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.about-us.store') }}" class="save" method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">نام کلید <span class="text-danger">&starf;</span></label>
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="نام کلید را به انگلیسی اینجا وارد کنید" value="{{ old('name') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="label" class="control-label">نام قابل خواندن <span class="text-danger">&starf;</span></label>
                                                    <input type="text" class="form-control" name="label" id="label" placeholder="نام قابل خواندن را به فارسی اینجا وارد کنید" value="{{ old('label') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="type" class="control-label">نوع کلید</label>
                                                    <span class="text-danger">&starf;</span>
                                                    <select class="form-control" name="type" id="type" required>
                                                        <option class="text-muted">-- نوع کلید مورد نظر را انتخاب کنید --</option>
                                                        @foreach($types as $key => $text)
                                                            <option value="{{ $key }}" @selected($key == old('type'))>{{ $text }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="text-center">
                                                    <button class="btn btn-pink" type="submit">ثبت و ذخیره</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Page-header closed -->

<!-- row opened -->
<div class="row mx-2">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <p class="ps-50">ویرایش درباره ما</p>
            </div>
            <div class="card-body">
                <x-alert-danger></x-alert-danger>
                <x-alert-success></x-alert-success>
                @include('core::includes.validation-errors')

                <form action="{{ route('admin.about-us.update') }}" class="save" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        @foreach($aboutUsTypes as $type => $items)
                            @if($type == \Modules\About\Models\AboutUs::TYPE_TEXT or $type == \Modules\About\Models\AboutUs::TYPE_NUMBER)
                                @foreach($items as $item)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="{{ $item->name }}">{{ $item->label }}</label>
                                            <input style="width: 50%"  type="{{ $type }}" name="{{ $item->name }}"
                                                id="{{ $item->name }}" @if($type == 'number') min="0"
                                                @endif value="{{ $item->text }}" class="form-control">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if($type == \Modules\About\Models\AboutUs::TYPE_IMAGE)
                                @foreach($items as $item)
                                    <div class="col-12 d-flex ">
                                        <div class="form-group">
                                            <label for="{{ $item->name }}">{{ $item->label }}</label>
                                            <input type="file" name="{{ $item->name }}" id="{{ $item->name }}"
                                            class="form-control">
                                        </div>
                                        @if($item->text && $type == \Modules\About\Models\AboutUs::TYPE_IMAGE)
                                        <button type="button" style="height: fit-content;" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('delete-{{ $item->id }}')">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <br>
                                            <figure class="figure d-flex align-items-center">
                                                <img src="{{ $item->file['url'] }}" class="img-thumbnail"
                                                    width="70" height="50" alt="{{ $item->label }}">
                                                <figcaption
                                                    class="figure-caption text-xs-right">{{ $item->label }}</figcaption>
                                            </figure>
                                            {{-- @elseif($type == \Modules\About\Models\AboutUs::TYPE_VIDEO)
                                                <video width="320" height="240" controls>
                                                    <source src="{{ $item->file['url'] }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video> --}}
                                            @endif
                                        </div>
                                @endforeach
                            @endif
                            @if($type == \Modules\About\Models\AboutUs::TYPE_TEXTAREA)
                                @foreach($items as $item)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="{{ $item->name }}">{{ $item->label }}</label>
                                            <textarea
                                            style="height: 150px;"
                                                class="form-control ckeditor"
                                                name="{{ $item->name }}"
                                                id="{{ $item->name }}">{!! $item->text !!}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning">به روزرسانی</button>
                    </div>
                </form>

                @foreach($aboutUsTypes as $type => $items)
                    @if($type == \Modules\About\Models\AboutUs::TYPE_IMAGE)
                        @foreach($items as $item)
                            <form action="{{ route('admin.about-us.deleteFile', [$item->id]) }}"
                                  id="delete-{{ $item->id }}" method="post" style="display: none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection

@section('scripts')
<script>
    $(function (e) {
        $('.summernote').summernote({
            placeholder: 'لطفا متن مورد نظر را در این قسمت بنویسید',
            tabsize: 3,
            height: 300
        });
    });
</script>
@endsection
