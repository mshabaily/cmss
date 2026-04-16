jQuery(document).ready(function ($) {
    $('.login .form .submit').click(function () {
        const csrf = $('.login').data('csrf');

        $.ajax({
            url: '/cmss/attempt-login',
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': csrf
            },
            data: {
                email: $("input[name='email']").val(),
                password: $("input[name='password']").val(),

            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
            $('.form:not(:has(.error))').prepend("<p class='error'>Invalid details, try again</p>");
        }).done(function () {
            location.reload();
        });
    })

    $('.sign-out').click(function () {
        $.ajax({
            url: '/cmss/sign-out',
            method: 'GET',
        }).done(function () {
            window.location.href = '/cmss'
        });
    })

    $('.reset-password').click(function () {
        address = $("input[name='email']").val();
        $.ajax({
            url: '/cmss/send-password-reset',
            method: 'POST',
            dataType: 'json',
            data: {
                address: address
            }
        }).done(function () {
            $('.form:not(:has(.message))').prepend("<p class='message'>Reset link requested: check your inbox to continue</p>")
        });
    })

    $('.change-password').click(function () {
        email = $("input[name='email']").val();
        password = $("input[name='password']").val();
        user_id = $('.user-form').data('user-id');

        const csrf = $('.user-form').data('csrf');

        $.ajax({
            url: '/cmss/change-password',
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': csrf
            },
            data: {
                email: email,
                password: password,
                user_id: user_id
            }
        }).done(function() {
            window.location.href = '/cmss'
        })
    })

    $('.account').on('click', '.save-account', function () {
        $email = $(".userdata[name='email']").val();
        $firstname = $(".userdata[name='firstname']").val();
        $surname = $(".userdata[name='surname']").val();
        $role = $(".userdata[name='role']").val();
        $password = $(".userdata[name='password']").val();

        const params = new URLSearchParams(window.location.search);
        const id = params.get('id') ? params.get('id') : -1;

        $.ajax({
            url: '/cmss/save-account',
            method: 'POST',
            dataType: 'json',
            data: {
                email: $email,
                firstname: $firstname,
                surname: $surname,
                password: $password,
                role: $role,
                id: id
            }
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function (response) {
            console.log(response);
            window.location.href = response.data.redirect;
        });
    });

    $('.accounts').on('click', '.delete-account', function () {
        const $btn = $(this);
        const url = $btn.attr('href');

        const csrf = $(this).data('csrf');

        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-Token': csrf
            },
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function () {
            $btn.closest('.record').fadeOut();
        });
    });
});