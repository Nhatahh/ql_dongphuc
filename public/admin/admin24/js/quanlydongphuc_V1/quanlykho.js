

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // adjustView();
    $("#dotnhap_thongkekho_search").select2();
    $("#trangthai_thongkekho_search").select2();
    $("#loai_thongkekho_search").select2();
    $("#size_thongkekho_search").select2();
    $("#nsx_thongkekho_search").select2();
    select2_hoadon_search();
    // // window.addEventListener('resize', adjustView);
    $('#ds_kho_filter').hide()
    bieudo_hoadon_kho();
    ds_kho()
});
//Danh sách đồng phục
function ds_kho(){
    // return new Promise(function(resolve, reject) {
        var ds_kho = $("#ds_kho").DataTable({
            ajax: {
                type: "GET",
                url: "/admin24/ds_kho",
                data:  {
                    loai:null,
                    dotnhap:null,
                    size:null,
                    nsx:null,
                    trangthai:null,
                }
            },
            columns: [
                {
                    title: "STT",
                    data: "stt",
                    width:"5%",
                    className: 'remove_click text-center',
                },
                {
                    title: "<div style='text-align: center;'>Loại</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_loai' onkeyup='search_loai()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                    data: "loai",
                    className: 'remove_click text-left',
                },
                {
                    title: "<div style='text-align: center;'>Size</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_size' onkeyup='search_size()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                    data: "size",
                    width:"10%",
                    className: 'remove_click text-center',
                },
                {
                    title: "<div style='text-align: center;'>Nhà sản xuất</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_nsx' onkeyup='search_nsx()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                    data: "nsx",
                    className: 'remove_click text-left',
                },

                {
                    title: "<div style='text-align: center;'>Đợt nhập</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_dotnhap' onkeyup='search_dotnhap()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                    data: "dotnhap",
                    className: 'remove_click text-left',

                },
                {
                    title: "<div style='text-align: center;'>SL tồn</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_slton' onkeyup='search_slton()' class='form-control' style='width:90%;height:22px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
                    data: "slton",
                    width:"5%",
                    className: 'remove_click text-center',
                },
                {
                    title: "Trạng thái",
                    data: "id",
                    width:"10%",
                    className: 'timkiem_thisinh text-center remove_click',
                    render: function(data, type, row) {
                        var html=""
                        if(row.trangthai==0){
                            html+= '<input checked class="check_trangthai"  onclick=change_trangthai_kho("'+data+'","'+row.trangthai+'") style="height:13px" id_kho="'+data+'" type="checkbox">'
                        }else{
                            html+= '<input class="check_trangthai"  onclick=change_trangthai_kho("'+data+'","'+row.trangthai+'") style="height:13px" id_kho="'+data+'" type="checkbox">'
                        }
                        return html;
                    }
                }
            ],
            language: {
                emptyTable: "Không tìm thấy hóa đơn",
                info: " _START_ / _END_ trên _TOTAL_ hóa đơn",
                paginate: {
                    first: "Trang đầu",
                    last: "Trang cuối",
                    next: "Trang sau",
                    previous: "Trang trước"
                },
                search: "Tìm kiếm:",
                loadingRecords: "Đang tìm kiếm ... ",
                lengthMenu: "Hiện thị _MENU_ hóa đơn",
                infoEmpty: "",
            },
            retrieve: true,
            paging: false,
            lengthChange: false,
            searching: true,
            ordering: false,
            info: false,
            autoWidth: false,
            responsive: true,
            scrollY: 380,
        });
    //     resolve(ds_kho)
    // });
    return ds_kho;
}

