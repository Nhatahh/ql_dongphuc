$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var duongdan = location.href.split('https://xettuyentest.ctuet.edu.vn/admin24/')
    if(duongdan[1] == 'main'){
        $('#li_'+duongdan[1]).addClass('active')
    }else{
        var menu = $('#'+duongdan[1]).attr('menu')
        $('#li_'+menu).addClass('active')
        $('#'+menu).addClass('active')
        $('#'+duongdan[1]).css('background-color','#fbf7f7')
    }
});


