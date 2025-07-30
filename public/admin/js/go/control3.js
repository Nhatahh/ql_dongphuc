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
                html += "<tr>";
                html += '<td style = "text-align: center">'+r[i].id+'</td>';
                html += '<td>'+r[i].name_major+'</td>';
                html += '<td style = "text-align: center">'+r[i].min_major+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_all+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_pas+'</td>';

                html += '<td style = "text-align: center">'+r[i].reg_pas_nv1+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_pas_nv2+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_pas_nv3+'</td>';

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
                html += '<td style = "text-align: center">'+r[i].min_majorhb1+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_hb1+'</td>';
                html += '<td style = "text-align: center">'+r[i].min_mark_hb1+'</td>';
                html += '<td style = "text-align: center" id-data="'+r[i].method_1+'" class = "min_major" contenteditable="true">'+r[i].min_major_hb1+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_pas_hb1+'</td>';
                if(r[i].reg_pas_hb1 == 0 || r[i].min_majorhb1 ==0){
                    var tl_hb1 = "";
                }else{
                    var tl_hb1 = Math.round(r[i].reg_pas_hb1/r[i].min_majorhb1 * 10000)/100
                }
                html += '<td style = "text-align: center">'+tl_hb1+'</td>';
                html += '<td style = "text-align: center">'+r[i].min_majorhb2+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_hb2+'</td>';
                html += '<td style = "text-align: center">'+r[i].min_mark_hb2+'</td>';
                html += '<td style = "text-align: center" id-data="'+r[i].method_2+'" class = "min_major" contenteditable="true">'+r[i].min_major_hb2+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_pas_hb2+'</td>';
                if(r[i].reg_pas_hb2 == 0 || r[i].min_majorhb2 ==0){
                    var tl_hb2 = "";
                }else{
                    var tl_hb2 = Math.round(r[i].reg_pas_hb2/r[i].min_majorhb2 * 10000)/100
                }
                html += '<td style = "text-align: center">'+tl_hb2+'</td>';
                html += '<td style = "text-align: center">'+r[i].min_majornl+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_nl+'</td>';
                html += '<td style = "text-align: center">'+r[i].min_mark_nl+'</td>';
                html += '<td style = "text-align: center" id-data="'+r[i].method_3+'" class = "min_major" contenteditable="true">'+r[i].min_major_nl+'</td>';
                html += '<td style = "text-align: center">'+r[i].reg_pas_nl+'</td>';
                if(r[i].reg_pas_nl == 0 || r[i].min_majornl ==0){
                    var tl_nl = "";
                }else{
                    var tl_nl = Math.round(r[i].reg_pas_nl/r[i].min_majornl * 10000)/100
                }
                html += '<td style = "text-align: center">'+tl_nl+'</td>';
                html += "</tr>";
            }
            $('#go_load').html(html)
        }
    });
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




