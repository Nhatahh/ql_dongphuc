$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    chart_reg_sta()
    chart_reg_sta_basic()
})

//Load biểu dồ dawgnd ký
function chart_reg_sta(){
    $.ajax({
        type: "get",
        url: 'reg_sta/barChart_reg_sta',
        success: function (res) {
            var major = [],number = [],number2 = [],number3 = [],number4 = []
            for(let i = 0;i<res.length;i++){
                major[i] = res[i][1]
                number[i] = res[i][2]
                number2[i] = res[i][3]
                number3[i] = res[i][4]
                number4[i] = res[i][5]
            }
            var ctx = document.getElementById('barChart').getContext('2d');
            var myChart = new Chart(ctx, {
                data: {
                    labels: major,
                    datasets: [
                        {
                            label: 'Chỉ tiêu',
                            data: number4,
                            backgroundColor: [
                                'rgba(34,139,34,0.9)'
                            ],
                            borderColor: [
                                'rgba(34,139,34,1)'
                            ],
                            borderWidth: 1,
                            type: 'line',
                            stack: 'Stack 0',
                            datalabels:{
                                anchor: 'start',
                                color: 'black',
                                font: {
                                    weight: 'bold',
                                    size: '14pt'
                                }
                            },
                        },
                        {
                            label: 'Nguyện vọng 1',
                            data: number,
                            backgroundColor: [
                                'rgba(0, 0, 255,0.9)',
                            ],
                            borderColor: [
                                'rgba(0, 0, 255,1)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 1',
                            datalabels:{
                                anchor: 'center',
                                align: 'left',
                                color: 'white',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },
                        {
                            label: 'Nguyện vọng 2',
                            data: number2,
                            backgroundColor: [
                                'rgba(225, 0, 0,0.9)',
                            ],
                            borderColor: [
                                'rgba(225, 0, 0,1)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 1',
                            datalabels:{
                                anchor: 'center',
                                align: 'left',
                                color: 'white',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },
                        {
                            label: 'Nguyện vọng 3',
                            data: number3,
                            backgroundColor: [
                                'rgba(255,182,193,0.9)',
                            ],
                            borderColor: [
                                'rgba(255,182,193,1)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 1',
                            datalabels:{
                                anchor: 'center',
                                align: 'left',
                                color: 'white',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },
                    ]

                },
                options: {
                    responsive              : true,
                    maintainAspectRatio     : false,
                    datasetFill             : false,
                    // scales: {
                    //     y: {
                    //         beginAtZero: true
                    //     }
                    // }


                    scales: {
                        x: {
                          stacked: true,
                        },
                        y: {
                          stacked: true
                        }
                    }


                },
                plugins: [ChartDataLabels],
            });
        }
    });


}

function chart_reg_sta_basic(){
    $.ajax({
        type: "get",
        url: 'reg_sta/chart_reg_sta_basic',
        success: function (res) {
            // var major = [],number = [],number2 = [],number3 = []
            // for(let i = 0;i<res.length;i++){
            //     major[i] = res[i][1]
            //     number[i] = res[i][2]
            //     number2[i] = res[i][3]
            //     number3[i] = res[i][4]
            // }
            var label = ['Đăng ký tài khoản','Lưu nguyện vọng','Đăng ký nguyện vọng', 'Lệ phí xét tuyển','Duyệt hồ sơ', 'Đủ điều kiện xét tuyển']
            var ctx = document.getElementById('barReg').getContext('2d');
            var myChart = new Chart(ctx, {
                data: {
                    labels: ["Thống kê số lượng - tiến trình đăng ký xét tuyển"],
                    datasets: [
                        {
                            label: label[0],
                            data: [res.users],
                            backgroundColor: [
                                'rgba(255, 0, 0,0.9)'
                            ],
                            borderColor: [
                                'rgba(255, 0, 0,1)'
                            ],
                            borderWidth: 1,
                            datalabels:{
                                anchor: 'start',
                                color: 'black',
                                font: {
                                    weight: 'bold',
                                    size: '16pt'
                                }
                            },
                            type: 'bar',

                        },
                        {
                            label: label[1],
                            data:  [res.wish],
                            backgroundColor: [
                                'rgba(0, 0, 255,0.9)',
                            ],
                            borderColor: [
                                'rgba(0, 0, 255,1)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            datalabels:{
                                anchor: 'start',
                                color: 'black',
                                font: {
                                    weight: 'bold',
                                    size: '16pt'
                                }
                            },
                        },
                        {
                            label: label[2],
                            data:  [res.block],
                            backgroundColor: [
                                'RGBA( 0, 100, 0, 0.9)',
                            ],
                            borderColor: [
                                'RGBA( 0, 100, 0, 1 )',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            datalabels:{
                                anchor: 'start',
                                color: 'black',
                                font: {
                                    weight: 'bold',
                                    size: '16pt'
                                }
                            },
                        },
                        {
                            label: label[3],
                            data:  [res.exp],
                            backgroundColor: [
                                'RGBA( 255, 20, 147, 0.9)',
                            ],
                            borderColor: [
                                'RGBA(  255, 20, 147, 1 )',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            datalabels:{
                                anchor: 'start',
                                color: 'black',
                                font: {
                                    weight: 'bold',
                                    size: '16pt'
                                }
                            },
                        },
                        {
                            label: label[4],
                            data:  [res.pass],
                            backgroundColor: [
                                'RGBA( 54, 54, 54, 0.9)',
                            ],
                            borderColor: [
                                'RGBA( 54, 54, 54, 1 )',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            datalabels:{
                                anchor: 'start',
                                color: 'black',
                                font: {
                                    weight: 'bold',
                                    size: '16pt'
                                }
                            },
                        },
                        {
                            label: label[5],
                            data:  [res.go],
                            backgroundColor: [
                                'RGBA( 0, 104, 139, 0.9)',
                            ],
                            borderColor: [
                                'RGBA( 0, 104, 139, 1 )',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            datalabels:{
                                anchor: 'start',
                                color: 'black',
                                font: {
                                    weight: 'bold',
                                    size: '16pt'
                                }
                            },
                        },
                    ]
                },
                options: {
                    responsive              : true,
                    maintainAspectRatio     : false,
                    datasetFill             : false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
                plugins: [ChartDataLabels],
            });
        }
    });
}


// function chart_reg_sta(){
//     $.ajax({
//         type: "get",
//         url: 'reg_sta/barChart_reg_sta',
//         success: function (res) {
//             var major = [],number = [],number2 = []
//             for(let i = 0;i<res.length;i++){
//                 major[i] = res[i][1]
//                 number[i] = res[i][2]
//                 number2[i] = res[i][3]
//             }
//             var ctx = document.getElementById('barChart').getContext('2d');
//             var myChart = new Chart(ctx, {
//                 data: {
//                     labels: major,
//                     datasets: [
//                         {
//                             label: 'Chỉ tiêu',
//                             data: number2,
//                             backgroundColor: [
//                                 'rgba(255, 0, 0,0.9)'
//                             ],
//                             borderColor: [
//                                 'rgba(255, 0, 0,1)'
//                             ],
//                             borderWidth: 1,
//                             type: 'bar',
//                             datalabels:{
//                                 anchor: 'start',
//                                 color: 'black',
//                                 font: {
//                                     weight: 'bold',
//                                     size: '13pt'
//                                 }
//                             },
//                         },
//                         {
//                             label: 'Số lượng đăng ký',
//                             data: number,
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
//                                     size: '13pt'
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


//                     // scales: {
//                     //     x: {
//                     //       stacked: true,
//                     //     },
//                     //     y: {
//                     //       stacked: true
//                     //     }
//                     // }


//                 },
//                 plugins: [ChartDataLabels],
//             });
//         }
//     });


// }
