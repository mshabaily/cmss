jQuery(document).ready(function ($) {
    $('.burger').click(function() {

        $(this).toggleClass('open')
        $('.sidebar').toggleClass('open');

        $('.sidebar').fadeToggle();
    })
});