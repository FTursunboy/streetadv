$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел квестов');
    var drEvent = $('.dropify').dropify({
        messages: {
            'default': 'Выбырите или перенесите сюда файл',
            'replace': 'Выбырите или перенесите сюда файл',
            'remove': 'Удалить',
            'error': 'Ошибка. Что-то пошло не так'
        }
    });

    // Delete quest files
    if ($('#js-quests-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-quests-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

    $('.js-select-category').select2();
    $('#js-quests-edit-form').parsley();


    // $.mask.definitions['~']='[-]?';

    // $('#latitude').mask('~99.999999');
    // $('#longitude').mask('~99.999999');
    // $('#bottomLeftLat').mask('99.999999');
    // $('#bottomLeftLng').mask('99.999999');
    // $('#topRightLat').mask('99.999999');
    // $('#topRightLng').mask('99.999999');

});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}