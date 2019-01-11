$(document).ready(function () {
    $('[data-group-request=1]').on('click', function (e) {
        e.preventDefault();

        var ids = [];

        $('.kv-row-checkbox:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length < 1) {
            krajeeDialog.alert('Необходимо выбрать хотя бы один элемент')
        } else {
            krajeeDialog.confirm("В результате выполнения будет затронуто элементов - " + ids.length, function (result) {
                if (result) {
                    $.ajax({
                        data: {ids: ids},
                        type: 'post',
                        url: e.target.href,
                        success: function (out) {
                            if (out['status']) {

                                $.pjax.reload({container : '#tasks-pjax'});

                                if (out['message']) {
                                    krajeeDialog.alert(out['message']);
                                }
                            }
                        }
                    });
                }
            })
        }
    })
});