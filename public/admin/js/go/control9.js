$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#go_batch').select2();
    $('#go_active').select2(
        // data: [
        //     {  id: 1 , text : "Lưu nguyện vọng" },
        // ]
    );
    // $('.go_setup_method2').hide()




    if($(document).width() > 992){
        $('#right_check_user').css('min-height','760px')
        $('#left_check_user').css('min-height','760px')
    }else{
        $('#right_check_user').css('min-height','0x')
        $('#left_check_user').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check_user').css('min-height','760px')
            $('#left_check_user').css('min-height','760px')
        }else{
            $('#right_check_user').css('min-height','0x')
            $('#left_check_user').css('min-height','0px')
        }
    });


    if($(document).width() > 992){
        $('#right_check').css('min-height','630px')
        $('#left_check').css('min-height','630px')
    }else{
        $('#right_check').css('min-height','0x')
        $('#left_check').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check').css('min-height','630px')
            $('#left_check').css('min-height','630px')
        }else{
            $('#right_check').css('min-height','0x')
            $('#left_check').css('min-height','0px')
        }
    });
    load_search();

    $('#ex_list_go').on('click',function(){
        ex_list_go();
    })

    $('#ex_list_student').on('click',function(){
        ex_list_student();
    })

    $('#ex_list_wish').on('click',function(){
        ex_list_wish();
    })

    $('#ex_list_wish_fail').on('click',function(){
        ex_list_wish_fail();
    })

    $('#ex_list_fail').on('click',function(){
        ex_list_fail();
    })

    $('#go_batch').on('change',function(){
        var  id = $(this).val()
        $.ajax({
            type: "get",
            url: 'go_setup/load_method_mark/'+id,
            success: function (res) {
                // alert(res[0].method_mark)
                // if(res[0].method_mark == 1){
                    load_go_active(id)
                    $.ajax({
                        type: "post",
                        url: "go/load_go_active/"+id,
                        success:function(res){
                            if(res > 0){
                                load_go($('#go_batch').val(),res);
                                load_go_number_wish($('#go_batch').val())
                            }else{
                                $('#go_load').html('')
                            }
                        }
                    });
                // }else{
                //     toastr.warning('Đợt tuyển sinh này không xét theo Ưu tiên điểm')
                // }
            }
        })
    })

    $('#go_active').on('change',function(){
        if($('#go_batch').val() == 0){
            toastr.warning('Chọn đợt tuyển sinh')
        }else{
            load_go($('#go_batch').val(),$('#go_active').val());
        }
    })

    $('#go_number_wish').on('change',function(){
        if($('#go_batch').val() == 0 || $('#go_batch').val() == ''){
            toastr.warning('Chọn đợt xét tuyển')
            $('#go_number_wish').val('')
        }else{
            if($(this).val() == 0 || $(this).val() == ""){
                toastr.warning('Chọn thứ tự nguyện vọng xét tuyển')
            }else{
                $.ajax({
                    type: "get",
                    url: 'go/go_number_wish/'+$(this).val()+'/'+$('#go_batch').val(),
                    success: function (res) {
                        if(res == 1){
                            toastr.success('Cài đặt nguyện vọng thành công')
                            load_go($('#go_batch').val(),$('#go_active').val());
                        }else{
                            toastr.warning('Cài đặt nguyện vọng thất bại')
                        }
                    }
                })
            }
        }
    })
})

// function load_method_mark(id){
//     $.ajax({
//         type: "get",
//         url: 'go_setup/load_method_mark/'+id,
//         success: function (res) {
//             a = res[0].method_mark
//         }
//     })
//     return a;
// }

