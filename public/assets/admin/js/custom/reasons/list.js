$(document).ready(function() {
    $('.js-page-title').html('Раздел причин обращения');

    $('.js-delete-item').click(function () {
        var objectID = $(this).data('id');
        swal({
            title: "Удалить элемент?",
            text: "У вас потом не будет возможности восстановить его.",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Нет, не надо",
            confirmButtonClass: 'btn-danger',
            confirmButtonText: "Да, удалить",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                method: 'POST',
                url: '/admin/reasons/delete',
                data: {
                    objectID: objectID,
                    _token: token,
                }
            })
                .done(function (response) {
                    if (response.success == true) {
                        $('.js-item-tr-' + response.objectID).remove();
                    }
                }),
                swal("Удалено!", "Элемент был удален из базы данных.", "success");
        });

        return false;
    });
} );