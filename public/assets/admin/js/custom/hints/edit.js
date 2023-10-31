$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    // First settings
    $('.js-page-title').html('Раздел подсказок к вопросу № ' + $('.header-title').data('question-id') + '. Квест - ' + $('.header-title').data('quest-name'));

    // File uploads plugin
    var dropifySettings = {
        messages: {
            'default': 'Выбырите или перенесите сюда файл',
            'replace': 'Выбырите или перенесите сюда файл',
            'remove': 'Удалить',
            'error': 'Ошибка. Что-то пошло не так'
        },
        error: {
            'fileExtension': 'Такой формат файла не разрешен. (Разрешены только: {{ value }}).',
        }
    }
    var drEvent = $('.dropify').dropify(dropifySettings);

    // form validation
    $('#js-hints-edit-form').parsley();

    // Delete hint files
    if ($('#js-hint-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-hint-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

// ------------------------ Components -----------------------------

    // Add description component
    $('#js-hint-add-description').on('click', function () {
        var componentsCount = $('.js-component').length;
        $.ajax({
            method: 'POST',
            url: '/admin/ajaxAddHintDescription',
            data: {
                componentsCount: componentsCount,
                _token: token,
            }
        })
        .done(function (response) {
            if (response.success == true) {
                $('#js-hint-components-block').append(response.html);

            }
        });

        return false;
    });

    // Add file component
    $('#js-hint-add-file').on('click', function () {
        var componentsCount = $('.js-component').length;
        $.ajax({
            method: 'POST',
            url: '/admin/ajaxAddHintFile',
            data: {
                componentsCount: componentsCount,
                _token: token,
            }
        })
        .done(function (response) {
            if (response.success == true) {
                $('#js-hint-components-block').append(response.html);
                $('.dropify').dropify(dropifySettings);
            }
        });

        return false;
    });

    // Sortable components
    $('#js-hint-components-block').sortable({
        handle: '.js-components-pivot-point',
        update: function (event, ui) {
            setRightSortComponents();
        }
    });

    // Delete component
    $(document).on('click', '.js-component-delete', function () {
        $(this).parent().parent().remove();

        setRightSortComponents();
    });
});

function hideAlertBlock() {
    $('#js-alert-block').hide(500);
}

function setRightSortComponents() {
    var i = 1;
    $('.js-component').each(function () {
        var componentName = $(this).data('component');
        $(this).attr('name', 'components[' + componentName + '][' + i + ']');

        if (editEntity && editEntity == true) {
            if (componentName == 'file') {
                $(this).parent().next().attr('name', 'components[temp][' + i + ']'  );
            }
        }

        i ++;
    });
}