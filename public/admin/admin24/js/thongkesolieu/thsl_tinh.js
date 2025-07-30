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
    thsl_tinh_map_load()

})

    async function thsl_tinh_map_load(){
        await thsl_tinh_loadtimkiem();
        var data = await thsl_tinh_bieudo_tinh_data(data);
        await thsl_tinh_map(data);
    }
    function thsl_tinh_map(data){
        return new Promise(function(resolve,reject){
            var id_tinh = data.map.id_tinh;
            var dangky = data.map.dangky;
            var trungtuyen = data.map.trungtuyen;
            var danghoc = data.map.danghoc;
            var tinh = id_tinh.map((item, index) => {
                return [item, dangky[index], trungtuyen[index], danghoc[index]];
            });

            fetch('/admin24/getgeoson')
            .then(response => response.json())
            .then(data => {
                if (!data || !data.features) {
                        $('#thsl_tinh_map').text('Không tải được dữ liệu bản đồ')
                    return;
                }

                for (let i = 0; i < data.features.length; i++) {
                    const match = tinh.find(item => item[0] === data.features[i].properties.id);
                    if (match) {
                        data.features[i].properties.dangky = match[1];
                        data.features[i].properties.trungtuyen = match[2];
                        data.features[i].properties.danghoc = match[3];
                    }else{
                        data.features[i].properties.dangky = 0;
                        data.features[i].properties.trungtuyen = 0;
                        data.features[i].properties.danghoc = 0;
                    }
                }
                // Khởi tạo bản đồ với Leaflet
                var map = L.map('thsl_tinh_map', {
                    center: [10.2, 106.5], // Vị trí trung tâm
                    zoom: 8.4 // Mức độ zoom
                });
                // // Thêm lớp tile layer từ OpenStreetMap
                // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                // }).addTo(map);

                // Hàm tùy chỉnh style cho các đối tượng trong GeoJSON
                function styleFeature(feature) {
                    return {
                        color: '#2e6da4', // Màu viền xanh đậm (màu xanh dương trung bình)
                        weight: 2, // Độ dày đường viền
                        fillColor: '#e6f7ff', // Màu nền xanh nhạt
                        fillOpacity: 0.5 // Độ trong suốt của nền (giảm để nhìn thấy các chi tiết dưới)
                    };
                }

                // Hàm thêm tên tỉnh vào bản đồ (hiển thị tên tỉnh luôn trên bản đồ)
                function onEachFeature(feature, layer) {
                    var nameVi = feature.properties.Name_VI ? feature.properties.Name_VI.trim() : "";
                    if (nameVi != "") {
                        // Kiểm tra loại hình học (Geometry) và gắn tên tỉnh vào vị trí trung tâm của mỗi tỉnh
                        if (feature.geometry.type === 'Polygon' || feature.geometry.type === 'MultiPolygon') {
                            // Tìm trung tâm của hình đa giác để gắn tên
                            var bounds = layer.getBounds();
                            var center = bounds.getCenter();

                            // Tạo nhãn (label) để hiển thị tên tỉnh tại vị trí trung tâm
                            L.marker(center, {
                                icon: L.divIcon({
                                    className: 'name-label',
                                    html: `
                                        <div style="
                                                    border-radius: 8px;
                                                    padding: 0px;
                                                    font-size: 10px;
                                                    color: #333;
                                                    text-align: center;
                                                    font-weight:bold;
                                                    line-height: 1.4;">
                                            <div style="font-size: 12px;  color: #2e6da4; margin-bottom: 0px;">
                                                ${feature.properties.Name_VI}
                                            </div>
                                           <div style="font-size: 12px;   font-weight:bold; color: red; margin-bottom: 0px;">
                                                (${feature.properties.dangky}/${feature.properties.trungtuyen}/${feature.properties.danghoc})
                                            </div>
                                        </div>
                                    `,
                                    iconSize: [150, 80], // Kích thước nhãn
                                    iconAnchor: [75, 40] // Chỉnh vị trí của nhãn (giữa nhãn)
                                })
                            }).addTo(map);


                        }
                    }
                }

                // Thêm dữ liệu GeoJSON vào bản đồ
                L.geoJSON(data, {
                    style: styleFeature,
                    onEachFeature: onEachFeature // Gọi hàm trên để xử lý từng đối tượng
                }).addTo(map);

            })
            .catch(error => {
                $('#thsl_tinh_map').text('Không tải được dữ liệu bản đồ')

            });
            resolve(true)
        });
    }

    async function thsl_tinh_load_index(){
        await open_preloader(0);//Mở Preloader (main.js)
        await loadtimkiem_trong() //(main.js)
        await thsl_tinh_loadtimkiem();
        // var data = await thsl_tinh_bieudo_truong_data();
        // await thsl_tinh_bieudo_bando_load(data);
        await equalizeHeight(); //Cân bằng 2 block trái và phải (main.js)
        await close_preloader(0); //Tắt Preloader (main.js)
    }
    function thsl_tinh_loadtimkiem(){
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
                    $('#thsl_tinh_namtuyensinh').select2({
                        data: res.dsts_namtuyensinh
                    })
                    var selectedOption2 = $('#thsl_tinh_namtuyensinh').find('option').filter(function() {
                        var year = new Date().getFullYear();
                        return $(this).text() == year; // Kiểm tra giá trị 'value' bằng 2024
                    }).val(); // Lấy text của option
                    $('#thsl_tinh_namtuyensinh').val(selectedOption2).trigger('change');

                    $('#thsl_tinh_namtotnghiep').select2({
                        data: res.dsts_namtotnghiep
                    })
                    $('#thsl_tinh_tinh').select2({
                        data: res.dsts_tinh
                    })
                    $('#thsl_tinh_topnhaphoc').val(6)

                    $('#thsl_tinh_dotts').select2({
                        data: res.dsts_dottuyensinh
                    })
                    $('#thsl_tinh_soluong').val(0)

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
        // await thsl_tinh_bieudo_bando_load(data);
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
        var min_value = data.min_value,
            max_value = data.max_value,
            min_radius = 4,
            max_radius = 18;

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
                    center: ol.proj.fromLonLat([105.7, 9.7421]),  // Trung tâm Cần Thơ
                    zoom: 8.4 // Mức zoom
                }),
                controls: []  // Không sử dụng các điều khiển mặc định
            });

            // Xóa các tương tác mặc định (bao gồm zoom)
            map.getInteractions().clear();

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
                                    color: 'rgba(255, 215, 0, 0.6) ',  // Màu vàng nhạt (LightYellow)

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
        });
    }

    //Thống kê theo Tỉnh/Thành phô
    //Thống kê biểu đồ tròn
    function TotalToArray(arr) {
        var total = arr.reduce((accumulator, currentValue) => accumulator + currentValue, 0);
        // arr.push(total);  // Thêm tổng vào cuối mảng
        return total;
    }

    function thsl_tinh_bieudo_tinh_data(){
        return new Promise(function(resolve,reject){
            var namts = $('#thsl_tinh_namtuyensinh').val() || 0;
            var namtn = $('#thsl_tinh_namtotnghiep').val() || 0;
            var tinh = $('#thsl_tinh_tinh').val() || 0;
            var top = $('#thsl_tinh_topnhaphoc').val()
            var soluong = $('#thsl_tinh_soluong').val()
            // alert(soluong)
            var iddot = $('#thsl_tinh_dotts').val()
            var soluong = ($('#thsl_tinh_soluong').val() < 0 || $('#thsl_tinh_soluong').val() == "")  ? 0 : $('#thsl_tinh_soluong').val()
            var url = "/admin24/thsl_tinh_bieudo_tinh_data/"+namts+"/"+namtn+"/"+tinh+"/0/"+soluong +"/"+iddot
            $.ajax({
                url: url,
                type: 'get',
                success: function (res) {
                    var data = {},tinh = {}, map = {}

                    var tinh = res[0]['tinh']['original'].map(item => item.tentinh);
                    map.label = tinh
                    tinh.label = tinh.slice(0,top);
                    tinh.label.push('Khác')


                    var dangky = res[0]['tinh']['original'].map(item => item.dangky);
                    map.dangky = dangky
                    tinh.dangky = dangky.slice(0,top);
                    var dangky_khac = TotalToArray(dangky) - TotalToArray(tinh.dangky)
                    tinh.dangky.push(dangky_khac)


                    var trungtuyen = res[0]['tinh']['original'].map(item => item.trungtuyen);
                    map.trungtuyen = trungtuyen
                    tinh.trungtuyen = trungtuyen.slice(0,top);
                    var trungtuyen_khac = TotalToArray(trungtuyen) - TotalToArray(tinh.trungtuyen)
                    tinh.trungtuyen.push(trungtuyen_khac)


                    var danghoc = res[0]['tinh']['original'].map(item => item.danghoc);
                    map.danghoc = danghoc
                    tinh.danghoc = danghoc.slice(0,top);
                    var danghoc_khac = TotalToArray(danghoc) - TotalToArray(tinh.danghoc)
                    tinh.danghoc.push(danghoc_khac)



                    var ruths = res[0]['tinh']['original'].map(item => item.ruths);
                    tinh.ruths = ruths.slice(0,top);
                    var ruths_khac = TotalToArray(ruths) - TotalToArray(tinh.ruths)
                    tinh.ruths.push(ruths_khac)

                    var id_tinh = res[0]['tinh']['original'].map(item => item.id_tinh);
                    map.id_tinh = id_tinh
                    tinh.id_tinh = id_tinh.slice(0,top);
                    var id_tinh_khac = 1000
                    tinh.id_tinh.push(id_tinh_khac)

                    // tinh.ruths = res[0]['tinh']['original'].map(item => item.ruths).slice(0,top);
                    data.tinh = tinh
                    data.map = map
                    resolve(data)
                }
            })
        })
    }
    function thsl_tinh_bieudo_tinh_html(){
        return new Promise(function(resolve,reject){
            $('#thsl_tinh_bieudo_tinh_empty').empty();
            $('#thsl_tinh_bieudo_tinh_empty').append('<canvas id="thsl_tinh_bieudo_tinh_load" height = "250"></canvas>');
            resolve(true)
        })
    }
    function thsl_tinh_bieudo_tinh_load(data,check_tile){
        return new Promise(function(resolve,reject){
            var data_bar = data.tinh
            if(check_tile == 1){
              var data_bar = {}
              data_bar.label = data.tinh.label
              var dangky = data.tinh.dangky.map((value, index) => data.tinh.dangky[index] === 0 ? 0 : Math.round((value / data.tinh.dangky[index]) * 10000) / 100)
              data_bar.dangky = dangky
              var trungtuyen = data.tinh.trungtuyen.map((value, index) => data.tinh.dangky[index] === 0 ? 0 : Math.round((value / data.tinh.dangky[index]) * 10000) / 100);
              data_bar.trungtuyen = trungtuyen
              var danghoc = data.tinh.danghoc.map((value, index) => data.tinh.dangky[index] === 0 ? 0 : Math.round((value / data.tinh.dangky[index]) * 10000) / 100);
              data_bar.danghoc = danghoc
              // var tongruths = TotalToArray( data.tinh.ruths)
              var ruths = data.tinh.ruths.map((value, index) => data.tinh.dangky[index] === 0 ? 0 : Math.round((value / data.tinh.dangky[index]) * 10000) / 100);
              data_bar.ruths = ruths
            }
            // data_bar.label.unshift('Tổng');
            // data_bar.dangky.unshift(tongdangky)
            // data_bar.trungtuyen.unshift(tongtrungtuyen)
            // data_bar.danghoc.unshift(tongdanghoc)
            // data_bar.ruths.unshift(tongruths)
            // var tongtrungtuyen = TotalToArray( data_bar.dangky)
            new Chart(document.getElementById('thsl_tinh_bieudo_tinh_load').getContext('2d'), {
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
                                },
                                // formatter: (value, context) => {
                                //     // Kiểm tra nếu đang hover vào cột "Đang học"
                                //     if (context && context.datasetIndex === 1) { // "Đang học" là datasetIndex === 2
                                //         return '50'; // Hiển thị giá trị 50 khi hover vào cột "Đang học"
                                //     }
                                //     return value; // Hiển thị giá trị gốc nếu không phải hover vào "Đang học"
                                // }
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
                                },
                                // formatter: (value, context) => {
                                //     // Nếu đang hover vào cột "Đang học", trả về 50
                                //     if (context.active && context.dataIndex === context.chart.data.datasets[2].data.indexOf(value)) {
                                //         return 50;
                                //     }
                                //     return value; // Trả về giá trị bình thường nếu không phải cột "Đang học"
                                // }
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
                                },
                                // formatter: (value, context) => {
                                //     if(check_tile == 1){
                                //         var  ruths = data_bar.ruths[context.dataIndex];
                                //         var danghoc = data_bar.danghoc[context.dataIndex];
                                //         if (danghoc !== 0) {
                                //             return parseFloat((ruths / danghoc)*100)
                                //         }
                                //         return 0;
                                //     }
                                // }
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
                    },

                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.datasetIndex === 2 && check_tile == 1) {
                                        var nhaphocValue = context.chart.data.datasets[2].data[context.dataIndex]; // Dữ liệu "Nhập học"
                                        var trungtuyenValue = context.chart.data.datasets[1].data[context.dataIndex]; // Dữ liệu "Trúng tuyển"

                                        // Kiểm tra nếu giá trị "Trúng tuyển" khác 0 để tránh chia cho 0
                                        if (trungtuyenValue !== 0) {
                                            var tiLe = (nhaphocValue / trungtuyenValue) * 100;
                                            return `TL lệ nhập học/trúng tuyển: ${tiLe.toFixed(2)}%`;
                                        } else {
                                            return `TL nhập học/trúng tuyển: 0%`;
                                        }
                                    }

                                    if (context.datasetIndex === 3 && check_tile == 1) {
                                        var nhaphocValue = context.chart.data.datasets[3].data[context.dataIndex]; // Dữ liệu "Nhập học"
                                        var trungtuyenValue = context.chart.data.datasets[2].data[context.dataIndex]; // Dữ liệu "Trúng tuyển"

                                        // Kiểm tra nếu giá trị "Trúng tuyển" khác 0 để tránh chia cho 0
                                        if (trungtuyenValue !== 0) {
                                            var tiLe = (nhaphocValue / trungtuyenValue) * 100;
                                            return `TL Rút HS/Nhập học: ${tiLe.toFixed(2)}%`;
                                        } else {
                                            return `TL Rút HS/Nhập học: 0%`;
                                        }
                                    }




                                },
                                // afterLabel: function(context) {
                                //     if (context.datasetIndex === 1 && check_tile == 1) {
                                //     // Thêm thông tin sau label
                                //         return 'Chọn chi tiết thêm nếu cần';
                                //     }
                                // }
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.8)', // màu nền
                            titleColor: '#ffffff', // màu chữ của title
                            bodyColor: '#ffffff', // màu chữ nội dung
                            borderColor: '#ffffff', // viền
                            borderWidth: 1, // độ rộng viền
                        }
                    }

                },
                plugins: [ChartDataLabels],
            });
            resolve(true)
        });
    }
    $('.thsl_tinh_search').on('change',async function(){
        await thsl_tinh_bieudo_tinh_html()
        var data = await thsl_tinh_bieudo_tinh_data()
        await thsl_tinh_bieudo_pie_load(data)
        var data = await thsl_tinh_bieudo_tinh_data()
        var tl = $('#thsl_tinh_check_tile_tl').prop('checked');
        var check_tile = 0;
        if(tl == true){
             check_tile = 1;
        }
        await thsl_tinh_bieudo_tinh_load(data,check_tile)
    })
    function thsl_tinh_excel(){
        var namts =   $('#thsl_tinh_namtuyensinh').val();
        if(namts == 0){
            toastr.warning('Chọn Năm tốt nghiệp');
        }else{
            var namtn =   $('#thsl_tinh_namtotnghiep').val();
            var tinh =   $('#thsl_tinh_tinh').val();
            window.open("thsl_tinh_excel/"+namts+"/"+namtn+"/"+tinh+'/0/0');
        }
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
    function thsl_tinh_bieudo_pie_load(data_pie){
        return new Promise(function(resolve,reject){
            var color = data_pie.tinh.label.map(() => `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 1)`); // Màu ngẫu nhiên
            var danghoc = data_pie.tinh.danghoc;
            var total = danghoc.reduce((sum, value) => sum + value, 0);
            var danghocPercentage = data_pie.tinh.danghoc.map(value => ((value / total) * 100).toFixed(2)); // toFixed(2) để giới hạn phần trăm đến 2 chữ số thập phân
            $('#thsl_tinh_bieudo_pie_load').empty();
            $('#thsl_tinh_bieudo_pie_load').append('<canvas id="thsl_tinh_bieudo_pie_load_canvas" height="180px" style="height: 180px; display: block;"></canvas></div>')
            new Chart(document.getElementById('thsl_tinh_bieudo_pie_load_canvas').getContext('2d'), {
                type: 'pie', // Xác định loại biểu đồ là pie
                data: {
                    labels: data_pie.tinh.label, // Các nhãn của biểu đồ
                    datasets: [{
                        // label: tentinh,
                        data: danghocPercentage, // Dữ liệu cho từng phần của pie
                        backgroundColor: color
                        // hoverOffset: 4 // Khoảng cách khi hover
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Tắt giữ tỉ lệ khung hình cố định
                    plugins: {
                        legend: {
                            position: 'left', // Vị trí của legend
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


            var dangky = data_pie.tinh.dangky;
            var total = dangky.reduce((sum, value) => sum + value, 0);
            var ddangkyPercentage = data_pie.tinh.dangky.map(value => ((value / total) * 100).toFixed(2)); // toFixed(2) để giới hạn phần trăm đến 2 chữ số thập phân
            $('#thsl_tinh_bieudodangky_pie_load').empty();
            $('#thsl_tinh_bieudodangky_pie_load').append('<canvas id="thsl_tinh_bieudodangky_pie_load_canvas" height="180px" style="height: 180px; display: block;"></canvas></div>')
            new Chart(document.getElementById('thsl_tinh_bieudodangky_pie_load_canvas').getContext('2d'), {
                type: 'pie', // Xác định loại biểu đồ là pie
                data: {
                    labels: data_pie.tinh.label, // Các nhãn của biểu đồ
                    datasets: [{
                        // label: tentinh,
                        data: ddangkyPercentage, // Dữ liệu cho từng phần của pie
                        backgroundColor: color
                        // hoverOffset: 4 // Khoảng cách khi hover
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Tắt giữ tỉ lệ khung hình cố định
                    plugins: {
                        legend: {
                            position: 'left', // Vị trí của legend
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



            var trungtuyen = data_pie.tinh.trungtuyen;
            var total = trungtuyen.reduce((sum, value) => sum + value, 0);
            var trungtuyenPercentage = data_pie.tinh.trungtuyen.map(value => ((value / total) * 100).toFixed(2)); // toFixed(2) để giới hạn phần trăm đến 2 chữ số thập phân
            $('#thsl_tinh_bieudotrungtuyen_pie_load').empty();
            $('#thsl_tinh_bieudotrungtuyen_pie_load').append('<canvas id="thsl_tinh_bieudotrungtuyen_pie_load_canvas" height="180px" style="height: 180px; display: block;"></canvas></div>')


            new Chart(document.getElementById('thsl_tinh_bieudotrungtuyen_pie_load_canvas').getContext('2d'), {
                type: 'pie', // Xác định loại biểu đồ là pie
                data: {
                    labels: data_pie.tinh.label, // Các nhãn của biểu đồ
                    datasets: [{
                        // label: tentinh,
                        data: trungtuyenPercentage, // Dữ liệu cho từng phần của pie
                        backgroundColor: color
                        // hoverOffset: 4 // Khoảng cách khi hover
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Tắt giữ tỉ lệ khung hình cố định
                    plugins: {
                        legend: {
                            position: 'left', // Vị trí của legend
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





            resolve(true)
        });
    }








    // function thsl_tinh_bieudo_map(data_map){
    //     alert(111111111)
    //     fetch('/admin24/getgeoson')
    //     .then(response => response.json())
    //     .then(data => {
    //         // Kiểm tra xem có dữ liệu GeoJSON không
    //         if (!data || !data.features) {
    //                 $('#thsl_tinh_map').text('Không tải được dữ liệu bản đồ')
    //             return;
    //         }


    //         // Khởi tạo bản đồ với Leaflet
    //         var map = L.map('thsl_tinh_map', {
    //             center: [10, 106], // Vị trí trung tâm
    //             zoom: 8.5 // Mức độ zoom
    //         });

    //         // // Thêm lớp tile layer từ OpenStreetMap
    //         // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //         //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    //         // }).addTo(map);

    //         // Hàm tùy chỉnh style cho các đối tượng trong GeoJSON
    //         function styleFeature(feature) {
    //             return {
    //                 color: feature.properties.fillColor || 'red', // Mặc định màu viền là đỏ nếu không có thuộc tính
    //                 fillOpacity: 0.5
    //             };
    //         }

    //         // Hàm thêm tên tỉnh vào bản đồ (hiển thị tên tỉnh luôn trên bản đồ)
    //         function onEachFeature(feature, layer) {
    //             if (feature.properties && feature.properties.Name_EN) {
    //                 // Kiểm tra loại hình học (Geometry) và gắn tên tỉnh vào vị trí trung tâm của mỗi tỉnh
    //                 if (feature.geometry.type === 'Polygon' || feature.geometry.type === 'MultiPolygon') {
    //                     // Tìm trung tâm của hình đa giác để gắn tên
    //                     var bounds = layer.getBounds();
    //                     var center = bounds.getCenter();

    //                     // Tạo nhãn (label) để hiển thị tên tỉnh tại vị trí trung tâm
    //                     L.marker(center, {
    //                         icon: L.divIcon({
    //                             className: 'name-label',
    //                             html: feature.properties.Name_EN, // Hiển thị tên tỉnh
    //                             iconSize: [100, 40], // Kích thước nhãn
    //                             iconAnchor: [50, 20] // Chỉnh vị trí của nhãn
    //                         })
    //                     }).addTo(map);
    //                 }
    //             }
    //         }

    //         // Thêm dữ liệu GeoJSON vào bản đồ
    //         L.geoJSON(data, {
    //             style: styleFeature,
    //             onEachFeature: onEachFeature // Gọi hàm trên để xử lý từng đối tượng
    //         }).addTo(map);
    //     })
    //     .catch(error => {
    //         $('#thsl_tinh_map').text('Không tải được dữ liệu bản đồ')
    //     });
    // }





























