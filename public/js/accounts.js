jQuery(document).ready(function ($) {
    $('.login .form .submit').click(function () {
        $.ajax({
            url: '/cmss/attempt-login',
            method: 'POST',
            dataType: 'json',
            data: {
                email: $("input[name='email']").val(),
                password: $("input[name='password']").val()
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
            method: 'GET'
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
        })
    })

    $('.change-password').click(function () {
        email = $("input[name='email']").val();
        password = $("input[name='password']").val();
        user_id = $('.user-form').data('user-id');

        $.ajax({
            url: '/cmss/change-password',
            method: 'POST',
            dataType: 'json',
            data: {
                email: email,
                password: password,
                user_id: user_id
            }
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

        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json'
        }).fail(function (jqXHR) {
            console.error('Request failed');
            console.error('Response Text:', jqXHR.responseText);
        }).done(function () {
            $btn.closest('.record').fadeOut();
        });
    });
});