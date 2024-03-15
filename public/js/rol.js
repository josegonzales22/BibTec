$(document).ready(function() {
    $('.open-modal').click(function() {
        var rolId = $(this).data('roleid');
        $('#role_id').val(rolId);
    });
});
