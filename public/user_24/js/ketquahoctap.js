$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.menu3').css('background-color','#2e3192')
    $('.menu3').find('i').css('color','#f4f6f9')
    $('.menu3').find('div').css('color','#f4f6f9')
    $('.menu3').find('strong').css('color','#f4f6f9')
})

$('.ketquahoctap').on('change',function(e){
    $(this).removeClass('error')
    e.preventDefault();
    $('#modal_event').show();
    var lop = $(this).attr('lop')
    var hocki = $(this).attr('hocki')
    var mon = $(this).attr('mon')
    var id_user = $(this).attr('id_user')
    var diem = $(this).val();
    var  myRe = /^[+-]?((\d+(\.\d*)?)|(\.\d+))$/;
    if(myRe.test(diem) == false){
        toastr.warning("Điểm là só thập phân, ngăn cách bằng dấu ' . '")
        $(this).addClass('error')
        $('#modal_event').hide();
    }else{
        $.ajax({
            url: "/ketquahoctap/luudiemhoctap",
            type:'POST',
            data: {
                hocki: hocki,
                lop: lop,
                mon: mon,
                id_user: id_user,
                diem: diem,
            },
            success:function(res){
                if(res['maloi'] == "vali_1"){
                    $('#ketquahoctap'+id_user+"_"+lop+"_"+hocki+"_"+mon).addClass('error')
                    toastr.warning(res['data']['original']['diem'][0])
                }else{
                    resutlinfo(res)
                    $('#ketquahoctap'+id_user+"_"+lop+"_"+hocki+"_"+mon).removeClass('error')
                }
                $('#modal_event').hide();
            }
        })
    }
})


function tinhdiemthamkhao(){
    location.reload(true);
}









