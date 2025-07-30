$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    lay_tg()

    $('.menu5').css('background-color','#2e3192')
    $('.menu5').find('i').css('color','#f4f6f9')
    $('.menu5').find('div').css('color','#f4f6f9')
    $('.menu5').find('strong').css('color','#f4f6f9')
    // $('#load-bank').empty()
    $('*').keyup(function(e){
        if(e.keyCode=='27'){
            $('#huongdanthanhtoan').hide()
            // location.reload(true);
        }
    })
})

function lay_tg(){
    $.ajax({
        type: "get",
        url: "/thanhtoanlephi/load_tg",
        success: function (res) {
            var endTime = new Date(res);
            endTime.setMinutes(endTime.getMinutes() + 30);
            var countdownInterval = setInterval(updateCountdown, 1000);
            function updateCountdown() {
                var currentTime = new Date();
                var timeDiff = endTime - currentTime;
                var hours = Math.floor(timeDiff / 3600000);
                var minutes = Math.floor((timeDiff % 3600000) / 60000);
                var seconds = Math.floor((timeDiff % 60000) / 1000);
                    $('#thongbaolephi').text("Sử dụng QRCode để thanh toán.")
                    $('#laytgthuc').text("Mã QR hết hạn sau: " +minutes + " phút " + seconds + " giây")
                if (timeDiff <= 0) {
                    clearInterval(countdownInterval);
                    $('#laytgthuc').text("")
                    $('#thongbaolephi').text("")
                    $('#qr_bank').attr('src',"/img/test.png")
                }
            }
        }
    })
}

function layqrcode(id){
    $('#qr_bank').attr('src',"/img/test.png")
    $('#modal_event').show();
    $.ajax({
        type: "post",
        url: "/thanhtoanlephi/layqrcode",
        data:{
            id: id,
        },
        success: function (res) {
            if(res.luuqr == 1){
                $('#layqrcode').attr('disabled', true)
                $('#modal_event').hide()
            }else{
                resutlinfo(res)
                $('#modal_event').hide();
            }
            $('#qr_bank').attr('src',res.dataResponse.data.bank_account.Qr)
            lay_tg()
        }
    })

}

$('#moxemhuongdan').on('click',function(){
    $('#huongdanthanhtoan').show();
})

function huongdanthanhtoan_img_close(){
    $('#huongdanthanhtoan').hide();
}
