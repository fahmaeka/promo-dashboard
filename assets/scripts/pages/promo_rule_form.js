$('body').on('click', '.btn-add-detail', function(){
    $('#promo_rule_detail .clone').clone().appendTo('#promo_rule_detail').removeClass('hidden clone');
});
$('body').on('click', '.btn-remove-detail', function(){
    if ($('#promo_rule_detail div.row').length > 2) {
        $(this).parent().parent().parent().parent().parent().remove();
    }
});
