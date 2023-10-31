$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел ролей пользователей');
    $('#js-roles-edit-form').parsley();
    $('.js-select-roles').select2();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}