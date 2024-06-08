{{-- <button  class="btn btn-danger btn-sm item-delete text-white"   data-toggle="modal" data-target="#deleteModal" data-title="{{$model->title}}" data-id="{{$model->id}}">
    <i class="fa fa-trash-o"></i>
</button> --}}
<button type="button" class="btn btn-danger btn-sm text-white" data-original-title="حذف" onclick="confirmDelete('delete-{{ $model->id }}')">
    <i class="fa fa-trash-o"></i>
</button>
<form 
    action="{{ route($route,$model)}}" 
    id="delete-{{$model->id}}" 
    method="POST" 
    style="display: none;">
    @csrf
    @method("DELETE")
</form>
{{-- 
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="text-start">
                <span class="text-start">آیا از حذف</span>
                <mark class="text-start" id="delete_title"></mark>
                <span class="text-start">مطمئن هستید؟</span>
            </div>

        </div>
        <div class="modal-footer">
            <form action="{{ route($route,$model)}}" method="post">
                @method('delete')
                @csrf
                <input type="hidden" name="type" value="cat_delete">
                <input type="hidden" name="item_id" id="item_id" value="">
                <button type="button" class="btn btn-warning" data-dismiss="modal">انصراف</button>
                <button type="submit" class="btn btn-danger">حذف شود</button>
            </form>                    
        </div>
    </div>
</div> --}}