//Tìm kiếm
async function search_kho() {
    // Lấy giá trị từ các trường select2
    var dotnhap = $('#dotnhap_thongkekho_search').val();
    var trangthai = $('#trangthai_thongkekho_search').val();
    var loai = $('#loai_thongkekho_search').val();
    var size = $('#size_thongkekho_search').val();
    var nsx = $('#nsx_thongkekho_search').val();
    // ds_kho().ajax.url('/admin24/ds_kho').load();
    // Gửi Ajax request đến server với các giá trị từ select2
    const response = await $.ajax({
        url: '/admin24/ds_kho',
        type: 'GET',
        data: {
            dotnhap: dotnhap,
            trangthai: trangthai,
            loai: loai,
            size: size,
            nsx: nsx
        },
    });

    // Kiểm tra response và cập nhật lại DataTables
    var table = $('#ds_kho').DataTable();
    table.clear().rows.add(response.data).draw();  // Cập nhật lại DataTables với dữ liệu mới

}
//Search for column
function search_loai() {
    var value = $('#search_loai').val()
    ds_kho.column(1).search(value).draw();
}
function search_size() {
    var value = $('#search_size').val()
    ds_kho.column(2).search(value).draw();
}
function search_nsx() {
    var value = $('#search_nsx').val()
    ds_kho.column(3).search(value).draw();
}
function search_dotnhap() {
    ds_kho.column(4).search(value = $('#search_dotnhap').val()).draw();
}
function search_slton() {
    ds_kho.column(5).search(value = $('#search_slton').val()).draw();
}
//data select 2
function select2_hoadon_search(){
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: 'get',
            url: '/admin24/select2_hoadon_search',
            success: function(res) {



                $('#trangthai_thongkekho_search').val(-1).trigger('change');
                $("#trangthai_thongkekho_search").select2({ data: res.select_trangthai });

                $('#dotnhap_thongkekho_search').val(0).trigger('change');
                $("#dotnhap_thongkekho_search").select2({ data: res.select_dotnhap });


                $('#loai_thongkekho_search').val(0).trigger('change');
                $("#loai_thongkekho_search").select2({ data: res.select_loai });

                $('#size_thongkekho_search').val(0).trigger('change');
                $("#size_thongkekho_search").select2({ data: res.select_size });

                $('#nsx_thongkekho_search').val(0).trigger('change');
                $("#nsx_thongkekho_search").select2({ data: res.select_nhasanxuat });
                // bieudo_hoadon_kho()
                resolve(1)
            }
        });
    });
}
//Button phát sản phẩm
function in_hoadon(mahoadon){
    window.open("in_hoadon/"+mahoadon, "_blank");
}
async function xoa_hoadon(mahoadon){
    var pri = confirm("Có muốn xóa hóa đơn ?!")
    if (pri == true){
        $('#modal_event').show();
        const check = await laythongtincheckquyen(3);
        $.ajax({
            type: 'post',
            url: '/admin24/xoa_hoadon/'+mahoadon,
            data: {
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 3,
                active: 1,
            },
            success: function(res) {
                $('#modal_event').hide();
                if(res.trangthai==1){
                    Livewire.emit('refreshComponent');
                    thongbao(res.noidung);
                    ds_hoadon.ajax.reload();
                }else{
                    thongbao(res.noidung);
                }
            }
        });
    }
}
function adjustView() {

    var nhapMobile = document.getElementsByClassName('qlhd_mobile');
    var nhapPc = document.getElementsByClassName('qlhd_pc');
    // phatdongphuc_timkiem()
    if (window.innerWidth <= 567) {
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'block';
        }
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'none';
        }
    } else {
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'block';
        }
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'none';
        }
    }
}
//Đổi trạng thái
async function change_trangthai_kho(id,trangthai){
    var pri=""
    if(trangthai==0){
        pri = confirm("Sản phẩm sẽ ngưng hoạt động ?!")
    }else{
        pri = confirm("Sản phẩm sẽ được hoạt động lại ?!")
    }
    if (pri == true){
        $('#modal_event').show();
        const check = await laythongtincheckquyen(4);
        $.ajax({
            type: 'post',
            url: '/admin24/change_trangthai_kho',
            data: {
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 3,
                active: 1,
                id: id,
                trangthai: trangthai,
            },
            success: function(res) {
                $('#modal_event').hide();
                if(res.trangthai==1){
                    thongbao(res.noidung);
                    ds_kho.ajax.reload();
                }else{
                    thongbao(res.noidung);
                }
            }
        });
    }
}
//Biểu đồ
function laydieukien(){
    return new Promise(function(resolve, reject) {
        var dotnhap = $('#dotnhap_thongkekho_search').val();
        var trangthai = $('#trangthai_thongkekho_search').val();
        var loai = $('#loai_thongkekho_search').val();
        var size = $('#size_thongkekho_search').val();
        var nsx = $('#nsx_thongkekho_search').val();
        var res={
            'dotnhap':dotnhap,
            'trangthai':trangthai,
            'loai':loai,
            'size':size,
            'nsx':nsx,
        }
        resolve(res)
    });
}

