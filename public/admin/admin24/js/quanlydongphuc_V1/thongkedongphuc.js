$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    select2_hoadon_search()
    $('#ds_thongke_phat_filter').hide()
});
//data select 2
function select2_hoadon_search(){
    
    $.ajax({
        type: 'get',
        url: '/admin24/select2_hoadon_search',
        success: function(res) {
            $("#dotphat_thongkehoadon_search").select2({ data: res.select_dotphat });
            $("#trangthai_thongkehoadon_search").select2();
            $("#loai_thongkehoadon_search").select2({ data: res.select_loai });
            $("#size_thongkehoadon_search").select2({ data: res.select_size });
            $("#nsx_thongkehoadon_search").select2({ data: res.select_nhasanxuat });
        }
    });
}
//Table
function ds_thongke_phat(){
    var myDataTable = $("#ds_thongke_phat").DataTable({
        processing: true,
        // serverSide: true,
        deferRender: true,
        ajax: "/admin24/timkiem_hoadon",
        columns: [
            {
                title: "Mã hóa đơn",
                data: "mahoadon",
                className: 'remove_click',
            },
            {
                title: "Đợt phát",
                data: "dot_phat",
                className: 'remove_click text-left',
            },
            {
                title: "Ngày phát",
                data: "ngaytao",
                className: 'remove_click text-left',
            },
            {
                title: "Tên sinh viên",
                data: "hoten_sv",
                className: 'remove_click text-left',
            },
            {
                title: "CCCD",
                data: "cccd",
                className: 'remove_click text-left',
            },
            {
                title: "Loại đồng phục",
                data: "loai",
                className: 'remove_click text-left',
            },
            {
                title: "Size ",
                data: "size",
                className: 'remove_click text-left',
            },
            {
                title: "Nhà sản xuất",
                data: "nsx",
                className: 'remove_click text-left',
            },
            {
                title: "SL",
                data: "sl_phat",
                className: 'remove_click text-left',
            },
            {
                title: "Đợt nhập",
                data: "dot_nhap",
                className: 'remove_click text-left',
            },
            {
                title: "Trạng thái",
                data: "trangthai",
                className: 'remove_click text-left',
                render: function(data, type, row) {
                    if (data == 1) {
                        return 'Đã xóa';
                    } else {
                        return '';
                    }
                }
            }
        ],
        // columnDefs: [
        //     {
        //         targets: [0,2,3,4,6,7,8,9],
        //         orderable: false,
        //         className: "text-center"
        //     },
        //     {
        //         targets: [10,11],
        //         className: "text-center"
        //     },
        // ],
        scrollY: 400,
        language: {
            emptyTable: "Không tìm thấy danh sách",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "Hiện thị _MENU_",
            infoEmpty: "",
        },
        retrieve: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
    return myDataTable;
}
var ds_thongke_phat = $("#ds_thongke_phat").DataTable({
    processing: true,
    
    // serverSide: true,
    deferRender: true,
    ajax: {
        type: "GET",
        url: "/admin24/timkiem_hoadon",
        dataSrc: 'data'
    },
    columns: [
        {
            title: "Mã hóa đơn",
            data: "mahoadon",
            className: 'remove_click',
        },
        {
            title: "Đợt phát",
            data: "dot_phat",
            className: 'remove_click text-left',
        },
        {
            title: "Ngày phát",
            data: "ngaytao",
            className: 'remove_click text-left',
        },
        {
            title: "Tên sinh viên",
            data: "hoten_sv",
            className: 'remove_click text-left',
        },
        {
            title: "CCCD",
            data: "cccd",
            className: 'remove_click text-left',
        },
        {
            title: "Loại đồng phục",
            data: "loai",
            className: 'remove_click text-left',
        },
        {
            title: "Size ",
            data: "size",
            className: 'remove_click text-left',
        },
        {
            title: "Nhà sản xuất",
            data: "nsx",
            className: 'remove_click text-left',
        },
        {
            title: "SL",
            data: "sl_phat",
            className: 'remove_click text-left',
        },
        {
            title: "Đợt nhập",
            data: "dot_nhap",
            className: 'remove_click text-left',
        },
        {
            title: "Trạng thái",
            data: "trangthai",
            className: 'remove_click text-left',
            render: function(data, type, row) {
                if (data == 1) {
                    return 'Đã xóa';
                } else {
                    return '';
                }
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
    scrollY: 360,
});
//Seaarch 
function bat_validate(){
    var mahoadon = $("#mahoadon_thongkehoadon_search").val();
    var cccd = $("#cccd_thongkehoadon_search").val();
    $.ajax({
        url: "/admin24/bat_validate",
        type: 'get',
        data:{
            mahoadon: mahoadon,
            cccd: cccd,
        },
        success: function (res) {
            if(res.status==0 ){
                var keys = Object.keys(res['noidung']['original'])
                for(let i = 0; i<keys.length; i++){
                    toastr.warning(res['noidung']['original'][keys[i]][0]);
                }
            }else{
                var dotphat = $("#dotphat_thongkehoadon_search").val();
                var loai = $("#loai_thongkehoadon_search").val();
                var mahoadon = $("#mahoadon_thongkehoadon_search").val();
                var size = $("#size_thongkehoadon_search").val();
                var nsx = $("#nsx_thongkehoadon_search").val();
                var trangthai = $("#trangthai_thongkehoadon_search").val();
                var end = $("#end_thongkehoadon_search").val();
                var cccd = $("#cccd_thongkehoadon_search").val();
                var start = $("#start_thongkehoadon_search").val();
                $.ajax({
                    url: "/admin24/timkiem_hoadon",
                    type: 'get',
                    data:{
                        dotphat: dotphat,
                        mahoadon: mahoadon,
                        loai: loai,
                        size: size,
                        nsx: nsx,
                        trangthai: trangthai,
                        cccd: cccd,
                        end: end,
                        start: start
                    },
                    success: function (res1) {
                        ds_thongke_phat.clear(); // Xóa dữ liệu cũ trong DataTables
                        ds_thongke_phat.rows.add(res1.data); // Thêm dữ liệu mới
                        ds_thongke_phat.draw(); // Vẽ lại bảng
                    }
                });
            }
        }
    });
}
function btt_excel_hdphat(){
    var dotphat = $("#dotphat_thongkehoadon_search").val();
    var mahoadon = $("#mahoadon_thongkehoadon_search").val();
    var loai = $("#loai_thongkehoadon_search").val();
    var size = $("#size_thongkehoadon_search").val();
    var nsx = $("#nsx_thongkehoadon_search").val();
    var trangthai = $("#trangthai_thongkehoadon_search").val();
    var cccd = $("#cccd_thongkehoadon_search").val();
    var end = $("#end_thongkehoadon_search").val();
    var start = $("#start_thongkehoadon_search").val();

    $.ajax({
        url: '/admin24/btt_excel_hdphat',
        type: 'GET',
        data: {
            dotphat: dotphat,
            mahoadon: mahoadon,
            loai: loai,
            size: size,
            nsx: nsx,
            trangthai: trangthai,
            cccd: cccd,
            end: end,
            start: start
        },
        success: function(res) {
            // Kiểm tra nếu có lỗi validate từ phía server
            if (res.status === 0) {
                var keys = Object.keys(res['noidung']['original'])
                for(let i = 0; i<keys.length; i++){
                    toastr.warning(res['noidung']['original'][keys[i]][0]);
                }
            } else {
                // Nếu không có lỗi, mở file excel trong tab mới
                var form = $('<form>', {
                    method: 'GET',
                    action: '/admin24/btt_excel_hdphat',
                    target: '_blank'
                });
                // Thêm các tham số vào form
                form.append($('<input>', { type: 'hidden', name: 'dotphat', value: dotphat }));
                form.append($('<input>', { type: 'hidden', name: 'mahoadon', value: mahoadon }));
                form.append($('<input>', { type: 'hidden', name: 'loai', value: loai }));
                form.append($('<input>', { type: 'hidden', name: 'size', value: size }));
                form.append($('<input>', { type: 'hidden', name: 'nsx', value: nsx }));
                form.append($('<input>', { type: 'hidden', name: 'trangthai', value: trangthai }));
                form.append($('<input>', { type: 'hidden', name: 'cccd', value: cccd }));
                form.append($('<input>', { type: 'hidden', name: 'end', value: end }));
                form.append($('<input>', { type: 'hidden', name: 'start', value: start }));
                // Thêm form vào body và gửi
                $('body').append(form);
                form.submit();
                form.remove();
            }
        }
    });
}
function btt_excel_thongke_hd_phat(){
    var dotphat = $("#dotphat_thongkehoadon_search").val();
    var mahoadon = $("#mahoadon_thongkehoadon_search").val();
    var loai = $("#loai_thongkehoadon_search").val();
    var size = $("#size_thongkehoadon_search").val();
    var nsx = $("#nsx_thongkehoadon_search").val();
    var trangthai = $("#trangthai_thongkehoadon_search").val();
    var cccd = $("#cccd_thongkehoadon_search").val();
    var end = $("#end_thongkehoadon_search").val();
    var start = $("#start_thongkehoadon_search").val();
    $.ajax({
        url: '/admin24/btt_excel_thongke_hd_phat',
        type: 'GET',
        data: {
            dotphat: dotphat,
            mahoadon: mahoadon,
            loai: loai,
            size: size,
            nsx: nsx,
            trangthai: trangthai,
            cccd: cccd,
            end: end,
            start: start
        },
        success: function(res) {
            // Kiểm tra nếu có lỗi validate từ phía server
            if (res.status === 0) {
                // Hiển thị thông báo lỗi
                var keys = Object.keys(res['noidung']['original'])
                for(let i = 0; i<keys.length; i++){
                    toastr.warning(res['noidung']['original'][keys[i]][0]);
                }
            } else {
                // Nếu không có lỗi, mở file excel trong tab mới
                var form = $('<form>', {
                    method: 'GET',
                    action: '/admin24/btt_excel_thongke_hd_phat',
                    target: '_blank'
                });
                // Thêm các tham số vào form
                form.append($('<input>', { type: 'hidden', name: 'dotphat', value: dotphat }));
                form.append($('<input>', { type: 'hidden', name: 'mahoadon', value: mahoadon }));
                form.append($('<input>', { type: 'hidden', name: 'loai', value: loai }));
                form.append($('<input>', { type: 'hidden', name: 'size', value: size }));
                form.append($('<input>', { type: 'hidden', name: 'nsx', value: nsx }));
                form.append($('<input>', { type: 'hidden', name: 'trangthai', value: trangthai }));
                form.append($('<input>', { type: 'hidden', name: 'cccd', value: cccd }));
                form.append($('<input>', { type: 'hidden', name: 'end', value: end }));
                form.append($('<input>', { type: 'hidden', name: 'start', value: start }));
                // Thêm form vào body và gửi
                $('body').append(form);
                form.submit();
                form.remove();
            }
        }
    });
}
//Biểu đồ
function bieudo_hoadon_phat() {
    // Lấy giá trị từ các trường tìm kiếm
    var dotphat = $("#dotphat_thongkehoadon_search").val();
    var mahoadon = $("#mahoadon_thongkehoadon_search").val();
    var loai = $("#loai_thongkehoadon_search").val();
    var size = $("#size_thongkehoadon_search").val();
    var nsx = $("#nsx_thongkehoadon_search").val();
    var trangthai = $("#trangthai_thongkehoadon_search").val();
    var cccd = $("#cccd_thongkehoadon_search").val();
    var end = $("#end_thongkehoadon_search").val();
    var start = $("#start_thongkehoadon_search").val();

    // Màu cố định cho các kích thước từ S đến 12XL
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
        url: "/admin24/bieudo_hoadon_phat",
        type: 'get',
        data: {
            dotphat: dotphat,
            mahoadon: mahoadon,
            loai: loai,
            size: size,
            nsx: nsx,
            trangthai: trangthai,
            cccd: cccd,
            end: end,
            start: start
        },
        success: function (res) {
            $("#modal_bieudo_thongke_phat").show();
            
            // Xóa biểu đồ cũ nếu có
            if (window.myChart) {
                window.myChart.destroy();
            }

            // Khởi tạo dữ liệu
            var loaiNsxLabels = [];
            var sizeData = {};
            var data = res;

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
                sizeData[label][item.size] += parseInt(item.tong_sl_phat, 10); // Chuyển đổi sang số nguyên
            });

            // Tạo datasets cho các kích thước có dữ liệu
            var datasets = [];
            var sizeLabels = Object.keys(sizeColors); // Tất cả kích thước cố định

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
            var ctx = document.getElementById('dongphuc_dot-chart-canvas').getContext('2d');
            window.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: loaiNsxLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        datalabels: {
                            color: 'black',
                            display: true,
                            anchor: 'end',
                            align: 'top',
                            formatter: function(value) {
                                return value > 0 ? value : ''; // Hiển thị giá trị chỉ khi lớn hơn 0
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: false, // Để tạo cột ghép, phải bỏ stacked đi
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
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Đảm bảo plugin được đưa vào
            });
        }
    });
}

function close_bieudo_thongke(){
    $("#modal_bieudo_thongke_phat").hide();

}







