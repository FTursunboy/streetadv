$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел языков');
    $('#js-languages-edit-form').parsley();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}