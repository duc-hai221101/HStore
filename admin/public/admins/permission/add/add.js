$(document).ready(function() {
    $('#check_all').on('change', function() {
        $('.module_child').prop('checked', $(this).is(':checked'));
    });
});