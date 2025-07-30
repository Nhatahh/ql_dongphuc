$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#go_batch').select2();
    $('#go_active').select2();


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

    $('#go_search').on('click',function(){
        load_go($('#go_batch').val(),$('#go_active').val());
    })
})





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
    $.ajax({
        type: "get",
        url: 'go/load_go/'+id_batch+'/'+active,
        // dataType: 'json',
        success: function (r) {
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
            }, 0);
        }
    });
}

function sumArray(arr){
    let sum = 0;
        for(let i = 0; i<arr.length; i++){
            sum = Number($(arr[i]).text().trim()) + sum;
        }
    return sum;
}






function go_virtual(){
    $('#go_virtual').attr('disabled','true')
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
        },
        success: function (response) {
            $('#go_virtual').removeAttr('disabled')
            if(response == 1){
                toastr.success('Chạy lọc ảo thành công')
            }else{
                toastr.success('Chạy lọc ảo thất bại')
            }
            load_go($('#go_batch').val(),$('#go_active').val());
        }
    });
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




