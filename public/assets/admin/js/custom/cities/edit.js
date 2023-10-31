$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел городов');
    $('#js-cities-edit-form').parsley();
    $('#lat').mask('99.999999');
    $('#lng').mask('99.999999');
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}