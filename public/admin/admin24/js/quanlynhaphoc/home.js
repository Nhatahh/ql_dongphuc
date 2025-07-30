$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    bieudo()
});

function bieudo() {
    $.ajax({
        url: "/admin24/bieudo",
        type: 'get',
        success: function (res) {
            var tenchuyennganh = [], slnv1 = [], slnv2 = [], slnv3 = []
            var nguyenvong = res.nguyenvong
            for (let i = 0; i < nguyenvong.length; i++) {
                tenchuyennganh[i] = nguyenvong[i]['tenchuyennganh']
                slnv1[i] = nguyenvong[i]['slnv1']
                slnv2[i] = nguyenvong[i]['slnv2']
                slnv3[i] = nguyenvong[i]['slnv3']
            }
            //Biểu đồ nguyện vọng
            var nguyenvong_chart = new Chart(document.getElementById('nguyenvong-chart-canvas').getContext('2d'), {
                data: {
                    labels: tenchuyennganh,
                    datasets: [
                        {
                            label: 'Nguyện vọng 1',
                            data: slnv1,
                            backgroundColor: [
                                '#007bff',
                            ],
                            borderColor: [
                                '#007bff',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 0',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
                                color: 'white',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },

                        {
                            label: 'Nguyện vọng 2',
                            data: slnv2,
                            backgroundColor: [
                                '#ffc107',
                            ],
                            borderColor: [
                                '#ffc107',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 0',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
                                color: 'white',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },

                        {
                            label: 'Nguyện vọng 3',
                            data: slnv1,
                            backgroundColor: [
                                '#6c757d',
                            ],
                            borderColor: [
                                '#6c757d',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 0',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
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
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,

                        }
                    }
                },
                plugins: [ChartDataLabels],
            });

            //Biểu đồ chỉ tiêu
            var chitieu = res.chitieu;
            var tennganh = [], value = [];
            for (let i = 0; i < chitieu.length; i++) {
                tennganh[i] = chitieu[i]['tennganh']
                value[i] = chitieu[i]['chitieu']
            }
            var chitieu_chart = new Chart(document.getElementById('chitieu-chart-canvas').getContext('2d'), {
                data: {
                    labels: tennganh,
                    datasets: [
                        {
                            label: 'Ngành tuyển sinh',
                            data: value,
                            backgroundColor: [
                                '#007bff',
                            ],
                            borderColor: [
                                '#007bff',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 0',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
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
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 14
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,

                        }
                    }
                },
                plugins: [ChartDataLabels],
            });

        }
    })
}




// function bieudonguyenvong1(){
//     $.ajax({
//         url: "/admin24/nguyenvong-chart-canvas",
//         type:'get',
//         success:function(res){
//             var tenchuyennganh = [],slnv1=[],slnv2=[],slnv3=[]
//             for(let i = 0;i<res.length;i++){
//                 tenchuyennganh[i] = res[i]['tenchuyennganh']
//                 slnv1[i] = res[i]['slnv1']
//                 slnv2[i] = res[i]['slnv2']
//                 slnv3[i] = res[i]['slnv3']
//             }
//             const ctx = document.getElementById('sale-chart-canvas');
//             new Chart(ctx, {
//                 type: 'bar',
//                 data: {
//                 label: 'Số lượng nguyện vọng',
//                 labels: tenchuyennganh,
//                 datasets: [
//                     {
//                         label: 'Nguyện vọng 1',
//                         data: slnv1,
//                         backgroundColor: [
//                             '#007bff'
//                         ],
//                         borderColor: [
//                             '#007bff'
//                         ],
//                         borderWidth: 0,
//                         type: 'bar',
//                         stack: 'Stack 0',
//                         datalabels:{
//                             anchor: 'start',
//                             color: 'black',
//                             font: {
//                                 weight: 'bold',
//                                 size: '14pt'
//                             }
//                         },
//                     },
//                     {
//                         label: 'Nguyện vọng 2',
//                         data: slnv2,
//                         backgroundColor: [
//                             '#ffc107'
//                         ],
//                         borderColor: [
//                             '#ffc107'
//                         ],
//                         borderWidth: 0,
//                         type: 'bar',
//                         stack: 'Stack 1',
//                         datalabels:{
//                             anchor: 'start',
//                             color: 'black',
//                             font: {
//                                 weight: 'bold',
//                                 size: '14pt'
//                             }
//                         },
//                     },
//                     {
//                         label: 'Nguyện vọng 3',
//                         data: slnv3,
//                         backgroundColor: [
//                             '#28a745'
//                         ],
//                         borderColor: [
//                             '#28a745'
//                         ],
//                         borderWidth: 0,
//                         type: 'bar',
//                         stack: 'Stack 2',
//                         datalabels:{
//                             anchor: 'start',
//                             color: 'black',
//                             font: {
//                                 weight: 'bold',
//                                 size: '14pt'
//                             }
//                         },
//                     }
//                 ]
//                 },
//                 options: {
//                 scales: {
//                     y: {
//                     beginAtZero: true
//                     }
//                 }
//                 }
//             });

//         }
//     })
// }
