$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел заготовленных фраз к квесту - ' + $('.header-title').data('quest-name'));
    var drEvent = $('.dropify').dropify({
        messages: {
            'default': 'Выбырите или перенесите сюда файл',
            'replace': 'Выбырите или перенесите сюда файл',
            'remove': 'Удалить',
            'error': 'Ошибка. Что-то пошло не так'
        },
        error: {
            'fileExtension': 'Такой формат файла не разрешен. (Разрешены только: {{ value }}).',
        }
    });

    // Delete quest files
    if ($('#js-phrase-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-phrase-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

    $('#js-phrases-edit-form').parsley();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}