jQuery(document).ready(function ($) {
    document.querySelectorAll('.has-move').forEach(function (el) {
        new Sortable(el, {
            group: 'nested',
            animation: 150,
            handle: '.move',
            fallbackOnBody: true,
            swapThreshold: 0.65
        });
    });

    $('.add-field').on('click', function () {
        $.get('/cmss/add-field', function (html) {
            var newField = $(html).hide();
            $('.fields').append(newField);
            newField.fadeIn(500);
        });
    });


    $(document).on('click', '.add-sub-field', function () {

        var container = $(this).prev('.sub-fields');

        $.get('/cmss/add-field', function (html) {
            var newField = $(html).hide();
            container.append(newField);
            newField.fadeIn(500);
        });
    });

    $('.template').on('click', '.field .delete', function () {
        $(this).closest('.field').fadeOut(500, function () {
            $(this).remove();
        });
    });

    function gather_field(field, sortOrder) {
        var data = {
            fieldname: field.find('> .inputs > .fieldname [name="fieldname"]').val(),
            fieldtype: field.find('> .inputs > .fieldtype [name="fieldtype"]').val(),
            fieldkey: field.find('> .inputs > .fieldkey [name="fieldkey"]').val(),
            sort_order: sortOrder
        };

        var childFields = [];

        field.find('> .inputs > .loop > .sub-fields > .field').each(function (i) {
            childFields.push(gather_field($(this), i));
        });

        if (childFields.length) {
            data.subfields = childFields;
        }

        return data;
    }

    function gather_fields() {
        var fields = [];

        $('.records > .fields > .field').each(function (i) {
            fields.push(gather_field($(this), i));
        });

        return fields;
    }
    $('.template').on('click', '.save-template', function () {
        fields = gather_fields();
        title = $('.title-input').val();

        const params = new URLSearchParams(window.location.search);
        const id = params.get('id') ? params.get('id') : -1;

        $.ajax({
            url: '/cmss/save-template',
            method: 'POST',
            dataType: 'json',
            data: {
                fields: fields,
                title: title,
                id: id
            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function (response) {
            window.location.href = response.data.redirect;
        });
    });

    $('.template').on('change', '[name="fieldtype"]', function () {

        const select = $(this);

        if (select.val() === 'loop.php') {

            $.ajax({
                url: '/cmss/load-loop',
                method: 'GET',
            })
                .fail(function (jqXHR) {
                    console.error('Request failed');
                    console.error('Response Text:', jqXHR.responseText);
                })
                .done(function (response) {
                    select.closest('.inputs').append(response);
                    select.closest('.inputs').find('.loop').fadeIn();
                });

        } else {
            if (select.closest('.field').find('.loop')) {
                select.closest('.field').find('.loop').remove();
            }
        }

    });

    $('.template').on('click', '.delete', function () {
        const $btn = $(this);
        const url = $btn.attr('href');

        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function () {
            $btn.closest('.template').fadeOut();
        });
    });
});