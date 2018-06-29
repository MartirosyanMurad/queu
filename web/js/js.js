$(document).ready(function ($) {
    $('#layouts_list li').on('click',function () {
        $('#layouts_list li').removeClass('active')
        $(this).addClass('active');
        $('#layout').val($(this).data('val'));

    })
    $('#book_table .free').on('dblclick',function () {
        $('#book_time').val($(this).data('time'));
        $('#bookModal').modal('show');
    })
    $('#book_form_submit').on('click', function () {
        $('#book_form').submit();
    })
})