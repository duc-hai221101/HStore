$(document).ready(function () {
    // Xử lý sự kiện click vào checkbox "Check All"
    $('#check_all').on('click', function () {
        $('.checkbox_child, .checkbox_wrapper').prop('checked', $(this).prop('checked'));
    });

    // Xử lý sự kiện click vào các checkbox con
    $('.checkbox_child').on('click', function () {
        if ($('.checkbox_child:checked').length === $('.checkbox_child').length) {
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }
    });

    // Xử lý sự kiện click vào checkbox "checkbox_wrapper"
    $('.checkbox_wrapper').on('click', function () {
        $(this).closest('.card').find('.checkbox_child').prop('checked', $(this).prop('checked'));
        if ($('.checkbox_wrapper:checked').length === $('.checkbox_wrapper').length) {
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }
    });
});