$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.menu2').css('background-color','#2e3192')
    $('.menu2').find('i').css('color','#f4f6f9')
    $('.menu2').find('div').css('color','#f4f6f9')
    $('.menu2').find('strong').css('color','#f4f6f9')
})





