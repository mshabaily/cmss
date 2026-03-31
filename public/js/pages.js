jQuery(document).ready(function ($) {
    $('.template-select').change(function () {
        $.ajax({
            url: '/cmss/change-template',
            type: 'POST',
            data: {
                template_id: $(this).val()
            },
            success: function (html) {
                $('.fields .items').html(html).fadeIn(500);
                hugerte.init({
                    selector: '.textbox-field textarea',

                    plugins: `
            accordion advlist anchor autolink autoresize autosave
            charmap code codesample directionality fullscreen image
            insertdatetime link lists media nonbreaking pagebreak
            preview quickbars save searchreplace table template
            visualblocks visualchars wordcount emoticons
        `,

                    toolbar: `
            undo redo | blocks |
            bold italic underline strikethrough |
            alignleft aligncenter alignright alignjustify |
            bullist numlist outdent indent |
            link image media table |
            codesample code |
            charmap emoticons |
            searchreplace visualblocks visualchars |
            preview fullscreen
        `,

                    menubar: 'file edit view insert format tools table',

                    skin: 'oxide',
                    content_css: 'default',

                    autoresize_bottom_margin: 20,
                    autosave_interval: '30s',

                    quickbars_selection_toolbar: 'bold italic underline | quicklink h2 h3 blockquote',
                    quickbars_insert_toolbar: 'quickimage quicktable',

                    height: 300
                });
            },
            error: function (xhr) {
                console.log('Status:', xhr.status);
                console.log('Response:', xhr.responseText);
            }
        });
    })

    function gather_field_inputs() {
        const fields = [];

        $('.fields > .items > .field').each(function () {
            fields.push(parse_field($(this)));
        });

        return fields;
    }

    function parse_field(field) {
        const fieldname = field.data('fieldname');
        const fieldtype = field.data('fieldtype');
        const fieldkey = field.data('fieldkey');

        let value = null;

        if (fieldtype == 'text.php') {
            value = field.find('input').first().val();

        } else if (fieldtype == 'textbox.php') {
            const textarea = field.find('textarea').first();
            const editorId = textarea.attr('id');
            const editor = editorId ? hugerte.get(editorId) : null;
            value = editor ? editor.getContent() : (textarea.val() || null);

        } else if (fieldtype == 'image.php') {
            value = field.find('.image-field').data('selected-media') || null;

        } else if (fieldtype == 'loop.php') {
            value = [];

            field.find('.loop-item').each(function () {
                const loopItem = $(this);
                const subfields = [];

                loopItem.children('.field').each(function () {
                    subfields.push(parse_field($(this)));
                });

                value.push(subfields);
            });
        }

        return {
            fieldname: fieldname,
            fieldtype: fieldtype,
            fieldkey: fieldkey,
            value: value
        };
    }

    $('.page').on('click', '.save-page', function () {
        const fields = gather_field_inputs();
        const title = $('.title-input').val();
        const url = $('.url input').val();

        const params = new URLSearchParams(window.location.search);
        const id = params.get('id') ? params.get('id') : -1;

        const template_id = $('.template-select').val();

        $.ajax({
            url: '/cmss/save-page',
            method: 'POST',
            dataType: 'json',
            data: {
                template_id: template_id,
                fields: fields,
                title: title,
                url: url,
                id: id
            }
        }).fail(function (jqXHR) {
            console.log(fields);
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).success(function (response) {
            window.location.href = response.data.redirect;
        });
    });

    $('.pages .content').on('click', '.delete-page', function () {
        const $btn = $(this);
        const url = $btn.attr('href');

        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json'
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function () {
            const $record = $btn.closest('.record');

            $record.fadeOut(function () {
                $('.pagination').remove();
                $record.remove();

                if (!$('.pages .content .record').length) {
                    $('.pages .content').append('<p class="no-content">No pages found, create a new page to get started!</p>');
                }
            });
        });
    });

    $('main').on('click', '.select-media', function () {
        const fieldkey = $(this).closest('.field').data('fieldkey');
        $.ajax({
            url: '/cmss/media-select',
            method: 'GET',
            dataType: 'html',
            data: {
                fieldkey: fieldkey
            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function (response) {
            $('main').append(response)
            $('.body-dim').fadeIn();
            $('.media-select').fadeIn();
        });
    })

    $('main').on('click', '.media-select .close', function () {
        $('.body-dim').fadeOut();
        $('.media-select').fadeOut(function () {
            $('.media-select').remove();
        });
    })

    $('main').on('click', '.media-select .item', function () {
        const $img = $(this);

        $.ajax({
            url: '/cmss/media-select-option',
            method: 'GET',
            dataType: 'html',
            data: {
                media_id: $img.data('id')
            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function (response) {
            $('.media-select .primary').hide();
            $('.media-select').append(response)
            $('.media-select .option').fadeIn();
        });
    })

    $('main').on('click', '.media-select .option .select', function () {
        const id = $(this).closest('.option').data('media-id');
        const fieldkey = $(this).closest('.media-select').data('fieldkey');
        const field = $(`.field[data-fieldkey="${fieldkey}"]`);

        const image_field = field.find('.image-field');
        image_field.attr('data-selected-media', id);

        $.ajax({
            url: '/cmss/populate-media-field',
            method: 'GET',
            dataType: 'html',
            data: {
                media_id: id
            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function (response) {
            $('.image-item').remove();
            image_field.prepend(response);
        });

        $('.body-dim').fadeOut();
        $('.media-select').fadeOut(function () {
            $('.media-select').remove();
        });
    })

    $('main').on('click', '.media-select .option .back', function () {
        $('.media-select .option').remove();
        $('.media-select .primary').fadeIn();
    })

    $('.body-dim').click(function () {
        $('.body-dim').fadeOut();
        $('.media-select').fadeOut(function () {
            $('.media-select').remove();
        });
    })

    $('.page').on('click', '.loop-field .add-sub-field', function () {
        const button = $(this);
        $.ajax({
            url: '/cmss/add-sub-field',
            method: 'GET',
            dataType: 'html',
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function (response) {
            console.log(response);
            button.prev('.loop-sub-fields').append(response);
        });
    })

    $('.page').on('click', '.add-item', function () {
        const loopField = $(this).closest('.loop-field');
        const loopItems = loopField.find('.loop-items');
        const firstItem = loopItems.find('.loop-item').first();
        const currentCount = parseInt(loopField.data('item-count'), 10) || 0;
        const newIndex = currentCount;

        const newItem = firstItem.clone();

        newItem.attr('data-index', newIndex);

        newItem.find('input, textarea, select').each(function () {
            const field = $(this);

            field.val('');
            field.prop('checked', false);
            field.prop('selected', false);

            const name = field.attr('name');
            if (name) {
                field.attr('name', replaceIndex(name, newIndex));
            }

            const id = field.attr('id');
            if (id) {
                field.attr('id', replaceIndex(id, newIndex));
            }
        });

        newItem.find('label').each(function () {
            const label = $(this);
            const forAttr = label.attr('for');
            if (forAttr) {
                label.attr('for', replaceIndex(forAttr, newIndex));
            }
        });

        loopItems.append(newItem);
        loopField.data('item-count', currentCount + 1);
    });

    function replaceIndex(str, newIndex) {
        return str.replace(/\[\d+\]/, '[' + newIndex + ']');
    }

    $(function () {
        hugerte.init({
            selector: '.textbox-field textarea',

            plugins: `
            accordion advlist anchor autolink autoresize autosave
            charmap code codesample directionality fullscreen image
            insertdatetime link lists media nonbreaking pagebreak
            preview quickbars save searchreplace table template
            visualblocks visualchars wordcount emoticons
        `,

            toolbar: `
            undo redo | blocks |
            bold italic underline strikethrough |
            alignleft aligncenter alignright alignjustify |
            bullist numlist outdent indent |
            link image media table |
            codesample code |
            charmap emoticons |
            searchreplace visualblocks visualchars |
            preview fullscreen
        `,

            menubar: 'file edit view insert format tools table',

            skin: 'oxide',
            content_css: 'default',

            autoresize_bottom_margin: 20,
            autosave_interval: '30s',

            quickbars_selection_toolbar: 'bold italic underline | quicklink h2 h3 blockquote',
            quickbars_insert_toolbar: 'quickimage quicktable',

            height: 300
        });
    });
});