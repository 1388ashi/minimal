$(document).ready(function (){
$(".item-delete").click(function (){
    $("#item_id").val($(this).data('id'));
    $("#delete_title").html($(this).data('title'));

    $("#delete-form").slideDown();
    var modelId = $(this).data('id');
    $('#deleteModal').find('#modal-id').val(modelId);
});

$('#deleteForm').submit(function() {
var modelId = $('#modal-id').val();
$(this).attr('action', "{{ route('admin.categories.destroy') }}" + "/" + modelId);
});
$("#delete-cancel").click(function (e){
    e.preventDefault();
    $("#item_id").val('');
    $("#delete_title").html('');

    $("#delete-form").slideUp();
    return false;
});

});