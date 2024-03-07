$(document).ready(function() {
    $('.open-modal').click(function() {
        var autorId = $(this).data('id');
        var autorInfo = $(this).data('info');
        $('#info').val(autorInfo);
        $('#autor_id').val(autorId);
    });
});
