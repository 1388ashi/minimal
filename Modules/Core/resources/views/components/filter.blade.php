    <div class="card">
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
            <form class=" col-12" action="{{ $action }}" method="get" id="filter-form">
                <div class="row">
                    @foreach($inputs as $input => $value)
                    @if(in_array($value['type'], ['text', 'number', 'email']))
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="form-group ">
                            <input type="{{ $value['type'] }}" name="{{ $input }}" class="form-control"
                            placeholder="{{ $value['placeholder'] }}" value="{{ request($input) }}">
                        </div>
                    </div>
                    @endif
                    @if(in_array($value['type'], ['select', 'select-multiple']))
                    <div class="col-xl-3 col-lg-6 col-12">   
                        <div class="form-group ">
                            <select
                                class="form-control select2 @if($value['type'] == 'select-multiple') select2-show-search @endif"
                                name="{{ $input }}" @if($value['type'] == 'select-multiple') multiple @endif>
                                <option class="text-muted" value="">{{ $value['placeholder'] }}</option>
                                @foreach($value['options'] as $option => $label)
                                    <option
                                        value="{{ $option }}" @selected(request($input) == $option)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    @if($value['type'] == 'date')
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="form-group ">
                            <input type="{{ $value['type'] }}" name="{{ $input }}" class="form-control"
                                    placeholder="{{ $value['placeholder'] }}" id="{{ $input }}" value="{{ request($input) }}">
                            <span id="span_{{ $input }}"></span>
                        </div>
                    </div>
                    @endif
                @endforeach
                </div>
            </form>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-12 col-md-9 mb-2 mb-md-0">  
                    <button type="submit" class="col-12 btn btn-primary" form="filter-form">جستجو</button>
                </div>
                <div class="col-12 col-md-3">  
                    <a href="{{ $action }}" class="col-12 btn btn-danger align-self-center">حذف فیلترها <i
                                class="fa fa-close"
                                aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
