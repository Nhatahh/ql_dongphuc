$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
if($(document).width() > 992){
    $('#right_instruct').css('min-height','630px')
    $('#left_instruct').css('min-height','630px')
}else{
    $('#right_instruct').css('min-height','0x')
    $('#left_instruct').css('min-height','0px')
}

$(window).resize(function(){
    if($(document).width()>992){
        $('#right_instruct').css('min-height','630px')
        $('#left_instruct').css('min-height','630px')
    }else{
        $('#right_instruct').css('min-height','0x')
        $('#left_instruct').css('min-height','0px')

    }
});



load_active();


});

function load_active(){
    $.ajax({
        type: "get",
        url: "instruct/load_active",
        success: function (response) {
        // alert(response.price)
            $("#price_instruct").text(response.ex.price + " đồng")
            $("#price2_instruct").text(response.ex.price2 + " đồng")
            $("#wish_instruct").text("0"+response.ex.count )
            $("#reg_instruct").text(response.reg)
            $("#check_instruct").text(response.check)
            // var go = '<button type="button" onclick="edit_wish_sc()" style="margin: bottom: 2px;width:50%" class="btn btn-block btn-primary btn-xs"><i class="fa fa-undo"></i>&nbsp;&nbsp;&nbsp; Click xem kết quả</button>'
            // $("#go_instruct").html(go)
            // $('#loadpageuser').load(res[0].link)
        }
    });
}

function go_seen(){
    $('#loadpageuser').load('go_result')
}
