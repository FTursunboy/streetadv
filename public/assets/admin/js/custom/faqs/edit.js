$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел помощи');
    var drEvent = $('.dropify').dropify({
        messages: {
            'default': 'Выбырите или перенесите сюда файл',
            'replace': 'Выбырите или перенесите сюда файл',
            'remove': 'Удалить',
            'error': 'Ошибка. Что-то пошло не так'
        }
    });

    // Delete faqs files
    if ($('#js-faq-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-faq-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

    $('#js-faqs-edit-form').parsley();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}