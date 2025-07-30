$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#go_batch').select2();


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
    $('#go_batch').on('change',function(){
        load_go($(this).val());
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
function load_go(id_batch){
        $.ajax({
            type: "get",
            url: 'go/load_go/'+id_batch,
            // dataType: 'json',
            success: function (r) {
                alert(r[0].id)
                var html = "";
                for (let i = 0; i<r.length; i++){
                    html += "<tr>";
                    html += '<td style = "text-align: center">'+r[i].id+'</td>';
                    html += '<td>'+r[i].name_major+'</td>';
                    html += '<td style = "text-align: center">'+r[i].min_major+'</td>';
                    html += '<td style = "text-align: center">'+r[i].reg_all+'</td>';
                    html += '<td style = "text-align: center">'+r[i].reg_pas+'</td>';
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
                    html += '<td style = "text-align: center">'+r[i].min_major_hb1+'</td>';
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
                    html += '<td style = "text-align: center">'+r[i].min_major_hb2+'</td>';
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
                    html += '<td style = "text-align: center">'+r[i].min_major_nl+'</td>';
                    html += '<td style = "text-align: center">'+r[i].reg_pas_nl+'</td>';
                    if(r[i].reg_pas_nl == 0 || r[i].min_majornl ==0){
                        var tl_nl = "";
                    }else{
                        var tl_nl = Math.round(r[i].reg_pas_nl/r[i].min_majornl * 10000)/100
                    }
                    html += '<td style = "text-align: center">'+tl_nl+'</td>';
                    html += "</tr>";
                }

                alert(html)
                $('#go_load').html(html)
            }
        });
        // ajax: {
        //             type: "get",
        //             url: 'go/load_go/'+id_batch
        //         },

        // var table = $('#go_load').DataTable( {
        //     ajax: {
        //         type: "get",
        //         url: 'go/load_go/'+id_batch
        //     },

        //     // dom: 'frtip',
        //     columns: [
        //         // {
        //         //     title: 'STT',
        //         //     // data: 'active',
        //         //     // render: function(data){
        //         //     //     var data = data.split('-')
        //         //     //     return '<i onclick = "ass_student('+data[0]+')" id-active-user = "0" id-check = "'+data[3]+'" id-student = "'+data[0]+'" class="fas fa-edit active_ass_student check_ass_student'+data[0]+'"></i>'
        //         //     // }
        //         // },
        //         {
        //             title: "STT",
        //             data: 'id',

        //         },
        //         {
        //             title: "Ngành xét tuyển",
        //             colspan: "2",
        //             data: 'name_major',
        //         },
        //         {
        //             title: 'ĐK(Tổng)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'CT(Tổng)',
        //             data: 'min_major',
        //         },

        //         {
        //             title: 'TT(Tổng)',
        //             data: 'min_majorhb1',
        //         },
        //         {
        //             title: 'ĐK(HB1)',
        //             data: 'min_majorhb1',
        //         },
        //         {
        //             title: 'CT(HB1)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'Ngưỡng(HB1)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'ĐC(HB1)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'TT(HB1)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'ĐK(HB2)',
        //             data: 'min_majorhb1',
        //         },
        //         {
        //             title: 'CT(HB2)',
        //             data: 'min_majorhb2',
        //         },

        //         {
        //             title: 'ĐK(HB2)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'Ngưỡng(HB2)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'ĐC(HB2)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'TT(HB2)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'ĐK(NL)',
        //             data: 'min_majorhb1',
        //         },
        //         {
        //             title: 'CT(NL)',
        //             data: 'min_majornl',
        //         },

        //         {
        //             title: 'Ngưỡng(NL)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'ĐC(NL)',
        //             data: 'min_majorhb1',
        //         },

        //         {
        //             title: 'TT(NL)',
        //             data: 'min_majorhb1',
        //         },


        //         // {
        //         //     title: "Chỉ tiêu HB1",
        //         //     // data: 'name_user'
        //         // },

        //         // {
        //         //     title: "Chỉ tiêu HB2",
        //         //     // data: 'name_user'
        //         // },

        //         // {
        //         //     title: "Chỉ tiêu NL",
        //         //     // data: 'name_user'
        //         // },
        //         // {
        //         //     title: "Đăng ký",
        //         //     // data: 'name_user'
        //         // },
        //         // {
        //         //     title: "Ngưỡng",
        //         //     // data: 'name_user'
        //         // },
        //         // {
        //         //     title: "Điểm chuẩn",
        //         //     // data: 'name_user'
        //         // },
        //         // {
        //         //     title: "Trúng tuyển",
        //         //     // data: 'name_user'
        //         // },

        //         // {
        //         //     title: "NV1",
        //         //     // data: 'name_user'
        //         // },

        //         // {
        //         //     title: "NV2",
        //         //     // data: 'name_user'
        //         // },

        //         // {
        //         //     title: "NV3",
        //         //     // data: 'name_user'
        //         // },
        //         // {title: "Điện thoại",   data: 'phone_users'},

        //         // {
        //         //     title: "Đợt TS",
        //         //     data: 'name_batch',
        //         // },

        //         // {
        //         //     title: "Ngày phân công",
        //         //     data: 'update_at',
        //         //     render: function(data){
        //         //         var data = data.split('-')
        //         //         return '<span class = "update_at_ass'+data[1]+'">'+data[0]+'</span>'
        //         //     },
        //         // },

        //         // {
        //         //     title: "Nhân viên",
        //         //     data: 'name',
        //         //     render: function(data){
        //         //         var data = data.split('-')
        //         //         return '<span class ="user_check_ass'+data[1]+'">'+data[0]+'</span>'
        //         //     }
        //         // },

        //         // {
        //         //     title: "Kiểm tra",
        //         //     data: 'block',
        //         //     render: function(data){
        //         //         var data = data.split('-')
        //         //         if(data[0] == 1){
        //         //             return '<small class="badge badge-warning check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-unlock"></i>&nbsp;Chưa khóa</small>'
        //         //         }else{
        //         //             if(data[0] == 2){
        //         //                 return '<small class="badge badge-success check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-undo"></i>&nbsp;Phản hồi</small>'
        //         //             }else{
        //         //                 if(data[0] == 3){
        //         //                     return '<small class="badge badge-primary check_user'+data[1]+'" active = '+data[0]+'><i class="fa fa-lock"></i>&nbsp;Đã khóa</small>'
        //         //                 }else{
        //         //                     if(data[0] == 4){
        //         //                         return '<small class="badge badge-secondary check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-registered"></i>&nbsp;Đã đăng ký lại</small>'
        //         //                     }else{

        //         //                         if(data[0] == 5){
        //         //                             return '<small class="badge badge-info check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-bell"></i>&nbsp;Yêu cầu chỉnh sửa</small>'
        //         //                         }else{
        //         //                             return '<small class="badge badge-warning check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-unlock"></i>&nbsp;Chưa khóa</small>'
        //         //                         }
        //         //                     }
        //         //                 }
        //         //             }
        //         //         }
        //         //     }
        //         // },
        //         // {
        //         //     title: "Duyệt",
        //         //     data: 'active',
        //         //     render: function(data){
        //         //         var data = data.split('-')
        //         //         if(data[5] == 1){
        //         //             return '<span id = "check_send'+data[0]+'" send = '+data[5]+'><small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã duyệt</small></span>'
        //         //         }else{
        //         //             return '<span id = "check_send'+data[0]+'" send = '+data[5]+'><small class="badge badge-warning"><i class="fa fa-times"></i>&nbsp;Chưa duyệt</small></span>'
        //         //         }
        //         //     }
        //         // },

        //         // {
        //         //     title: "",
        //         //     data: 'active',
        //         //     render: function(data){
        //         //         var data = data.split('-')
        //         //         if(data[1] == 0){
        //         //             var style = 'red'
        //         //         }else{
        //         //             var style = '#007bff'
        //         //         }
        //         //         return '<i  onclick = "check_user_assuser('+data[0]+')" id-check = '+data[3]+' id-student = '+data[0]+' active = '+data[1]+' id-user = '+data[2]+' style = "color: '+style+'" class="fa fa-paper-plane check_user_assuser user_assuser'+data[0]+'"></i>'
        //         //     }
        //         // },

        //         // {
        //         //     title: "",
        //         //     data: 'active',
        //         //     render: function(data){
        //         //         var data = data.split('-')
        //         //         return '<i onclick = "del_assuser('+data[0]+')" id-student = '+data[0]+' id-check = '+data[3]+' style = "color: red" class="fas fa-trash del_assuser del_assuser_check'+data[0]+'"></i>'
        //         //     }
        //         // },

        //         // {
        //         //     title: '<i id-active = "0" onclick = "all_ass_pass()" class="fas fa-check all_ass_pass" active = "0"></i>',
        //         //     data: 'active',
        //         //     render: function(data){
        //         //         var data = data.split('-')
        //         //         if(data[5] == 1){
        //         //             var style = '#007bff'
        //         //             var active = 1;
        //         //         }else{
        //         //             var style = 'red'
        //         //             var active = 0;
        //         //         }
        //         //         return '<i  onclick = "send_user_assuser('+data[3]+','+data[2]+','+data[0]+')" id-check = '+data[3]+' id-check-block = '+data[5]+' id-student = '+data[0]+' active = '+active+' id-user = '+data[2]+' style = "color: '+style+'" class="fa fa-check send_user_assuser send_assuser'+data[3]+'"></i>'
        //         //     }
        //         // },

        //     ],
        // //     columnDefs: [ {
        // //         headerName: 'Group A',
        // //         children: [
        // //             { field: 'ĐK' },
        // //             { field: 'DC' },
        // //             { field: 'TT' }
        // // ]
        // //     } ],
        //     // columnDefs: [
        //     //     { "visible": false, "targets": -1 }
        //     // ],
        //     scrollY: 500,
        //     "language": {
        //         "emptyTable": "Không có ngành tuyển sinh",
        //         "info": " _START_ / _END_ trên _TOTAL_ ngành",
        //         "paginate": {
        //             "first":      "Trang đầu",
        //             "last":       "Trang cuối",
        //             "next":       "Trang sau",
        //             "previous":   "Trang trước"
        //         },
        //         "search":         "Tìm kiếm:",
        //         "loadingRecords": "Đang tìm kiếm ... ",
        //         "lengthMenu":     "Hiện thị _MENU_ ngành",
        //         "infoEmpty":      "",
        //         },
        //     "retrieve": true,
        //     "paging": true,
        //     "lengthChange": true,
        //     "searching": true,
        //     "ordering": false,
        //     "info": true,
        //     "autoWidth": true,
        //     "responsive": false,
        //     "select": true,
        // })

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




