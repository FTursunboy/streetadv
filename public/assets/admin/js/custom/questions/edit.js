$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    // First settings
    $('.js-page-title').html('Раздел вопросов к квесту - ' + $('.header-title').data('quest-name'));
    // $('#lat').mask('99.999999');
    // $('#lng').mask('99.999999');

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
    $('#js-questions-edit-form').parsley();

    // Delete question files
    if ($('#js-question-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-question-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

// ------------------------ Components -----------------------------

    // Add description component
    $('#js-question-add-description').on('click', function () {
        var componentsCount = $('.js-component').length;
        $.ajax({
            method: 'POST',
            url: '/admin/ajaxAddQuestionDescription',
            data: {
                componentsCount: componentsCount,
                _token: token,
            }
        })
        .done(function (response) {
            if (response.success == true) {
                $('#js-question-components-block').append(response.html);

            }
        });

        return false;
    });

    // Add file component
    $('#js-question-add-file').on('click', function () {
        var componentsCount = $('.js-component').length;
        $.ajax({
            method: 'POST',
            url: '/admin/ajaxAddQuestionFile',
            data: {
                componentsCount: componentsCount,
                _token: token,
            }
        })
        .done(function (response) {
            if (response.success == true) {
                $('#js-question-components-block').append(response.html);
                $('.dropify').dropify(dropifySettings);
            }
        });

        return false;
    });

    // Add timer component
    $('#js-question-add-timer').on('click', function () {
        var componentsCount = $('.js-component').length;
        $.ajax({
            method: 'POST',
            url: '/admin/ajaxAddQuestionTimer',
            data: {
                componentsCount: componentsCount,
                _token: token,
            }
        })
        .done(function (response) {
            if (response.success == true) {
                $('#js-question-components-block').append(response.html);
            }
        });

        return false;
    });

    // Sortable components
    $('#js-question-components-block').sortable({
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