function load_go_active(id){
    var  data = [
        // {  id: 0 , text : "Chọn đối tượng xét tuyển" },
        {  id: 1 , text : "Lưu nguyện vọng" },
        {  id: 2 , text : "Đã đăng ký xét tuyển" },
        {  id: 3 , text : "Đã đóng lệ phí" },
        {  id: 4 , text : "Đã kiểm tra hồ sơ" },
        {  id: 5 , text : "Đủ điều kiện xét tuyển" },
    ]
    $.ajax({
        type: "post",
        url: "go/load_go_active/"+id,
        success:function(res){
            data.forEach(element => {
                if(element.id == res){
                    element.selected = true
                }else{
                    element.selected = false
                }
            });
            $('#go_active').html('').select2({
                data: data
            });
        }
    });
}


function load_go_block(id){
    $.ajax({
        type: "post",
        url: "go/load_go_block/"+id,
        success: function (response) {
            if(response == 1){
                $('#go_block').attr('disabled','true')
                $('#save_go').attr('disabled','true')
                $('#go_virtual').attr('disabled','true')
                $('#go_active').attr('disabled','true')
            }else{
                $('#go_block').removeAttr('disabled')
                $('#save_go').removeAttr('disabled')
                $('#go_virtual').removeAttr('disabled')
                $('#go_active').removeAttr('disabled')
            }
        }
    });
}


function load_search(){
    $.ajax({
        type: "get",
        url: "go/load_search",
        success: function (res) {
            $('#go_batch').html('').select2({
                data: res.batch
            });
        }
    });
}





