$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });





})


$('#them').on('click',function(){
    var ten = $('#tutu').val()
    // var ten1 = $('#tutu1').val()
    $.ajax({
        type: "post",
        url: "/test/thanhtoan",
        success: function (res) {
            // alert(res)
            // // window.open(res.data.payment_url,"Thanhtoanlephi",1,true)
            // alert(res.data.bank_account.Qr)
            // $("#hinhanh").attr('src',res.data.bank_account.Qr)

        }
    })
})
