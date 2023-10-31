$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    $('.js-page-title').html('Раздел страниц');
    var drEvent = $('.dropify').dropify({
        messages: {
            'default': 'Выбырите или перенесите сюда файл',
            'replace': 'Выбырите или перенесите сюда файл',
            'remove': 'Удалить',
            'error': 'Ошибка. Что-то пошло не так'
        }
    });

    // translit
    $('form').liTranslit({
        elName: '#name',    //Класс елемента с именем
        elAlias: '#alias'   //Класс елемента с алиасом
    });

    // Delete categories files
    if ($('#js-page-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-page-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

    $('#js-pages-edit-form').parsley();
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}