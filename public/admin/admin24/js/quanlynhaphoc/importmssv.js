$(document).ready(function () {


    // load_danhsachtaikhoan().ajax.url("/admin24/import_loaddanhsachtaikhoan").load();
})

    //Tài khoản thí sinh
    function open_importmssv(){
        $('#importmssv').click();
    }
    function import_importmssv(){
        $('#submit_importmssv').submit();
    }

    $('#submit_importmssv').on('submit', function(e){
        e.preventDefault();
        if($('#importmssv').val() == ""){
            thongbao('imp_2')
        }else{
            var kiemtradinhdang = kiemtrafileupload('importmssv',1)
            if(kiemtradinhdang != 1){
                thongbao(kiemtradinhdang)
            }else{
                $.ajax({
                    url: "/admin24/submit_importmssv",
                    type:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data){
                        thongbao(data)
                        $('#importmssv').val('');
                        // load_danhsachtaikhoan().ajax.url("/admin24/import_loaddanhsachtaikhoan").load();
                    }
                });
            }
        }
    });



