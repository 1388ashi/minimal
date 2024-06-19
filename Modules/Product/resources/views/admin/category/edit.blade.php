@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ویرایش دسته بندی</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ویرایش دسته بندی</p>
                </div>
                <div class="card-body">

                    <x-alert-danger></x-alert-danger>

                    <form action="{{ route('admin.categories.update',$category) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">عنوان<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان دسته بندی اینجا وارد کنید" value="{{ old('title', $category->title) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="label" class="control-label">تصویر</label>
                                    <input  class="form-control" type="file" name="image">
                                </div>
                            </div>
                            @if ($category->image['url'])
                            <div class="col-md-4">
                                <figure class="figure" style="min-width: 170px;max-height: 170px">
                                    <a target="blank" href="{{ $category->image['url'] }}">
                                    <img src="{{ $category->image['url'] }}" class="img-thumbnail" width="150" height="150" />
                                    </a>
                                </figure>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">والد</label>
                                    <select class="form-control custom-select" data-placeholder="انتخاب دسته بندی" name="parent_id">
                                        <option value="">بدون والد</option>
                                        @foreach($parents as $parent)
                                        <option value="{{$parent->id}}" @selected($parent->id == $category->parent_id)>{{$parent->title}}</option>
                                                <!-- نمایش دادن فرزندان هر والد -->
                                            @if($parent->has('recursiveChildren'))
                                                @foreach($parent->recursiveChildren as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $category->parent_id)>-{{ $item->title }} </option>
                                                    @if($item->has('children'))
                                                    @foreach($item->children as $child)
                                                        <option value="{{ $child->id }}" @selected($child->id == $category->parent_id)> --{{ $child->title }}</option>
                                                    @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span class="control-label ">
                                        ویژه
                                    </span>
                                    <label class="custom-control custom-checkbox mr-1 mt-1">
                                        <input style="cursor: pointer" type="checkbox" class="custom-control-input" name="featured" value="1" @checked(old('featured',$category->featured) == '1')>
                                        <span class="custom-control-label">فعال</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span class="control-label ">
                                        وضعیت
                                    </span>
                                    <label style="cursor: pointer" class="custom-control custom-checkbox mr-1 mt-1">
                                        <input type="checkbox" class="custom-control-input" name="status" value="1" @checked(old('status',$category->status) == '1')>
                                        <span class="custom-control-label">فعال</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button class="btn btn-warning" type="submit">به روزرسانی</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div><!-- col end -->
    </div>
    <!-- row closed -->
@endsection