//Load bảng xét tuyển
function load_go(id_batch,active){
    if(id_batch == 0){
        $('#go_load').html('')
    }else{
        $.ajax({
            type: "get",
            url: 'go/load_go/'+id_batch+'/'+active,
            // dataType: 'json',
            success: function (r) {
                // alert(r)
                var html = "";
                for (let i = 0; i<r.length; i++){
                    if(i%2 == 1){
                        var active ="row_odd"
                    }else{
                        var active ="row_even"
                    }
                    html += "<tr class = '"+active+"'>";
                    html += '<td style = "text-align: center">'+r[i].id+'</td>';
                    html += '<td>'+r[i].name_major+'</td>';
                    html += '<td class = "min_major_1" style = "text-align: center">'+r[i].min_major+'</td>';
                    html += '<td class = "reg_all" style = "text-align: center">'+r[i].reg_all+'</td>';
                    html += '<td class = "reg_all_1" style = "text-align: center">'+r[i].reg_all_1+'</td>';
                    html += '<td class = "reg_pas" style = "text-align: center">'+r[i].reg_pas+'</td>';

                    html += '<td class = "reg_pas_nv1" style = "text-align: center">'+r[i].reg_pas_nv1+'</td>';
                    html += '<td class = "reg_pas_nv2" style = "text-align: center">'+r[i].reg_pas_nv2+'</td>';
                    html += '<td class = "reg_pas_nv3" style = "text-align: center">'+r[i].reg_pas_nv3+'</td>';

                    if(r[i].reg_all == 0 || r[i].reg_pas ==0){
                        var tl_ct = "";
                    }else{
                        var tl_ct = "1:"+Math.round(r[i].reg_all/r[i].reg_pas* 100)/100
                    }
                    html += '<td style = "text-align: center">'+tl_ct+'</td>';
                    if(r[i].reg_all == 0 || r[i].min_major ==0){
                        var tl_all = "";
                    }else{
                        var tl_all = Math.round(r[i].reg_pas/r[i].min_major * 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_all+'</td>';
                    html += '<td class = "min_majorhb1" style = "text-align: center">'+r[i].min_majorhb1+'</td>';
                    html += '<td class = "reg_hb1" style = "text-align: center">'+r[i].reg_hb1+'</td>';
                    html += '<td class = "min_mark_hb1" style = "text-align: center">'+r[i].min_mark_hb1+'</td>';
                    html += '<td class = "min_major_hb1 min_major" style = "text-align: center" id-data="'+r[i].method_1+'" contenteditable="true">'+r[i].min_major_hb1+'</td>';
                    html += '<td class = "reg_pas_hb1" style = "text-align: center">'+r[i].reg_pas_hb1+'</td>';
                    if(r[i].reg_pas_hb1 == 0 || r[i].min_majorhb1 ==0){
                        var tl_hb1 = "";
                    }else{
                        var tl_hb1 = Math.round(r[i].reg_pas_hb1/r[i].min_majorhb1 * 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_hb1+'</td>';
                    html += '<td class = "min_majorhb2" style = "text-align: center">'+r[i].min_majorhb2+'</td>';
                    html += '<td class = "reg_hb2" style = "text-align: center">'+r[i].reg_hb2+'</td>';
                    html += '<td class = "min_mark_hb2" style = "text-align: center">'+r[i].min_mark_hb2+'</td>';
                    html += '<td class = "min_major min_major_hb2" style = "text-align: center" id-data="'+r[i].method_2+'"contenteditable="true">'+r[i].min_major_hb2+'</td>';
                    html += '<td class = "reg_pas_hb2" style = "text-align: center">'+r[i].reg_pas_hb2+'</td>';
                    if(r[i].reg_pas_hb2 == 0 || r[i].min_majorhb2 ==0){
                        var tl_hb2 = "";
                    }else{
                        var tl_hb2 = Math.round(r[i].reg_pas_hb2/r[i].min_majorhb2 * 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_hb2+'</td>';
                    html += '<td class = "min_majornl" style = "text-align: center">'+r[i].min_majornl+'</td>';
                    html += '<td class = "reg_nl" style = "text-align: center">'+r[i].reg_nl+'</td>';
                    html += '<td class = "min_mark_nl" style = "text-align: center">'+r[i].min_mark_nl+'</td>';
                    html += '<td class = "min_major min_major_nl" style = "text-align: center" id-data="'+r[i].method_3+'"  contenteditable="true">'+r[i].min_major_nl+'</td>';
                    html += '<td class = "reg_pas_nl" style = "text-align: center">'+r[i].reg_pas_nl+'</td>';
                    if(r[i].reg_pas_nl == 0 || r[i].min_majornl ==0){
                        var tl_nl = "";
                    }else{
                        var tl_nl = Math.round(r[i].reg_pas_nl/r[i].min_majornl * 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_nl+'</td>';
                    html += "</tr>";
                }
                html += "<tr>";
                    // html += '<td style = "text-align: center"></td>';
                    html += '<td colspan = "2" style = "text-align: center">Tổng</td>';

                    html += '<td class = "min_major_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_all_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_all_1_sum" style = "text-align: right;font-weight: bold"></td>';

                    html += '<td class = "reg_pas_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_pas_nv1_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_pas_nv2_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td class = "reg_pas_nv3_sum" style = "text-align: right;font-weight: bold"></td>';

                    html += '<td  class = "tlct_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "tl_sum" style = "text-align: right;font-weight: bold"></td>';

                    html += '<td  class = "min_majorhb1_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_hb1_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "min_mark_hb1_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "min_major_hb1_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_pas_hb1_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_pas_hb1_tl" style = "text-align: right;font-weight: bold"></td>';


                    html += '<td  class = "min_majorhb2_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_hb2_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "min_mark_hb2_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "min_major_hb2_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_pas_hb2_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_pas_hb2_tl" style = "text-align: right;font-weight: bold"></td>';

                    html += '<td  class = "min_majornl_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_nl_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "min_mark_nl_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "min_major_nl_sum"  style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_pas_nl_sum" style = "text-align: right;font-weight: bold"></td>';
                    html += '<td  class = "reg_pas_nl_tl" style = "text-align: right;font-weight: bold"></td>';

                html += "</tr>";

                $('#go_load').html(html)
                setTimeout(() => {

                    var min_major = document.getElementsByClassName('min_major_1')
                    $('.min_major_sum').text(sumArray(min_major))
                    var reg_all = document.getElementsByClassName('reg_all')
                    $('.reg_all_sum').text(sumArray(reg_all))

                    var reg_all_1 = document.getElementsByClassName('reg_all_1')
                    $('.reg_all_1_sum').text(sumArray(reg_all_1))
                    var reg_pas = document.getElementsByClassName('reg_pas')
                    $('.reg_pas_sum').text(sumArray(reg_pas))
                    var reg_pas_nv1 = document.getElementsByClassName('reg_pas_nv1')
                    $('.reg_pas_nv1_sum').text(sumArray(reg_pas_nv1))
                    var reg_pas_nv2 = document.getElementsByClassName('reg_pas_nv2')
                    $('.reg_pas_nv2_sum').text(sumArray(reg_pas_nv2))
                    var reg_pas_nv3 = document.getElementsByClassName('reg_pas_nv3')
                    $('.reg_pas_nv3_sum').text(sumArray(reg_pas_nv3))
                    if(sumArray(reg_all) == 0 || sumArray(reg_pas) ==0){
                        var tl_ct_sum = "";
                    }else{
                        var tl_ct_sum = "1:"+Math.round(sumArray(reg_all)/sumArray(reg_pas)*100)/100
                    }
                    $('.tlct_sum').text(tl_ct_sum)

                    if(sumArray(reg_all) == 0 || sumArray(min_major) ==0){
                        var tl_sum = "";
                    }else{
                        var tl_sum = Math.round(sumArray(reg_pas)/sumArray(min_major)*10000)/100
                    }
                    $('.tl_sum').text(tl_sum)

                    var min_majorhb1 = document.getElementsByClassName('min_majorhb1')
                    $('.min_majorhb1_sum').text(sumArray(min_majorhb1))
                    var reg_hb1 = document.getElementsByClassName('reg_hb1')
                    $('.reg_hb1_sum').text(sumArray(reg_hb1))
                    var min_mark_hb1 = document.getElementsByClassName('min_mark_hb1')
                    $('.min_mark_hb1_sum').text(Math.round(sumArray(min_mark_hb1)/min_mark_hb1.length*100)/100)
                    var min_major_hb1 = document.getElementsByClassName('min_major_hb1')
                    $('.min_major_hb1_sum').text(Math.round(sumArray(min_major_hb1)/min_major_hb1.length*100)/100)
                    var reg_pas_hb1 = document.getElementsByClassName('reg_pas_hb1')
                    $('.reg_pas_hb1_sum').text(sumArray(reg_pas_hb1))
                    if(sumArray(reg_hb1) == 0 || sumArray(reg_pas_hb1) == 0){
                        var tl_hb1_sum = "";
                    }else{
                        var tl_hb1_sum = Math.round(sumArray(reg_pas_hb1)/sumArray(reg_hb1) * 10000)/100
                    }
                    $('.reg_pas_hb1_tl').text(tl_hb1_sum)

                    var min_majorhb2 = document.getElementsByClassName('min_majorhb2')
                    $('.min_majorhb2_sum').text(sumArray(min_majorhb2))
                    var reg_hb2 = document.getElementsByClassName('reg_hb2')
                    $('.reg_hb2_sum').text(sumArray(reg_hb2))
                    var min_mark_hb2 = document.getElementsByClassName('min_mark_hb2')
                    $('.min_mark_hb2_sum').text(Math.round(sumArray(min_mark_hb2)/min_mark_hb2.length*100)/100)
                    var min_major_hb2 = document.getElementsByClassName('min_major_hb2')
                    $('.min_major_hb2_sum').text(Math.round(sumArray(min_major_hb2)/min_major_hb2.length*100)/100)
                    var reg_pas_hb2 = document.getElementsByClassName('reg_pas_hb2')
                    $('.reg_pas_hb2_sum').text(sumArray(reg_pas_hb2))
                    if(sumArray(reg_hb2) == 0 || sumArray(reg_pas_hb2) == 0){
                        var tl_hb2_sum = "";
                    }else{
                        var tl_hb2_sum = Math.round(sumArray(reg_pas_hb2)/sumArray(reg_hb2) * 10000)/100
                    }
                    $('.reg_pas_hb2_tl').text(tl_hb2_sum)


                    var min_majornl = document.getElementsByClassName('min_majornl')
                    $('.mmin_majornl_sum').text(sumArray(min_majornl))
                    var reg_nl = document.getElementsByClassName('reg_nl')
                    $('.reg_nl_sum').text(sumArray(reg_nl))
                    var min_mark_nl = document.getElementsByClassName('min_mark_nl')
                    $('.min_mark_nl_sum').text(Math.round(sumArray(min_mark_nl)/min_mark_nl.length*100)/100)
                    var min_major_nl = document.getElementsByClassName('min_major_nl')
                    $('.min_major_nl_sum').text(Math.round(sumArray(min_major_nl)/min_major_nl.length*100)/100)
                    var reg_pas_nl = document.getElementsByClassName('reg_pas_nl')
                    $('.reg_pas_nl_sum').text(sumArray(reg_pas_nl))
                    if(sumArray(reg_nl) == 0 || sumArray(reg_pas_nl) == 0){
                        var tl_nl_sum = "";
                    }else{
                        var tl_nl_sum = Math.round(sumArray(reg_pas_nl)/sumArray(reg_nl) * 10000)/100
                    }
                    $('.reg_pas_nl_tl').text(tl_nl_sum)
                    load_go_block(id_batch);
                }, 0);
            }
        });
    }
}

function sumArray(arr){
    let sum = 0;
        for(let i = 0; i<arr.length; i++){
            sum = Number($(arr[i]).text().trim()) + sum;
        }
    return sum;
}

function  load_go_number_wish(id){
    $.ajax({
        type: "post",
        url: "go/check_type/"+id,
        success: function (res) {
            if(res == 1){
                $('#go_number_wish').val('')
                $('#go_number_wish').attr('disabled','true')
            }else{
                $('#go_number_wish').removeAttr('disabled')
                $.ajax({
                    type: "get",
                    url: "go/load_go_number_wish/"+id,
                    success: function (res) {
                        if(res == -1){
                            toastr.warning('Không tìm thấy Đợt tuyển sinh')
                        }else{
                            $('#go_number_wish').attr('value',res)
                        }
                    }
                })
            }
        }
    })
}


function go_virtual(){
    $('#go_virtual').attr('disabled','true')
    var id = $('#go_batch').val();
    if(id == 0 || id == ''){
        toastr.warning("Chọn Đợt tuyển sinh để xét tuyển")
    }else{
        $.ajax({
            type: "post",
            url: "go/check_type/"+id,
            success: function (res) {
                if(res == 1){
                    var min_majors = document.getElementsByClassName('min_major')
                    var arr_mark = [];
                    for(let i = 0; i<min_majors.length;i++){
                        arr_mark[i] =[$(min_majors[i]).attr('id-data'),$(min_majors[i]).text()]
                    }
                    $.ajax({
                        type: "post",
                        url: "go/go_virtual",
                        data: {
                            arr_mark: arr_mark,
                            id: $('#go_batch').val()
                        },
                        success: function (response) {
                            $('#go_virtual').removeAttr('disabled')
                            if(response == 1){
                                toastr.success('Chạy lọc ảo thành công')
                            }else{
                                toastr.warning('Chạy lọc ảo thất bại')
                            }
                            load_go($('#go_batch').val(),$('#go_active').val());
                        }
                    });
                }else{
                    if(res == 2){
                        if($('#go_number_wish').val() == 0 || $('#go_number_wish').val() == "" ){
                            toastr.warning("Chọn thứ tự nguyên vọng, để xét tuyển")
                        }else{
                            $.ajax({
                                type: "post",
                                url: "go/go_virtual",
                                data: {
                                    arr_mark: arr_mark,
                                    id: $('#go_batch').val(),
                                    active: $('#go_active').val()
                                },
                                success: function (response) {
                                    if(response == 1){
                                        toastr.success('Chạy lọc ảo thành công')
                                    }else{
                                        toastr.warning('Chạy lọc ảo thất bại')
                                    }
                                    load_go($('#go_batch').val(),$('#go_active').val());
                                }
                            })
                        }
                        $('#go_virtual').removeAttr('disabled')
                    }
                }
            }
        })
    }

}



function save_go(){
    $('#save_go').attr('disabled','true')
    var id = $('#go_batch').val()
    var active = $('#go_active').val()
    if(id == 0){
        $('#save_go').removeAttr('disabled')
        toastr.warning('Chọn đợt tuyển sinh')
    }else{
        var choice = confirm("Lưu ý! Đợt xét tuyển phải chắc chắn được chạy lọc ảo");
        if(choice == true){
        $.ajax({
            type: "get",
            url: "go/save_go/"+id+'/'+active,
            success: function (response) {
                $('#save_go').removeAttr('disabled')
                if(response == 1){
                    toastr.success('Lưu thành công')
                }else{
                    if(response == 2){
                        toastr.warning('Không có thí sinh trúng tuyển')
                    }else{
                        toastr.warning('Lưu thất bại')
                    }
                }
                load_go($('#go_batch').val(),$('#go_active').val());
            }
        });
        }else{
            $('#save_go').removeAttr('disabled')
        }
    }
}

function ex_list_go(){
    var id = $('#go_batch').val()
    if(id == 0){
        toastr.warning('Chọn đợt tuyển sinh')
    }else{
        // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go/ex_list_go/"+id
        window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go/ex_list_go/"+id

    }
}




function ex_list_student(){
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go/ex_list_student"
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go/ex_list_student"

}

function ex_list_wish(){
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go/ex_list_wish"
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go/ex_list_wish"

}

function ex_list_wish_fail(){
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go/ex_list_wish_fail"
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go/ex_list_wish_fail"

}

function ex_list_fail(){
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go/ex_list_fail"
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go/ex_list_fail"

}

function go_sta(){
    var id = $('#go_batch').val()
    if(id == 0){
        toastr.warning('Chọn đợt tuyển sinh')
    }else{
        // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/go/go_sta/"+id
        window.location.href = "https://congmotcua.ctuet.edu.vn/admin/go/go_sta/"+id

    }
}




function go_block(){
    $('#go_block').attr('disabled','true')
    var id = $('#go_batch').val()
    if(id == 0){
        toastr.warning('Chọn đợt tuyển sinh')
        $('#go_block').removeAttr('disabled')
    }else{
        $.ajax({
            type: "post",
            url: "go/go_block/"+id,
            success: function (response) {
                if(response == 1){
                    toastr.success('Cập nhật thành công')
                }else{
                    toastr.warning('Cập nhật thất bại')
                }
                load_go($('#go_batch').val(),$('#go_active').val());
            }
        });
    }
}


//Load biểu dồ dawgnd ký
// function chart_reg_sta(val){
//     $('#add_barChart').empty();
//     $('#add_barChart').append('<canvas id="barChart" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>');
//     setTimeout(() => {
//         $.ajax({
//             type: "get",
//             url: 'reg_sta/barChart_reg_sta/'+val,
//             success: function (res) {
//                 var major = [],number = [],number2 = [],number3 = [],number4 = []
//                 for(let i = 0;i<res.length;i++){
//                     major[i] = res[i][1]
//                     number[i] = res[i][2]
//                     number2[i] = res[i][3]
//                     number3[i] = res[i][4]
//                     number4[i] = res[i][5]
//                 }
//                 var ctx = document.getElementById('barChart').getContext('2d');
//                 var myChart = new Chart(ctx, {
//                     data: {
//                         labels: major,
//                         datasets: [
//                             {
//                                 label: 'Chỉ tiêu',
//                                 data: number4,
//                                 backgroundColor: [
//                                     'rgba(34,139,34,0.9)'
//                                 ],
//                                 borderColor: [
//                                     'rgba(34,139,34,1)'
//                                 ],
//                                 borderWidth: 1,
//                                 type: 'line',
//                                 stack: 'Stack 0',
//                                 datalabels:{
//                                     anchor: 'start',
//                                     color: 'black',
//                                     font: {
//                                         weight: 'bold',
//                                         size: '14pt'
//                                     }
//                                 },
//                             },
//                             {
//                                 label: 'Nguyện vọng 1',
//                                 data: number,
//                                 backgroundColor: [
//                                     'rgba(0, 0, 255,0.9)',
//                                 ],
//                                 borderColor: [
//                                     'rgba(0, 0, 255,1)',
//                                 ],
//                                 borderWidth: 1,
//                                 type: 'bar',
//                                 stack: 'Stack 1',
//                                 datalabels:{
//                                     anchor: 'center',
//                                     align: 'left',
//                                     color: 'white',
//                                     font: {
//                                         weight: 'bold',
//                                         size: '13pt'
//                                     }
//                                 },
//                             },
//                             {
//                                 label: 'Nguyện vọng 2',
//                                 data: number2,
//                                 backgroundColor: [
//                                     'rgba(225, 0, 0,0.9)',
//                                 ],
//                                 borderColor: [
//                                     'rgba(225, 0, 0,1)',
//                                 ],
//                                 borderWidth: 1,
//                                 type: 'bar',
//                                 stack: 'Stack 1',
//                                 datalabels:{
//                                     anchor: 'center',
//                                     align: 'left',
//                                     color: 'white',
//                                     font: {
//                                         weight: 'bold',
//                                         size: '13pt'
//                                     }
//                                 },
//                             },
//                             {
//                                 label: 'Nguyện vọng 3',
//                                 data: number3,
//                                 backgroundColor: [
//                                     'rgba(255,182,193,0.9)',
//                                 ],
//                                 borderColor: [
//                                     'rgba(255,182,193,1)',
//                                 ],
//                                 borderWidth: 1,
//                                 type: 'bar',
//                                 stack: 'Stack 1',
//                                 datalabels:{
//                                     anchor: 'center',
//                                     align: 'left',
//                                     color: 'white',
//                                     font: {
//                                         weight: 'bold',
//                                         size: '13pt'
//                                     }
//                                 },
//                             },
//                         ]

//                     },
//                     options: {
//                         responsive              : true,
//                         maintainAspectRatio     : false,
//                         datasetFill             : false,
//                         // scales: {
//                         //     y: {
//                         //         beginAtZero: true
//                         //     }
//                         // }


//                         scales: {
//                             x: {
//                               stacked: true,
//                             },
//                             y: {
//                               stacked: true
//                             }
//                         }


//                     },
//                     plugins: [ChartDataLabels],
//                 });
//             }
//         });
//     },1);



// }

// function chart_reg_sta_basic(){
//     $.ajax({
//         type: "get",
//         url: 'reg_sta/chart_reg_sta_basic',
//         success: function (res) {
//             // var major = [],number = [],number2 = [],number3 = []
//             // for(let i = 0;i<res.length;i++){
//             //     major[i] = res[i][1]
//             //     number[i] = res[i][2]
//             //     number2[i] = res[i][3]
//             //     number3[i] = res[i][4]
//             // }
//             var label = ['Đăng ký tài khoản','Lưu nguyện vọng','Đăng ký nguyện vọng', 'Lệ phí xét tuyển','Duyệt hồ sơ', 'Đủ điều kiện xét tuyển']
//             var ctx = document.getElementById('barReg').getContext('2d');
//             var myChart = new Chart(ctx, {
//                 data: {
//                     labels: ["Thống kê số lượng - tiến trình đăng ký xét tuyển"],
//                     datasets: [
//                         {
//                             label: label[0],
//                             data: [res.users],
//                             backgroundColor: [
//                                 'rgba(255, 0, 0,0.9)'
//                             ],
//                             borderColor: [
//                                 'rgba(255, 0, 0,1)'
//                             ],
//                             borderWidth: 1,
//                             datalabels:{
//                                 anchor: 'start',
//                                 color: 'black',
//                                 font: {
//                                     weight: 'bold',
//                                     size: '16pt'
//                                 }
//                             },
//                             type: 'bar',

//                         },
//                         {
//                             label: label[1],
//                             data:  [res.wish],
//                             backgroundColor: [
//                                 'rgba(0, 0, 255,0.9)',
//                             ],
//                             borderColor: [
//                                 'rgba(0, 0, 255,1)',
//                             ],
//                             borderWidth: 1,
//                             type: 'bar',
//                             datalabels:{
//                                 anchor: 'start',
//                                 color: 'black',
//                                 font: {
//                                     weight: 'bold',
//                                     size: '16pt'
//                                 }
//                             },
//                         },
//                         {
//                             label: label[2],
//                             data:  [res.block],
//                             backgroundColor: [
//                                 'RGBA( 0, 100, 0, 0.9)',
//                             ],
//                             borderColor: [
//                                 'RGBA( 0, 100, 0, 1 )',
//                             ],
//                             borderWidth: 1,
//                             type: 'bar',
//                             datalabels:{
//                                 anchor: 'start',
//                                 color: 'black',
//                                 font: {
//                                     weight: 'bold',
//                                     size: '16pt'
//                                 }
//                             },
//                         },
//                         {
//                             label: label[3],
//                             data:  [res.exp],
//                             backgroundColor: [
//                                 'RGBA( 255, 20, 147, 0.9)',
//                             ],
//                             borderColor: [
//                                 'RGBA(  255, 20, 147, 1 )',
//                             ],
//                             borderWidth: 1,
//                             type: 'bar',
//                             datalabels:{
//                                 anchor: 'start',
//                                 color: 'black',
//                                 font: {
//                                     weight: 'bold',
//                                     size: '16pt'
//                                 }
//                             },
//                         },
//                         {
//                             label: label[4],
//                             data:  [res.pass],
//                             backgroundColor: [
//                                 'RGBA( 54, 54, 54, 0.9)',
//                             ],
//                             borderColor: [
//                                 'RGBA( 54, 54, 54, 1 )',
//                             ],
//                             borderWidth: 1,
//                             type: 'bar',
//                             datalabels:{
//                                 anchor: 'start',
//                                 color: 'black',
//                                 font: {
//                                     weight: 'bold',
//                                     size: '16pt'
//                                 }
//                             },
//                         },
//                         {
//                             label: label[5],
//                             data:  [res.go],
//                             backgroundColor: [
//                                 'RGBA( 0, 104, 139, 0.9)',
//                             ],
//                             borderColor: [
//                                 'RGBA( 0, 104, 139, 1 )',
//                             ],
//                             borderWidth: 1,
//                             type: 'bar',
//                             datalabels:{
//                                 anchor: 'start',
//                                 color: 'black',
//                                 font: {
//                                     weight: 'bold',
//                                     size: '16pt'
//                                 }
//                             },
//                         },
//                     ]
//                 },
//                 options: {
//                     responsive              : true,
//                     maintainAspectRatio     : false,
//                     datasetFill             : false,
//                     scales: {
//                         y: {
//                             beginAtZero: true
//                         }
//                     }
//                 },
//                 plugins: [ChartDataLabels],
//             });
//         }
//     });
// }




