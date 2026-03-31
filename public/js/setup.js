jQuery(document).ready(function ($) {
    $('.install-database').on('click', function (e) {
        $.ajax({
            url: '/cmss/install-database',
            method: 'POST',
            dataType: 'json',
            data: {
                db_host: $('input[name="db_host"]').val(),
                db_name: $('input[name="db_name"]').val(),
                db_username: $('input[name="db_username"]').val(),
                db_user_password: $('input[name="db_user_password"]').val()
            }
        }).done(function (response) {
            window.location.href = "/cmss/account-setup"
        }).fail(function (jqXHR) {
            console.error(jqXHR.responseText);
            alert('Install failed');
        });
    });
});