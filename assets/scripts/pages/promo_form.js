$('body').on('click', '.btn-add-detail', function(){
    $('#promo_detail .clone').clone().appendTo('#promo_detail').removeClass('hidden clone');
});
$('body').on('click', '.btn-remove-detail', function(){
    if ($('#promo_detail tr').length > 2) {
        $(this).parent().parent().remove();
    }
});
$('body').on('click', '.btn-add-period', function(){
    $('#promo_period .clone').clone().appendTo('#promo_period').removeClass('hidden clone');
    $('.period_time').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 5,
        minDate: "today",
        drops: "up",
        locale: {
            format: 'YYYY/MM/DD HH:mm'
        }
    });
});
$('body').on('click', '.btn-remove-period', function(){
    if ($('#promo_period tr').length > 2) {
        $(this).parent().parent().remove();
    }
});
$('.period_time').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    timePickerIncrement: 5,
    minDate: "today",
    drops: "up",
    locale: {
        format: 'YYYY/MM/DD HH:mm'
    }
});