function roundUpToNearestEven(value) {
    return Math.ceil(value / 100) * 100; // Làm tròn lên đến bội số của 100
}

// Hàm chính để tính toán
function calculateAndRound(value) {
    // Cộng thêm 20%
    let increasedValue = value * 1.175; // Tăng thêm 20%

    // Làm tròn lên đến bội số chẵn (100)
    return roundUpToNearestEven(increasedValue);
}

function bieudo_hoadon_kho(a){
    return new Promise(function(resolve, reject) {
        ds_kho().ajax.url('/admin24/ds_kho').load();
        var dotnhap = $('#dotnhap_thongkekho_search').val();
        var trangthai = $('#trangthai_thongkekho_search').val();
        var loai = $('#loai_thongkekho_search').val();
        var size = $('#size_thongkekho_search').val();
        var nsx = $('#nsx_thongkekho_search').val();
        var sizeColors = {
            "S": "#FF6384",
            "M": "#36A2EB",
            "L": "#FFCE56",
            "XL": "#4BC0C0",
            "2XL": "#9966FF",
            "3XL": "#FF9F40",
            "4XL": "#FF9999",
            "5XL": "#66FF66",
            "6XL": "#FF6666",
            "7XL": "#33CCFF",
            "8XL": "#CC99FF",
            "9XL": "#FFCC99",
            "10XL": "#FF9999",
            "11XL": "#66CCFF",
            "12XL": "#CCFF99"
        };

        $.ajax({
            url: "/admin24/ds_kho",
            type: 'get',
            data: {
                dotnhap: dotnhap,
                trangthai: trangthai,
                loai: loai,
                size: size,
                nsx: nsx

            },
            success: function (res) {
                $("#modal_bieudo_thongke_kho").show();

                // Xóa biểu đồ cũ nếu có
                if (window.myChart) {
                    window.myChart.destroy();
                }

                // Khởi tạo dữ liệu
                var loaiNsxLabels = [];
                var sizeData = {};
                var data = res.data;
                var max_slton = 0;
                var min_slton = 0;
                // Lấy danh sách kết hợp giữa loại sản phẩm và nhà sản xuất
                data.forEach(item => {
                    var label = `${item.loai} - ${item.nsx}`;
                    if (!loaiNsxLabels.includes(label)) {
                        loaiNsxLabels.push(label);
                    }
                    if (!sizeData[label]) {
                        sizeData[label] = {};
                    }
                    if (!sizeData[label][item.size]) {
                        sizeData[label][item.size] = 0;
                    }
                    sizeData[label][item.size] += parseInt(item.slton, 10);// Chuyển đổi sang số nguyên
                    max_slton = Math.max(max_slton, sizeData[label][item.size]);
                    min_slton = Math.min(min_slton, sizeData[label][item.size]);
                });
                // Tạo datasets cho các kích thước có dữ liệu
                var datasets = [];
                var sizeLabels = Object.keys(sizeColors); // Tất cả kích thước cố định

                max_slton = calculateAndRound(max_slton);
                min_slton = calculateAndRound(min_slton);
                sizeLabels.forEach(size => {
                    var dataForSize = loaiNsxLabels.map(label => sizeData[label] && sizeData[label][size] || 0);
                    var hasData = dataForSize.some(value => value > 0);

                    if (hasData) {
                        datasets.push({
                            label: size,
                            data: dataForSize,
                            backgroundColor: sizeColors[size] || "#CCCCCC", // Màu sắc cố định hoặc màu mặc định
                        });
                    }
                });

                // Vẽ biểu đồ

                // var ctx = document.getElementById('dongphuc_kho-chart-canvas').getContext('2d');
                var element = document.getElementById('dongphuc_kho-chart-canvas');

                if (element) {
                    // Phần tử tồn tại, bạn có thể tiếp tục lấy context
                    var ctx = element.getContext('2d');
                    window.myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: loaiNsxLabels,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,  // Cho phép tùy chỉnh kích thước
                            animation: {
                                duration: 1000, // Thời gian hoạt ảnh (ms)
                                easing: 'easeInOutBack' // Kiểu hoạt ảnh
                            },
                            layout: {
                                padding: {
                                top: 0, // Khoảng cách từ trên xuống (giữa biểu đồ và legend)
                                bottom: 0, // Khoảng cách từ dưới lên
                                left: 0,
                                right: 0
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                    labels: {
                                        color: 'black',
                                        font: {
                                            size: 15
                                        },
                                    }
                                },
                                datalabels: {
                                    color: 'black',
                                    display: false,
                                    anchor: 'end',
                                    align: 'top',
                                    formatter: function(value) {
                                        return value > 0 ? value : ''; // Hiển thị giá trị chỉ khi lớn hơn 0
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    stacked: false,
                                    title: {
                                        display: true,
                                        text: 'Loại sản phẩm - Nhà sản xuất'
                                    }
                                },
                                y: {
                                    stacked: false,
                                    title: {
                                        display: true,
                                        text: 'Tổng SL'
                                    },
                                    minBarLength: 10,
                                    min: min_slton,
                                    max:max_slton
                                }
                            }
                        },
                        plugins: [ChartDataLabels] // Đảm bảo plugin được đưa vào
                    });
                    resolve(ctx)
                }
            },
        // });
        });
    });
}




