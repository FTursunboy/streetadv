$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    // First settings
    $('.js-page-title').html('Раздел настроек');

    // Form validation
    $('#js-settings-edit-form').parsley();
});
function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}