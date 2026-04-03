jQuery(document).ready(function ($) {
    $('.settings').on('click', '.save-settings', function () {

        const favicon = $('.image-field').data('selected-media');

        const site_title = $('.site-title input').val();
        const front_page = $('.front-page select').val();

        $.ajax({
            url: '/cmss/save-settings',
            method: 'POST',
            dataType: 'json',
            data: {
                site_title: site_title,
                favicon: favicon,
                front_page: front_page
            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).success(function () {
            window.location.reload();
        });
    });

    $(function () {
        hugerte.init({
            selector: '.site-description textarea',

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
})