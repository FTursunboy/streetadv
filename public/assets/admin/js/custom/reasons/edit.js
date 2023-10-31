$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел причин обращения');
    $('#js-reasons-edit-form').parsley();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}