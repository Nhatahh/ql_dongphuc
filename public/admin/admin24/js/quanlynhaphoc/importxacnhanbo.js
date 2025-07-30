$(document).ready(function () {


    // load_danhsachtaikhoan().ajax.url("/admin24/import_loaddanhsachtaikhoan").load();
})

    function open_importxacnhanbo(){
        $('#importxacnhanbo').click();
    }
    function import_importxacnhanbo(){
        $('#submit_importxacnhanbo').submit();
    }
    $('#submit_importxacnhanbo').on('submit', function(e){
        e.preventDefault();
        if($('#importxacnhanbo').val() == ""){
            thongbao('imp_2')
        }else{
            var kiemtradinhdang = kiemtrafileupload('importxacnhanbo',1)
            if(kiemtradinhdang != 1){
                thongbao(kiemtradinhdang)
            }else{
                $.ajax({
                    url: "/admin24/submit_importxacnhanbo",
                    type:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data){
                        thongbao(data)
                        $('#importxacnhanbo').val('');
                        // load_danhsachtaikhoan().ajax.url("/admin24/import_loaddanhsachtaikhoan").load();
                    }
                });
            }
        }
    });

