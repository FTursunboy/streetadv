$(document).ready(function() {
    $('.js-page-title').html('Раздел квестов');

    // Sortable item
    $('#js-list-table').sortable({
        handle: '.js-sortable-pivot',
        update: function (event, ui) {
            var arrEntitiesIDs = [];
            $('.js-items').each(function () {
                arrEntitiesIDs.push($(this).data('id'));
            });
            $.ajax({
                method: 'POST',
                url: '/admin/ajaxSortQuests',
                data: {
                    arrEntitiesIDs: arrEntitiesIDs,
                    _token: token,
                }
            });
        }
    });

    // Delete item
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
                url: '/admin/quests/delete',
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