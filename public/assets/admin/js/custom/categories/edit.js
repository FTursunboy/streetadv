$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел категорий');
    var drEvent = $('.dropify').dropify({
        messages: {
            'default': 'Выбырите или перенесите сюда файл',
            'replace': 'Выбырите или перенесите сюда файл',
            'remove': 'Удалить',
            'error': 'Ошибка. Что-то пошло не так'
        }
    });

    // Delete categories files
    if ($('#js-category-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-category-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

    $('#js-categories-edit-form').parsley();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}