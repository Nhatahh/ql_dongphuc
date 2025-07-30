$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.menu6').css('background-color','#2e3192')
    $('.menu6').find('i').css('color','#f4f6f9')
    $('.menu6').find('div').css('color','#f4f6f9')
    $('.menu6').find('strong').css('color','#f4f6f9')
    // slider
    $('.images-slider').slick({
        // các thuộc tính của thư viện slick slider
        infinite: true, // true: lặp lại, false: không lặp lại
        slidesToShow: 3, // số lượng ảnh hiển thị
        slidesToScroll: 1, // số lượng ảnh cuộn
        arrows: false, // true: hiển thị 2 nút next, prev, false: ẩn 2 nút next, prev
        draggable: true, // true: kéo được, false: không kéo được
        autoplay: true, // true: tự động chạy, false: không tự động chạy
        autoplaySpeed: 1500, // thời gian chạy
        prevArrow: // nút prev
            `<button type='button' class='slick-prev pull-left slick-arrow'><ion-icon name="arrow-back-outline"></ion-icon></button>`,
        nextArrow: // nút next
            `<button type='button' class='slick-next pull-right slick-arrow'><ion-icon name="arrow-forward-outline"></ion-icon></button>`,
        dots: true, // true: hiển thị dấu chấm, false: ẩn dấu chấm
        responsive: [
            // các breakpoint
            {
                // tối đa 1300.98px thì hiển thị 3 ảnh
                breakpoint: 1900.98,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                // tối đa 878.98px thì hiển thị 2 ảnh
                breakpoint: 878.98,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                // tối đa 676.98px thì hiển thị 1 ảnh
                breakpoint: 676.98,
                settings: {
                    infinite: false,
                    dots: true,
                    arrows: false,
                    slidesToShow: 1
                }
            },
        ],
    });
})
//Auto move
document.addEventListener("DOMContentLoaded", function() {
    var myCarousel = document.querySelector('#carouselExampleIndicators');
    var carousel = new bootstrap.Carousel(myCarousel, {
      interval: 1500, // Thời gian mỗi slide hiển thị trước khi chuyển sang slide tiếp theo (milliseconds)
      wrap: true // Cho phép carousel lặp lại khi đi đến slide cuối cùng
    });
  });
