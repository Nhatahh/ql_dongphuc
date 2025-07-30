$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(window).resize(function() {
        equalizeHeight();
    });
    thsl_load_index();
})
    function thsl_change_tinh(){
        $('#thsl_truongthpt').empty()
        var tinh =  $('#thsl_tinh').val()
        if( tinh > 0){
            $.ajax({
                type: "get",
                url: "dsts_change_tinh/"+tinh,
                success: function (res) {
                    $('#thsl_truongthpt').select2({
                        data: res.dsts_truongthpt
                    })
                }
            });
        }else{
            $('#dsts_truongthpt').select2()
        }
    }
    function thsl_loadtimkiem(){
        return new Promise (function(resolve, reject){
            $.ajax({
                type: "get",
                url: "dsts_loadtimkiem",
                success: function (res) {

                    $('#thsl_namtuyensinh').select2({
                        data: res.dsts_namtuyensinh
                    })

                    var selectedOption = $('#thsl_namtuyensinh').find('option').filter(function() {
                        var year = new Date().getFullYear();
                        return $(this).text() == year; // Kiểm tra giá trị 'value' bằng 2024
                    }).val(); // Lấy text của option
                    $('#thsl_namtuyensinh').val(selectedOption).trigger('change');
                    $('#thsl_namtotnghiep').select2({
                        data: res.dsts_namtotnghiep
                    })
                    $('#thsl_tinh').select2({
                        data: res.dsts_tinh
                    })

                    $('#thsl_truongthpt').empty()
                    $('#thsl_truongthpt').select2()
                    resolve(true)
                }
            });
        })
    }
    async function thsl_load_index(){
        await open_preloader(0);//Mở Preloader (main.js)
        await loadtimkiem_trong() //(main.js)
        await thsl_loadtimkiem();
        await equalizeHeight(); //Cân bằng 2 block trái và phải (main.js)
        await thsl_bieudo_cacnam();
        await close_preloader(0); //Tắt Preloader (main.js)

    }
    async function thsl_bieudo_cacnam(){
        var data = await thsl_bieudo_data(0)
        await thsl_bieudo_html(data)
        await thsl_bieudo_load(data)
    }
    function thsl_bieudo_data(trangthai){
        return new Promise(function(resolve,reject){
            var namts = $('#thsl_namtuyensinh').val();
            var namtn = $('#thsl_namtotnghiep').val();
            var tinh = $('#thsl_tinh').val();
            var truongthpt = $('#thsl_truongthpt').val();
            if(truongthpt == null){
                truongthpt = 0;
            }
            if(namtn == null){
                namtn = 0;
            }
            if(tinh == null){
                tinh = 0;
            }
            var url = '/admin24/thsl_loadbieudo_cacnam/0/0/0/0'
            if(trangthai != 0 ){
                url = "/admin24/thsl_loadbieudo_cacnam/"+namts+"/"+namtn+"/"+tinh+"/"+truongthpt
            }
            $.ajax({
                url: url,
                type: 'get',
                success: function (res) {
                    switch (trangthai) {
                        case 0:
                            var data = [];
                            for (let i = 0; i < res.length; i++) {
                                var tlnam = res[i]['sl_nam']/(res[i]['sl_nam']+res[i]['sl_nu'])
                                var tlnam_fix = (tlnam*100).toFixed(0)
                                var tlnu_fix = 100 -  tlnam_fix
                                data[i] = ["Năm "+res[i]['namtuyensinh'],[tlnam_fix,tlnu_fix]];
                            }
                            break;
                        case 1:
                            var data = {}
                            var dk_nam = [],tt_nam = [],dk_nu = [],tt_nu = []
                            for (let i = 0; i < res.length; i++) {
                                var dk_nam = res[i]['sl_nam']
                                var tt_nam = res[i]['sl_nam_tt']
                                var nh_nam = res[i]['sl_nam_nh']
                                var rut_nam = res[i]['sl_nam_rut']

                                var dk_nu = res[i]['sl_nu']
                                var tt_nu = res[i]['sl_nu_tt']
                                var nh_nu = res[i]['sl_nu_nh']
                                var rut_nu = res[i]['sl_nu_rut']

                                var dk = res[i]['dangky']
                                var tt = res[i]['trungtuyen']
                                var nh = res[i]['danghoc']
                                var ruths = res[i]['ruths']
                            }
                            data.dangky = [dk,dk_nam,dk_nu]
                            data.trungtuyen = [tt,tt_nam,tt_nu]
                            data.nhaphoc = [nh,nh_nam,nh_nu]
                            data.ruths = [ruths,rut_nam,rut_nu]
                            break;

                        default:
                            break;
                    }

                    resolve(data)
                }
            })
        })
    }
    function thsl_bieudo_html(data){
        return new Promise(function(resolve,reject){
            $('#load_bieudo_pie').empty();
            for(let i = 0; i<data.length; i++){
                $('#load_bieudo_pie').append('<div id ="thsl_pie_border" style = "text-align:center"><canvas id="thsl_gt-chart-canvas'+i+'" height="200px" style="height: 200px; display: block;"></canvas><div style = "font-weight:bold">'+data[i][0]+'</div></div>')
            }
            resolve(true)
        });
    }
    function thsl_bieudo_load(data_pie){
        return new Promise(function(resolve,reject){
            for(let i = 0; i<data_pie.length; i++){
                new Chart(document.getElementById('thsl_gt-chart-canvas'+i).getContext('2d'), {
                    type: 'pie', // Xác định loại biểu đồ là pie
                    data: {
                        labels:  ["Nam","Nữ"], // Các nhãn của biểu đồ
                        datasets: [{
                            label: data_pie[i][0] ,
                            data: data_pie[i][1], // Dữ liệu cho từng phần của pie
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                ], // Màu sắc cho các phần của pie
                        // hoverOffset: 4 // Khoảng cách khi hover
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false, // Tắt giữ tỉ lệ khung hình cố định
                        plugins: {
                            legend: {
                                position: 'top', // Vị trí của legend
                            },
                            tooltip: {
                                enabled: true // Hiển thị tooltip khi hover
                            },
                            datalabels: {
                                color: '#fff', // Màu sắc cho chữ trên biểu đồ
                                font: {
                                    weight: 'bold', // Đặt font chữ đậm
                                    size: 14, // Kích thước font
                                },
                            },
                        }

                    },
                    plugins: [ChartDataLabels],
                });

            }
            resolve(true)
        });
    }


    //Load biểu đồ chính
    $('.thsl_search').on('change',async function(){
        var namts = $('#thsl_namtuyensinh').val();
        if(namts == 0){
            toastr.warning('Vui lòng chọn Năm tuyển sinh')
        }else{
            var data = await thsl_bieudo_data(1)
            await thsl_bieudo_bar_html()
            await thsl_bieudo_bar_load(data)
        }
    })
    function thsl_bieudo_bar_html(){
        return new Promise(function(resolve,reject){
            $('#thsl_bieudo_bar_load_empty').empty();
            $('#thsl_bieudo_bar_load_empty').append('<canvas id="thsl_bieudo_bar_load" heihgt = "300"></canvas>');
            resolve(true)
        })

    }
    function thsl_bieudo_bar_load(data_bar){
        return new Promise(function(resolve,reject){
            new Chart(document.getElementById('thsl_bieudo_bar_load').getContext('2d'), {
                data: {
                    labels: ['Tổng','Nam','Nữ'],
                    datasets: [
                        {
                            label: 'Đăng ký',
                            data:  data_bar.dangky,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 0',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
                                color: '#fc6183',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },
                        {
                            label: 'Trúng tuyển',
                            data:  data_bar.trungtuyen,
                            backgroundColor: [
                              'rgba(255, 159, 64, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 159, 64)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 1',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
                                color: '#fc6183',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },
                        {
                            label: 'Đang học',
                            data:  data_bar.nhaphoc,
                            backgroundColor: [
                                'rgba(255, 205, 86, 0.2)',
                            ],
                            borderColor: [
                                'rgb(255, 205, 86)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 2',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
                                color: '#fc6183',
                                font: {
                                    weight: 'bold',
                                    size: '13pt'
                                }
                            },
                        },
                        {
                            label: 'Rút HS',
                            data:  data_bar.ruths,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                            ],
                            borderColor: [
                                'rgb(75, 192, 192)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                            stack: 'Stack 3',
                            datalabels: {
                                anchor: 'center',
                                align: 'center',
                                color: '#fc6183',
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
            resolve(true)
        });
    }
    function thsl_excel(){
        var namtn = $('#thsl_namtotnghiep').val() || 0;;
        var tinh = $('#thsl_tinh').val() || 0;;
        var truongthpt = $('#thsl_truongthpt').val() || 0;
        window.open("thsl_excel/0/"+namtn+"/"+tinh+"/"+truongthpt);
    }

































