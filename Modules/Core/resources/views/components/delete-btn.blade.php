<button type="button" class="btn btn-danger btn-sm text-white" data-original-title="حذف"  onclick="confirmDelete('delete-{{ $model->id }}')" >
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