async function bieudo_kho () {
    select2_hoadon_search();
     bieudo_hoadon_kho()
}

function close_bieudo_thongke_kho(){
    $("#modal_bieudo_thongke_kho").hide();

}

function btt_excel_kho(){
   // Lấy giá trị từ các trường tìm kiếm
   var dotnhap = $('#dotnhap_thongkekho_search').val();
   var trangthai = $('#trangthai_thongkekho_search').val();
   var loai = $('#loai_thongkekho_search').val();
   var size = $('#size_thongkekho_search').val();
   var nsx = $('#nsx_thongkekho_search').val();
    $.ajax({
        url: '/admin24/btt_excel_kho',
        type: 'GET',
        data: {
            dotnhap: dotnhap,
            trangthai: trangthai,
            loai: loai,
            size: size,
            nsx: nsx
        },
        success: function(res) {
            var form = $('<form>', {
                method: 'GET',
                action: '/admin24/btt_excel_kho',
                target: '_blank'
            });
            // Thêm các tham số vào form
            form.append($('<input>', { type: 'hidden', name: 'dotnhap', value: dotnhap }));
            form.append($('<input>', { type: 'hidden', name: 'trangthai', value: trangthai }));
            form.append($('<input>', { type: 'hidden', name: 'loai', value: loai }));
            form.append($('<input>', { type: 'hidden', name: 'size', value: size }));
            form.append($('<input>', { type: 'hidden', name: 'nsx', value: nsx }));
            // Thêm form vào body và gửi
            $('body').append(form);
            form.submit();
            form.remove();
        }
    });
}

async function clear_kho(){

    // Gửi Ajax request đến server với các giá trị từ select2

    await select2_hoadon_search()
    await bieudo_hoadon_kho()

    // const response = await $.ajax({
    //     url: '/admin24/ds_kho',
    //     type: 'GET',
    // });
    // ds_kho().ajax.url("/admin24/import_loadnguyenvongxettuyen/"+dotts).load();
}
