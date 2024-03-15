$(document).ready(function() {
    $('.open-modal').click(function() {
        var libroId = $(this).data('idbook');
        $('#idLibro').val(libroId);
    });
});
