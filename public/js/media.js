jQuery(document).ready(function ($) {
    $('.upload-media').click(function () {
        $('.hidden-input').click();
    });

    function load_media() {
        $('.media .media-container').load('/cmss/load-media');
    }

    $('.hidden-input').on('change', function () {
        const fd = new FormData();
        fd.append('file', this.files[0]);

        $.ajax({
            url: '/cmss/save-media',
            method: 'POST',
            dataType: 'json',
            data: fd,
            processData: false,
            contentType: false
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function () {
            load_media();
        });
    });

    $('.media-container').on('click', 'img', function () {
        const $img = $(this);

        $('.media-items img').removeClass('active');

        $img.addClass('active');

        $.ajax({
            url: '/cmss/media-menu',
            method: 'GET',
            dataType: 'html',
            data: {
                show_all: false,
                media_id: $img.data('id')
            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function (response) {
            $('.media-items').append(response)
            $('.body-dim').fadeIn();
            $('.media-menu').fadeIn();
        });
    })

    $('.body-dim').click(function () {
        $('.body-dim').fadeOut();
        $('.media-menu').fadeOut(function () {
            $('.media-menu').remove();
        });
    })

    $('.media-container').on('click', '.media-menu .close', function () {
        $('.body-dim').fadeOut();
        $('.media-menu').fadeOut(function () {
            $('.media-menu').remove();
        });
    })

    $('.media-container').on('click', '.delete-media', function () {
        const $btn = $(this);
        const url = $btn.attr('href');

        $.ajax({
            url: url,
            method: 'POST',
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function () {
            $('.media-menu').fadeOut(function () {
                $('.media-menu').remove();
            });

            $('.body-dim').fadeOut();

            load_media();
        });
    });

});