$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел промокодов');
    $('#js-promocodes-edit-form').parsley();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}