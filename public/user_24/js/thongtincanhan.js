$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // var  x = screen.width;
    // if(x <= 768){
    //     $('.menu1').find('div').hide('slow')
    //     $('.menu1').find('div').show('slow')
    // }

    $('.menu1').css('background-color','#2e3192')
    $('.menu1').find('i').css('color','#f4f6f9')
    $('.menu1').find('div').css('color','#f4f6f9')
    $('.menu1').find('strong').css('color','#f4f6f9')

    // background-color:#a3161d
    $('#noisinh').select2();
    $('.thpt').select2();
    $('#truongthpt10').select2();
    $('#truongthpt11').select2();
    $('#truongthpt12').select2();
    $('#tinhthpt10').select2();
    $('#tinhthpt11').select2();
    $('#tinhthpt12').select2();
    $('#doituonguutien').select2();

    // $('#ngaysinh').daterangepicker({ startDate: '01/01/1999' });

    // const swiper1 = new Swiper('.swiper-slider', {

    //     // zoom: true,

    //     zoom: {
    //         maxRatio: 3,
    //         minRatio: 1
    //       },

    //     // rotate: 'true',

    //     // on: {
    //     // slideChangeTransitionEnd: function () {
    //     //     console.log('clicked!')
    //     //     this.zoom.in();
    //     //     }
    //     // },

    //     // Optional parameters
    //     slidesPerView: 1,
    //     // direction: 'vertical',
    //     // loop: true,

    //     // If we need pagination
    //     pagination: {
    //       el: '.swiper-pagination',
    //       clickable: true,
    //     },

    //     // Navigation arrows
    //     navigation: {
    //       nextEl: '.swiper-button-next',
    //       prevEl: '.swiper-button-prev',
    //     },

    //     // And if we need scrollbar
    //     // scrollbar: {
    //     //   el: '.swiper-scrollbar',
    //     // },

    //     // slidesPerView: 1,
    // });

    // const swiper2 = new Swiper('.swiper-modal', {

    //     // zoom: true,

    //     zoom: {
    //         maxRatio: 3,
    //         minRatio: 1
    //       },

    //     // rotate: 'true',

    //     // on: {
    //     // slideChangeTransitionEnd: function () {
    //     //     console.log('clicked!')
    //     //     this.zoom.in();
    //     //     }
    //     // },

    //     // Optional parameters
    //     slidesPerView: 1,
    //     // direction: 'vertical',
    //     // loop: true,

    //     // If we need pagination
    //     pagination: {
    //       el: '.swiper-pagination',
    //       clickable: true,
    //     },

    //     // Navigation arrows
    //     navigation: {
    //       nextEl: '.swiper-button-next',
    //       prevEl: '.swiper-button-prev',
    //     },

    //     // And if we need scrollbar
    //     // scrollbar: {
    //     //   el: '.swiper-scrollbar',
    //     // },

    //     // slidesPerView: 1,
    // });
    //   $('#upload_img').show('slow')


})



function luuthongtincanhan(id){
    $('#modal_event').show('fast');
    $('.validate').hide();
    setTimeout(() => {
        var thongtincanhan = document.getElementsByClassName('thongtincanhan')
        var data = []
        for(let i=0;i<thongtincanhan.length;i++){
            $(thongtincanhan[i]).removeClass('input_er')
            $("#v_"+$(thongtincanhan[i]).attr('id')).removeClass('error');
            $("#v_"+$(thongtincanhan[i]).attr('id')).text('');
            data[i] = [$(thongtincanhan[i]).attr('id'),$(thongtincanhan[i]).val()]
        }
        if($('#gioitinhnam').prop('checked') == true){
            var gioitinh = 0;
        }else{
            var gioitinh = 1;
        }
        data.push(['gioitinh',gioitinh])
        $.ajax({
            type: "post",
            url: "/thongtincanhan/luuthongtincanhan",
            data: {
                id:id,
                data: data
            },
            success: function (res) {
                if(res['maloi'] == "vali_1"){
                    $('#modal_event').hide();
                    toastr.warning("Có lỗi nhập thông tin, vui lòng chú ý hướng dẫn màu đỏ!")
                    var keys = Object.keys(res['data']['original'])
                    for(let i = 0; i<keys.length; i++){
                        if($('#'+keys[i]).attr('type_custom') == "select_custom"){
                            $('#'+keys[i]).find('.select2-selection .select2-selection--single').addClass('input_er')
                        }else{
                            $('#'+keys[i]).addClass('input_er')
                        }
                        $('#v_'+keys[i]).show('slow')
                        $('#v_'+keys[i]).text(res['data']['original'][keys[i]][0])
                        $('#v_'+keys[i]).addClass('error')
                    }
                }else{
                    $('#modal_event').hide();
                    resutlinfo(res)
                }
            }
        });
        $('#modal_event').hide();
    }, 2000)
}

