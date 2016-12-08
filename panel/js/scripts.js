

$(document).ready(function () {
    // toggle button
    $('div.navbar-button').click(function () {
       $('div.mobile-menu').slideToggle();
    })

    // fixed header
    $(window).scroll(function () {

        var scroll = $(window).scrollTop();

        if(scroll > $(window).height() - 60 && !$('body > nav').hasClass('fixed')){
            $('body > nav').addClass('fixed');
            $('div.mobile-menu').addClass('fixed');
            console.log('fixed added');
        }else if(scroll <= $(window).height() - 60 && $('body > nav').hasClass('fixed')){
            $('body > nav').removeClass('fixed');
            $('div.mobile-menu').removeClass('fixed');
            console.log('fixed removed');
        }

    })



});


