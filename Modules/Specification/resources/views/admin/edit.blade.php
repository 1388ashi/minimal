@extends('admin.layouts.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.specifications.index') }}">لیست مشخصات ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ویرایش مشخصات</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    <!-- row opened -->
    <div class="row mx-3">
        <div class="col-md">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <p class="card-title" style="font-size: 15px;">ویرایش مشخصات</p>
                </div>
                <div class="card-body">

                    <x-alert-danger></x-alert-danger>

                    <form action="{{ route('admin.specifications.update',$specification) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">نام<span class="text-danger">&starf;</span></label>
                                    <input type="text" class="form-control" name="name"placeholder="نام مشخصات اینجا وارد کنید" value="{{ old('name', $specification->name) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label">مشخصات ها</label><span class="text-danger">&starf;</span>
                                    <select class="form-control select2" name="categories[]" id="tags" multiple="multiple">
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}"  @selected(in_array($category->id, old('categories', $specification->categories->pluck('id')->all())))>{{$category->title}}</option>
                                                <!-- نمایش دادن فرزندان هر والد -->
                                            @if($category->has('recursiveChildren'))
                                                @foreach($category->recursiveChildren as $item)
                                                    <option value="{{ $item->id }}"  @selected(in_array($item->id, old('categories', $specification->categories->pluck('id')->all())))>-{{ $item->title }} </option>
                                                    @if($item->has('children'))
                                                    @foreach($item->children as $child)
                                                        <option value="{{ $child->id }}"  @selected(in_array($child->id, old('categories', $specification->categories->pluck('id')->all())))>--{{ $child->title }}</option>
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
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.js-tags-example').select2({
                tags:false
            });
        });
    </script>
@endsection