$('.truongthpt').on('change',function(e){
    e.preventDefault();
    $('#modal_event').show();
    $('.validate').hide();
    setTimeout(() => {
        var id_user = $(this).attr('id_user')
        var id_lop = $(this).attr('id_lop')
        var id_tinh = $('#tinhthpt'+$(this).attr('id_lop')).val();
        var id_truong = $(this).val();
        var data = [id_user,id_lop,id_tinh,id_truong]
        $.ajax({
            url: "/thongtincanhan/luutruongthpt",
            type:'POST',
            data: {
               data: data
            },
            success:function(res){
                if(res == "thongtincanhan"){
                    toastr.warning("Vui lòng nhập thông tin cơ bản và lưu, sau đó chọn Trường THPT")
                }else{
                    if(res['maloi'] == "vali_1"){
                        $('#modal_event').hide();
                        toastr.warning("Có lỗi nhập thông tin, vui lòng chú ý hướng dẫn màu đỏ!")
                        var keys = Object.keys(res['data']['original'])
                        for(let i = 0; i<keys.length; i++){
                            if($('#'+keys[i]).attr('type_custom') == "select_custom"){
                                $('#'+keys[i]).find('.select2-selection .select2-selection--single').addClass('input_er')
                            }
                            $('#v_'+keys[i]+id_lop).show('slow')
                            $('#v_'+keys[i]+id_lop).text(res['data']['original'][keys[i]][0])
                            $('#v_'+keys[i]+id_lop).addClass('error')
                        }
                    }else{
                        $('#modal_event').hide();
                        if(res['act'] == "UpOrIns_1"){
                            $("#khuvuc"+id_lop).text(res['khuvuc'])
                            $("#uutientheothpt").html(res['tenkhuvucuutien'])
                            resutlinfo(res['act'] )
                        }else{
                            resutlinfo(res)
                        }
                    }
                }
            }
        })
        $('#modal_event').hide('slow');

    }, 1000)

})

$('.tinh').on('change',function(e){
    e.preventDefault();
    var id_lop = $(this).attr('id_lop')
    var id_user = $(this).attr('id_user')
    var id_tinh = $(this).val();
    $.ajax({
        url: "/thongtincanhan/chuyentinhthpt",
        type:'POST',
        data: {
            id_user: id_user,
            id_tinh: id_tinh,
        },
        success:function(res){
            $('#truongthpt'+id_lop).html('').select2({
                data: res
            });
            $("#khuvuc"+id_lop).text("")
        }
    })
})

$('#namtotnghiep').on('change',function(e){
    e.preventDefault();
    $('.validate').hide();
    $('#modal_event').show();
    setTimeout(() => {
        var namtotnghiep = $(this).val();
        var id_user = $(this).attr('id_user')
        $.ajax({
            url: "/thongtincanhan/namtotnghiep",
            type:'POST',
            data: {
                id_user: id_user,
                namtotnghiep: namtotnghiep,
            },
            success:function(res){
                if(res['act'] == "UpOrIns_1"){
                    resutlinfo(res['act'])
                    $("#uutientheothpt").html(res['tenkhuvucuutien'])
                }else{
                     if(res == "namtotnghiep"){
                        toastr.warning("Năm tốt nghiệp phải bé hơn năm hiện tại")
                        $('#v_namtotnghiep').show('slow')
                        $('#v_namtotnghiep').text("Năm tốt nghiệp phải bé hơn năm hiện tại")
                        $('#v_namtotnghiep').addClass('error')
                    }else{
                        if(res['maloi'] == "vali_1"){
                            toastr.warning("Có lỗi nhập thông tin, vui lòng chú ý hướng dẫn màu đỏ!")
                            var keys = Object.keys(res['data']['original'])
                            for(let i = 0; i<keys.length; i++){
                                $('#v_'+keys[i]).show('slow')
                                $('#v_'+keys[i]).text(res['data']['original'][keys[i]][0])
                                $('#v_'+keys[i]).addClass('error')
                            }
                        }else{
                            $('#modal_event').hide();
                            resutlinfo(res)
                        }
                    }
                }
            }
        })
        $('#modal_event').hide();
    }, 1000)
})

$('#doituonguutien').on('change',function(e){
    e.preventDefault();
    $('.validate').hide();
    $('#modal_event').show();
    setTimeout(() => {
        var doituonguutien = $(this).val();
        var id_user = $(this).attr('id_user')
        $.ajax({
            url: "/thongtincanhan/luudoituonguutien",
            type:'POST',
            data: {
                id_user: id_user,
                doituonguutien: doituonguutien,
            },
            success:function(res){
                resutlinfo(res)
                $('#modal_event').hide()
                $('#upload_uutien1_7').attr('src','/img/test.png')
                $('#upload_uutien2_8').attr('src','/img/test.png')
            }
        })
    }, 1000)
})


