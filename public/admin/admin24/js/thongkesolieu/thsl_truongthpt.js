$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(window).resize(function() {
        equalizeHeight();
    });
    thsl_tinh_load_index();

})


async function thsl_tinh_load_index(){
    await open_preloader(0);//Mở Preloader (main.js)
    await loadtimkiem_trong() //(main.js)
    await thsl_truong_loadtimkiem();
    // var data = await thsl_tinh_bieudo_truong_data();
    // await thsl_tinh_bieudo_bando_load(data);
    await equalizeHeight(); //Cân bằng 2 block trái và phải (main.js)
    await close_preloader(0); //Tắt Preloader (main.js)
}

function thsl_truong_loadtimkiem(){
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
                $('#thsl_topnhaphoc').val(12)
                resolve(true)
            }
        });
    })
}

//Thong ke theo Trương THPT
function thsl_change_tinh(){
    $('#thsl_truongthpt').empty()
    $('#thsl_truongthpt_toado').attr('id_truong',0)
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

//Thong ke theo Trương THPT
function thsl_tinh_bieudo_truong_data(){
    return new Promise(function(resolve,reject){
        var namts = $('#thsl_namtuyensinh').val() || 0;
        var namtn = $('#thsl_namtotnghiep').val() || 0;
        var tinh = $('#thsl_tinh').val() || 0;
        var top = $('#thsl_topnhaphoc').val()
        var soluong = ($('#thsl_soluong').val() < 0 || $('#thsl_soluong').val() == "")  ? 0 : $('#thsl_soluong').val()
        var truongthpt = $('#thsl_truongthpt').val() || 0;
        var url = "/admin24/thsl_tinh_bieudo_truong_data/"+namts+"/"+namtn+"/"+tinh+"/"+truongthpt+"/0/"+soluong
        $.ajax({
            url: url,
            type: 'get',
            success: function (res) {
                var data = {},truong = {}
                var danghoc = res[0]['truong']['original'].map(item => item.danghoc);
                var trungtuyen = res[0]['truong']['original'].map(item => item.trungtuyen);
                var dangky = res[0]['truong']['original'].map(item => item.dangky);
                var ruths = res[0]['truong']['original'].map(item => item.ruths)


                truong.label = res[0]['truong']['original'].map(item => item.tentruong).slice(0,top)
                truong.dangky = dangky.slice(0,top)
                truong.trungtuyen = trungtuyen.slice(0,top)
                truong.danghoc = danghoc.slice(0,top)
                truong.ruths = ruths.slice(0,top)
                data.truong = truong


                var data_toado =  res[0]['truong']['original']
                var toado = []
                for (let i = 0; i < data_toado.length; i++) {
                    toado.push(
                        {
                            'lon' : data_toado[i].lon,
                            'lat' : data_toado[i].lat,
                            'name' : data_toado[i].tentruong,
                            'dangky' : data_toado[i].dangky,
                            'trungtuyen' : data_toado[i].trungtuyen,
                            'danghoc' : data_toado[i].danghoc,
                            'ruths' : data_toado[i].ruths,
                        })
                }
                data.toado = toado
                var allValues = [...danghoc,...trungtuyen,...dangky]

                // Math.min(...danghoc);  // Lấy giá trị nhỏ nhất
                // Math.max(...danghoc);  // Lấy giá trị lớn nhất
                // Math.min(...trungtuyen);  // Lấy giá trị nhỏ nhất
                // Math.max(...trungtuyen);  // Lấy giá trị lớn nhất
                // Math.min(...dangky);  // Lấy giá trị nhỏ nhất
                // Math.max(...dangky);  // Lấy giá trị lớn nhất



                data.max_value = Math.max(...allValues)
                data.min_value = Math.min(...allValues)
                resolve(data)
            }
        })
    })
}
function thsl_tinh_bieudo_bar_html(){
    return new Promise(function(resolve,reject){
        $('#thsl_tinh_bieudo_bar_empty').empty();
        $('#thsl_tinh_bieudo_bar_empty').append('<canvas id="thsl_tinh_bieudo_bar_load" height = "300"></canvas>');
        resolve(true)
    })
}
function thsl_tinh_bieudo_bar_load(data){
    return new Promise(function(resolve,reject){
        var data_bar = data.truong
        new Chart(document.getElementById('thsl_tinh_bieudo_bar_load').getContext('2d'), {
            data: {
                labels: data_bar.label ,
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
                        data:  data_bar.danghoc,
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
$('.thsl_search').on('change',async function(){
    await thsl_tinh_bieudo_bar_html()
    var data = await thsl_tinh_bieudo_truong_data()
    await thsl_tinh_bieudo_bar_load(data)
    await thsl_tinh_bieudo_bando_load(data);
})
function thsl_truong_excel(){
    var namts =   $('#thsl_namtuyensinh').val();
    if(namts == 0){
        toastr.warning('Chọn Năm tuyển sinh');
    }else{
        var namtn =   $('#thsl_namtotnghiep').val();
        var tinh =   $('#thsl_tinh').val();
        var truong =   $('#thsl_truongthpt').val() || 0;
        window.open("thsl_truong_excel/"+namts+"/"+namtn+"/"+tinh+"/"+truong+'/0/0');
    }
}


    // Thống kê theo map
    $("#thsl_truongthpt_toado").on('click',function(event){
        var id_truong = $(this).attr('id_truong')
        if(id_truong == 0){
            toastr.warning("Chọn Trường THPT")
        }else{
            $.ajax({
                url: "/admin24/thsl_truongthpt_toado/"+id_truong,
                type: 'get',
                success: function (res) {
                    $('#thsl_popup_tentruong').text(res.name_school)
                    $('#thsl_longitude').val(res.lon)
                    $('#thsl_latitude').val(res.lat)
                    // alert(id_truong)
                    var popup = document.getElementById("thsl_truong_popup");
                    var closeBtn = document.querySelector("#thsl_truong_popup .close-btn");
                    // Xác định vị trí click chuột
                    var x = event.clientX;
                    var y = event.clientY;
                    // Hiển thị popup tại vị trí click
                    popup.style.left = x + 'px';
                    popup.style.top = y + 'px';
                    // Hiển thị overlay và popup với hiệu ứng mờ dần
                    popup.style.display = 'block';
                    //Hiệu ứng mở dần
                    setTimeout(function() {
                        popup.style.opacity = 1;
                        popup.style.transform = 'scale(1)';
                    }, 10);
                    //Đóng popup
                    closeBtn.addEventListener("click", function() {
                        popup.style.opacity = 0;
                        popup.style.transform = 'scale(0.9)';
                        setTimeout(function() {
                            popup.style.display = 'none';
                        }, 300);
                    });
                }
            })
        }
    })
    $('#thsl_truongthpt').on('change',function(){
        var id_truong = $(this).val();
        $('#thsl_truongthpt_toado').attr('id_truong',id_truong)
    });
    $('#thsl_truong_popup_sumit').on('click', async function(){
        if( await thsl_truong_popup_sumit() == 1){
            var  data = await thsl_tinh_bieudo_truong_data();
            await thsl_tinh_bieudo_bando_load(data)
        }else{
            $('#map').text('Bản đồ bị lỗi')
        }
    })
    function thsl_truong_popup_sumit(){
        return new Promise(function(resolve,reject){
            var id_truong = $('#thsl_truongthpt').val();
            var longitude =  $('#thsl_longitude').val()
            var latitude =  $('#thsl_latitude').val()
            $.ajax({
                url: "/admin24/thsl_truong_popup_sumit/"+id_truong+'/'+longitude+'/'+latitude,
                type: 'get',
                success: function (res) {
                    toastr.warning(res[1])
                    resolve(1);
                }
            })
        })
    }

    var map, vectorSource;
    function thsl_tinh_bieudo_bando_load(data) {
        return new Promise(function (resolve, reject) {
            fetch('getgeoson')  // Thay thế 'URL_TO_YOUR_API' bằng URL của API thực tế
            .then(response => response.json())
            .then(geoJsonData => {
                var min_value = data.min_value,
                    max_value = data.max_value,
                    min_radius = 3,
                    max_radius = 25;

                    // Kiểm tra nếu bản đồ chưa được tạo
                if (!map) {
                    // Nếu bản đồ chưa tồn tại, khởi tạo mới
                    map = new ol.Map({
                        target: 'map',  // ID của phần tử chứa bản đồ
                        layers: [
                            new ol.layer.Tile({
                                source: new ol.source.OSM()  // Sử dụng OpenStreetMap làm bản đồ nền
                            })
                        ],
                        view: new ol.View({
                            center: ol.proj.fromLonLat([106.5,10]),  // Trung tâm Cần Thơ[ 10.2, 106.5]
                            zoom: 8.3 // Mức zoom
                        }),
                        // controls: []  // Không sử dụng các điều khiển mặc định
                    });

                    // Xóa các tương tác mặc định (bao gồm zoom)
                    // map.getInteractions().clear();

                    // Khởi tạo nguồn dữ liệu vector cho các điểm
                    vectorSource = new ol.source.Vector();

                    // Tạo lớp vector và thêm vào bản đồ
                    var vectorLayer = new ol.layer.Vector({
                        source: vectorSource,
                        style: function (feature) {
                            var dangky = feature.get('dangky');
                            var radius = min_radius + ((dangky - min_value) * (max_radius - min_radius)) / (max_value - min_value);
                            dangky == 0 ? dangky = 0 : radius
                            return new ol.style.Style({
                                image: new ol.style.Circle({
                                    radius: radius,  // Bán kính điểm
                                    fill: new ol.style.Fill(
                                        {
                                            color: 'rgba(255, 99, 132, 0.8) ',  // Màu vàng nhạt (LightYellow)

                                        }
                                    ),  // Màu điểm
                                    // stroke: new ol.style.Stroke({ color: 'white', width: 0.5 })  // Đường viền trắng
                                })
                            });
                        }
                    });

                    // Tạo lớp vector cho trung tuyển
                    var vectorLayer_trungtuyen = new ol.layer.Vector({
                        source: vectorSource,
                        style: function (feature) {
                            var trungtuyen = feature.get('trungtuyen')
                            var radius = min_radius + ((trungtuyen - min_value) * (max_radius - min_radius)) / (max_value - min_value);
                            trungtuyen == 0 ? radius = 0 : radius
                            return new ol.style.Style({
                                image: new ol.style.Circle({
                                    radius: radius,  // Bán kính điểm
                                    fill: new ol.style.Fill(
                                        {
                                            color: 'rgba(255, 140, 0, 1)'
                                            // opacity: 0.6  // Đặt độ trong suốt (opacity)
                                        }
                                    ),  // Màu điểm
                                    // stroke: new ol.style.Stroke({ color: 'white', width: 0.5 })  // Đường viền trắng
                                })
                            });
                        }
                    });

                    var vectorLayer_nhaphoc = new ol.layer.Vector({
                        source: vectorSource,
                        style: function (feature) {
                            var danghoc = feature.get('danghoc')
                            var radius = min_radius + ((danghoc - min_value) * (max_radius - min_radius)) / (max_value - min_value);
                            danghoc == 0 ? radius = 0 : radius
                            return new ol.style.Style({
                                image: new ol.style.Circle({
                                    radius: radius,  // Bán kính điểm
                                    fill: new ol.style.Fill(
                                        {
                                            color: 'rgba(255, 0, 0, 0.5)',  // Màu đỏ gạch (Tomato)
                                            // opacity: 0.8  // Đặt độ trong suốt (opacity)
                                        }
                                    ),  // Màu điểm
                                    // stroke: new ol.style.Stroke({ color: 'white', width: 0.5 })  // Đường viền trắng
                                })
                            });
                        }
                    });

                    // Tạo popup HTML
                    var popupElement = document.createElement('div');
                    popupElement.setAttribute('id', 'popup');
                    document.body.appendChild(popupElement);
                    popupElement.style.backgroundColor = 'white';
                    popupElement.style.border = '1px solid #ccc';
                    popupElement.style.borderRadius = '5px';
                    popupElement.style.padding = '2px';
                    popupElement.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                    popupElement.style.fontSize = '13px';
                    popupElement.style.fontWeight = 'bold';
                    popupElement.style.color = '#333';

                    var popup = new ol.Overlay({
                        element: popupElement,
                        positioning: 'bottom-center',
                        stopEvent: false
                    });
                    map.addOverlay(popup);

                    var popupTimeout;
                    map.on('click', function (evt) {
                        var feature = map.forEachFeatureAtPixel(evt.pixel, function (feature) {
                            return feature;
                        });
                        if (feature && feature.get('dangky')) {
                            var dangky = feature.get('dangky');
                            var trungtuyen = feature.get('trungtuyen');
                            var danghoc = feature.get('danghoc');
                            var truong = feature.get('name');
                            var coordinate = evt.coordinate;
                            popup.setPosition(coordinate);
                            popupElement.innerHTML = '<span>' + truong + "</span><br><span>(ĐK:" + dangky + '-TT:'+trungtuyen+'-NH:'+danghoc+')</span>';
                            clearTimeout(popupTimeout);
                            popupTimeout = setTimeout(function () {
                                popup.setPosition(undefined);
                            }, 2000);
                        } else {
                            popup.setPosition(undefined);
                            clearTimeout(popupTimeout);
                        }
                    });

                    // Tạo lớp vector cho ranh giới tỉnh Cần Thơ
                    var boundaryLayer = new ol.layer.Vector({
                        source: new ol.source.Vector({
                            features: new ol.format.GeoJSON().readFeatures(geoJsonData, {
                                featureProjection: 'EPSG:3857'
                            })
                        }),
                        style: new ol.style.Style({
                            stroke: new ol.style.Stroke({
                                color: 'rgba(0, 0, 255, 1)',  // Viền màu xanh dương
                                width: 0.8
                            }),
                            fill: new ol.style.Fill({
                                color: 'rgba(255, 0, 0, 0)'  // Màu nền trong suốt
                            }),
                        })
                    });
                    map.addLayer(boundaryLayer);  // Thêm lớp boundaryLayer vào bản đồ
                    map.addLayer(vectorLayer);  // Thêm lớp vectorLayer vào bản đồ
                    map.addLayer(vectorLayer_trungtuyen);  // Thêm lớp vectorLayer_trungtuyen vào bản đồ
                    map.addLayer(vectorLayer_nhaphoc);  // Thêm lớp vectorLayer_trungtuyen vào bản đồ
                } else {
                    // Nếu bản đồ đã tồn tại, chỉ cần xóa các điểm cũ trong vectorSource
                    vectorSource.clear();
                }

                    // Thêm các điểm mới từ data.toado vào vectorSource
                var points = data.toado;
                points.forEach(function (point) {
                    var feature = new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.fromLonLat([point.lon, point.lat])),
                        name: point.name,
                        dangky: point.dangky,
                        trungtuyen: point.trungtuyen,
                        danghoc: point.danghoc
                    });
                    vectorSource.addFeature(feature);
                });
                resolve(true);
            })
        });
    }


































