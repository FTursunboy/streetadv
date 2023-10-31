$(document).ready(function () {
    setTimeout(hideAlertBlock, 5000);

    // First settings
    $('.js-page-title').html('Ответ на вопрос № ' + $('.header-title').data('sort-number') + '. Квест - ' + $('.header-title').data('quest-name'));

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

    // Form validation
    $('#js-answers-edit-form').parsley();

    // Delete answers files
    if ($('#js-answer-id').length > 0) {
        drEvent.on('dropify.beforeClear', function (event, element) {
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxDeleteImages',
                data: {
                    type: $('#js-answer-id').data('type'),
                    name: element.file.name,
                    _token: token
                }
            })
        });
    }

    // Submit form
    $('#js-answer-form-submit').on('click', function () {

        // Remove an empty components
        removeEmptyComponents()

        // Check the exist right answer
        if (checkRightAnswer() == false) {
            return false;
        }

        // Check the exist multi right answer
        if (checkRightMultiAnswer() == false) {
            return false;
        }

        $('#js-answers-edit-form').submit();
        return false;
    });

// ------------------------ Components -----------------------------

    // Change component
    $('#js-answer-type').change(function () {
        var component = $(this).val();
        $.ajax({
            method: 'POST',
            url: '/admin/ajaxChangeAnswerComponent',
            data: {
                component: component,
                _token: token,
            }
        })
        .done(function (response) {
            if (response.success == true) {
                if (response.html != '') {
                    if (response.html == 'text') {
                        var button = '<button class="js-add-answer-component btn btn-info waves-effect waves-light m-b-5" data-type="' + response.type + '"> <span>Добавить текст</span> <i class="fa fa-info-circle fa-lg m-l-5"></i> </button>';
                        $('#js-answer-components-block').empty();
                        $('#js-answer-button-box').empty().html(button);
                    }
                    if (response.html == 'file') {
                        var button = '<button class="js-add-answer-component btn btn-purple waves-effect waves-light m-b-5" data-type="' + response.type + '"> <span>Добавить файл</span> <i class="fa fa-file-o m-l-5"></i> </button>';
                        $('#js-answer-components-block').empty();
                        $('#js-answer-button-box').empty().html(button);
                    }
                } else {
                    $('#js-answer-components-block').empty().html('Без компонента');
                    $('#js-answer-button-box').empty();
                }
            }
        });

        return false;
    });

    // Add component
    $(document).on('click', '.js-add-answer-component', function () {
        var component = $(this).data('type');
        $.ajax({
            method: 'POST',
            url: '/admin/ajaxAddAnswerComponent',
            data: {
                component: component,
                _token: token,
            }
        })
        .done(function (response) {
            if (response.success == true) {
                $('#js-answer-components-block').append(response.html);
                setRightSortComponents();
                $('.dropify').dropify(dropifySettings);
            }
        });

        return false;
    });

    // Change right answer
    $(document).on('click', '.js-answer-right-button', function () {
        $('.js-answer-form-box').removeClass('has-success');
        $(this).parent().parent().parent().parent().addClass('has-success');

        $('.js-answer-right-icon').hide();
        $(this).parent().next().show();

        $('.js-component-right').val(0);
        $(this).parent().parent().next().val(1);
    });

    // Change right multi answer
    $(document).on('click', '.js-answer-multi-right-button', function () {
        if ($(this).parent().parent().parent().parent().hasClass('has-success')) {
            $(this).parent().parent().parent().parent().removeClass('has-success');
            $(this).parent().next().addClass('hidden');
            $(this).parent().parent().next().val(0);
        } else {
            $(this).parent().parent().parent().parent().addClass('has-success');
            $(this).parent().next().removeClass('hidden');
            $(this).parent().parent().next().val(1);
        }
    });

    // Change right answer image
    $(document).on('click', '.js-answer-right-button-image', function () {
        $('.js-answer-form-box').removeClass('has-success');
        $(this).parent().parent().parent().addClass('has-success');

        $('.js-answer-right-icon').hide();
        $(this).next().show();

        $('.js-component-right').val(0);
        $(this).parent().next().val(1);
    });

    // Crop area functional
    if ($('#js-crop-image').length) {
        var image = document.getElementById('js-crop-image');
        var cropper = new Cropper(image, {
            minContainerWidth: 900,
            minContainerHeight: 668,
            movable: false,
            rotatable: false,
            scalable: false,
            zoomable: false,
            zoomOnTouch: false,
            zoomOnWheel: false
        });
    }



    $(document).on('click', '.js-crop-modal', function () {
        var coordFromField = $('#js-coords').text();
        if (coordFromField != '') {
            var coords = JSON.parse(coordFromField);
            cropper.setData(coords);
        }

        return false;
    });

    $('#js-save-crop').on('click', function () {
        $('#js-coords').text(JSON.stringify(cropper.getData()));
    });

    // Sortable components
    $('#js-answer-components-block').sortable({
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
        if ($(this).parent().parent().next().next().hasClass('js-component-temp')) {
            $(this).parent().parent().next().next().attr('name', 'components[temp][' + i + ']');
        }

        i ++;
    });

    if ($('.js-component-right').length) {
        var a = 1;
        $('.js-component-right').each(function () {
            $(this).attr('name', 'components[right][' + a + ']');

            a ++;
        });
    }

    if ($('.js-component-multi-right').length) {
        var b = 1;
        $('.js-component-multi-right').each(function () {
            $(this).attr('name', 'components[right][' + b + ']');

            b ++;
        });
    }
}

function removeEmptyComponents() {
    if ($('.js-component').length > 0) {
        $('.js-component').each(function () {
            if ($(this).val() == '') {
                if (!$(this).data('default-file')) {
                    $(this).parents('.js-component-parent-box').remove();
                    setRightSortComponents();
                }
            }
        });
    }
}

function checkRightAnswer() {
    if ($('.js-component-right').length > 0) {
        var i = 0;
        $('.js-component-right').each(function () {
            if ($(this).val() == 1) {
                i ++;
            }
        });
        if (i == 0) {
            swal("Не выбран правильный ответ!", "Выберите один правильный ответ");

            return false;
        }
    }

    return true;
}

function checkRightMultiAnswer() {
    if ($('.js-component-multi-right').length > 0) {

        var i = 0;
        $('.js-component-multi-right').each(function () {
            if ($(this).val() == 1) {
                i ++;
            }
        });
        if (i == 0) {
            swal("Не выбран правильный ответ!", "Выберите один или несколько (если это необходимо) правильных ответов");

            return false;
        }
    }

    return true;
}