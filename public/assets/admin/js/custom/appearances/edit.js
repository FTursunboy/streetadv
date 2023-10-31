$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    var drEvent = $('.dropify').dropify({
        messages: {
            'default': 'Выбырите или перенесите сюда файл',
            'replace': 'Выбырите или перенесите сюда файл',
            'remove': 'Удалить',
            'error': 'Ошибка. Что-то пошло не так'
        }
    });

    // Delete appearances files
    if ($('#js-appearance-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-appearance-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}