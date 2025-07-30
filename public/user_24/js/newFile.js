$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var x = screen.width;
    if (x <= 768) {
        $('.menu1').find('div').hide('slow');
        $('.menu1').find('div').show('slow');
    }


    $('.menu1').find('i').css('color', '#f4f6f9');
    $('.menu1').find('div').css('color', '#f4f6f9');
    $('.menu1').find('strong').css('color', '#f4f6f9');
    $('#noisinh').select2();

    const swiper = new Swiper('.swiper', {
        // zoom: true,
        zoom: {
            maxRatio: 3,
            minRatio: 1
        },

        // rotate: 'true',
        // on: {
        // slideChangeTransitionEnd: function () {
        //     console.log('clicked!')
        //     this.zoom.in();
        //     }
        // },
        // Optional parameters
        slidesPerView: 1,
        // direction: 'vertical',
        // loop: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // And if we need scrollbar
        // scrollbar: {
        //   el: '.swiper-scrollbar',
        // },
        // slidesPerView: 1,
    });

    $('#upload_img').show('slow');
    $('*').keyup(function (e) {
        if (e.keyCode == '27') {
            $('#upload_img').hide('slow');
        }
    });
});
