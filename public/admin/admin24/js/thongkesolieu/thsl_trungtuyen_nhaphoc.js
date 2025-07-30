$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(window).resize(function() {
        equalizeHeight();
    });
    $('#thsl_trungtuyen_nhaphoc_namts').select2();
    $('#thsl_trungtuyen_nhaphoc_dotts').select2();
    // equalizeHeight()
    thsl_trungtuyen_nhaphoc_index();


    $(document).keydown(function(event) {
        if (event.key === "Escape") {  // Kiểm tra nếu phím là ESC
            modal_danhsachnganh_close();  // Thực hiện hành động đóng modal
        }
    });
})


// thsl_trungtuyen_nhaphoc_search




async function thsl_trungtuyen_nhaphoc_index(){
    await thsl_trungtuyen_nhaphoc_start()
    var idnam = $('#thsl_trungtuyen_nhaphoc_namts').val();
    var data = await thsl_trungtuyen_nhaphoc_data(idnam,0);
    await thsl_trungtuyen_nhaphoc_danhsach(data.data);
    await equalizeHeight()
}
async function thsl_trungtuyen_nhaphoc_ds_nganh(id) {
    $('#modal_danhsachnganh').show();
    try {
        var idnam = $('#thsl_trungtuyen_nhaphoc_namts').val();
        var response = await thsl_trungtuyen_nhaphoc_data(idnam,0);
        var data = response.data.find(item => item.id_nganh === id);
        if (data) {
            $('#modal_danhsachnganh_tennganh').text( "Danh sách thí sinh trúng tuyển " + data.tennganh);
            data = data.danhsachthisinh;
        } else {
            $('#modal_danhsachnganh_tennganh').text( "Danh sách thí sinh trúng tuyển ngành (Lỗi)");
            data = [];
        }
    } catch (err) {
            data = [];
        $('#modal_danhsachnganh_tennganh').text( "Danh sách thí sinh trúng tuyển ngành (Lỗi)");
    }
    table2 = $('#thsl_trungtuyen_nhaphoc_modal_danhsachnganh').DataTable({
        processing: true,
        data: data,
        columns: [
            {
                title: "#",
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                },
                className: 'text-center'
            },

            {
                name: "hoten",
                title: "Họ tên",
                data: "hoten",
            },

            {
                name: "ngaysinh",
                title: "Ngày sinh",
                data: "ngaysinh",
            },

            {
                name: "cccd",
                title: "CCCD/CMND",
                data: "cccd",
            },

            {
                name: "tenchuyennganh",
                title: "Chuyên ngành",
                data: "tenchuyennganh",
            },

            {
                name: "diemtohop",
                title: "Điểm TH",
                data: "diemtohop",
            },
            {
                name: "diemxettuyen",
                title: "Điểm XT",
                data: "diemxettuyen",
            },

            {
                name: "trungtuyensom",
                title: "TT Sớm",
                data: "trungtuyensom",
                render: function(data, type, row){
                    var checked = '';
                    if(data == 1){ checked = "checked"  }
                    return '<input style = "height:14px" type = "checkbox" '+checked+' onclick = "return false">'
                }
            },

            {
                name: "nhaphoc",
                title: "Nhâp học",
                data: "nhaphoc",
                render: function(data, type, row){
                    var checked = '';
                    if(data == 1){ checked = "checked"  }
                    return '<input style = "height:14px" type = "checkbox" '+checked+' onclick = "return false">'
                }
            },

            {
                name: "mssv",
                title: "MSSV",
                data: "mssv",
            },

            {
                name: "madottuyensinh",
                title: "Đợt TS",
                data: "madottuyensinh",
            },

        ],
        "columnDefs": [
            {
                targets: [1], // Căn tất cả các cột sang trái
                className: 'text-left'
            }
        ],
        "language": {
            "emptyTable": "Không tìm thấy sinh viên",
            "info": " _TOTAL_ sinh viên",
            "paginate": {
                "first": "Trang đầu",
                "last": "Trang cuối",
                "next": "Trang sau",
                "previous": "Trang trước"
            },
            "search": "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu": "Hiện thị _MENU_ SV",
            "infoEmpty":  "",
        },
        "retrieve": true,
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        scrollY: 400,
    });
    if ($.fn.dataTable.isDataTable('#thsl_trungtuyen_nhaphoc_modal_danhsachnganh')) {
        table2.clear();
        table2.rows.add(data);
        table2.draw();
    }
}
async function thsl_trungtuyen_nhaphoc_search(){
    var idnam = $('#thsl_trungtuyen_nhaphoc_namts').val();
    var iddot = $('#thsl_trungtuyen_nhaphoc_dotts').val();
    // await thsl_trungtuyen_nhaphoc_start()

    var data = await thsl_trungtuyen_nhaphoc_data(idnam,iddot);
    await thsl_trungtuyen_nhaphoc_danhsach(data.data);
    await equalizeHeight()
}
function thsl_trungtuyen_nhaphoc_start(){
    return new Promise (function(resolve, reject){
        $.ajax({
            type: "get",
            url: "dsts_loadtimkiem",
            success: function (res) {
                $('#thsl_trungtuyen_nhaphoc_namts').select2({
                    data: res.dsts_namtuyensinh
                })
                var selectedOption = $('#thsl_trungtuyen_nhaphoc_namts').find('option').filter(function() {
                    var year = new Date().getFullYear();
                    return $(this).text() == year; // Kiểm tra giá trị 'value' bằng 2024
                }).val(); // Lấy text của option
                $('#thsl_trungtuyen_nhaphoc_namts').val(selectedOption).trigger('change');
                $('#thsl_trungtuyen_nhaphoc_dotts').select2({
                    data: res.dsts_dottuyensinh
                })
                $('#thsl_trungtuyen_nhaphoc_dotts').val(0).trigger('change');
                resolve(true)
            }
        });
    })
}
function modal_danhsachnganh_close(){
    $('#modal_danhsachnganh').hide();
}
function thsl_trungtuyen_nhaphoc_data(idnam,iddot){
    return new Promise(function(resolve, reject){
        $.ajax({
            url: "thsl_trungtuyen_nhaphoc_danhsach_thongke/"+idnam+"/"+iddot,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                resolve(res);  // Kiểm tra dữ liệu trả về
            },
            error: function(err) {
                reject(err);
            }
        })
    })
}
function thsl_trungtuyen_nhaphoc_danhsach(data){
    return new Promise(function(resolve, reject){
        try {
            if (typeof data === "string") {
                data = JSON.parse(data);
            }
        } catch (e) {
            data = [];
        }
        var table = $('#thsl_trungtuyen_nhaphoc_thongke').DataTable({
            processing: true,
            data: data,  // Chú ý sử dụng data.data nếu dữ liệu chứa trong trường data
            columns: [
                {
                    title: "#", // Cột số thứ tự
                    data: null, // Dữ liệu không cần thiết cho cột này
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return ''; // Để trống, vì sẽ xử lý STT trong rowCallback
                    }
                },

                {
                    name: "tennganh",
                    className: 'text-left',
                    title: "Tên Ngành",
                    data: "tennganh",

                },
                {
                    title: "CT",
                    data: 'chitieu',
                },

                {
                    name: "soluongdangky",
                    className: 'text-center',
                    title: "SL",
                    data: "soluongdangky",
                },
                {
                    title: "TLCT",
                    data: 'soluongdangky',
                    render: function(data,type,row){
                        return row.chitieu == 0 ?  "" : "1:"+( data/row.chitieu).toFixed(0)
                    }
                },
                {
                    title: "TTS",
                    data: 'dangky_trungtuyensom',
                },

                {
                    title: "TTS/CT",
                    data: 'dangky_trungtuyensom',
                    render: function(data,type,row){
                        return row.chitieu == 0 ?  0 : ( data/row.chitieu * 100).toFixed(1)
                    }
                },

                {
                    name: "soluongtrungtuyen",
                    className: 'text-center',
                    title: "SL",
                    data: "soluongtrungtuyen",
                },
                {
                    title: "TLCT",
                    data: 'soluongtrungtuyen',
                    render: function(data, type, row){
                        return data == 0 ?  "" : "1:"+( row.soluongdangky/data).toFixed(0)
                    }
                },
                {
                    name: "soluongtrungtuyen",
                    className: 'text-center',
                    title: "TL/CT",
                    data: "soluongtrungtuyen",
                    render: function(data,type,row){
                        return row.chitieu == 0 ?  0 : ( data/row.chitieu * 100).toFixed(1)
                    }
                },
                {
                    title: "TTS",
                    data: 'trungtuyensom',
                },
                {
                    name: "trungtuyensom",
                    className: 'text-center',
                    title: "TTS/TT",
                    data: "trungtuyensom",
                    render: function(data,type,row){
                        return row.soluongtrungtuyen == 0 ?  0 : ( data/row.soluongtrungtuyen * 100).toFixed(1)
                    }
                },
                {
                    name: "trungtuyensom",
                    className: 'text-center',
                    title: "TTS/CT",
                    data: "trungtuyensom",
                    render: function(data,type,row){
                        return row.chitieu == 0 ?  0 : ( data/row.chitieu * 100).toFixed(1)
                    }
                },


                {
                    name: "soluongnhaphoc",
                    className: 'text-center',
                    title: "SL",
                    data: "soluongnhaphoc",
                },
                {
                    title: "TL/CT",
                    data: 'soluongnhaphoc',
                    render: function(data, type, row){
                        return row.chitieu == 0 ?  0 : ( data/row.chitieu * 100).toFixed(1)
                    }
                },
                {
                    name: "soluongnhaphoc",
                    // className: 'text-center',
                    title: "TL/TT",
                    data: "soluongnhaphoc",
                    render: function(data, type, row){
                        return row.soluongtrungtuyen == 0 ?  0 : ( data/row.soluongtrungtuyen * 100).toFixed(1)
                    }
                },
                {
                    title: "TTS",
                    data: 'nhaphoc_trungtuyensom',
                },
                {
                    title: "TTS/TT",
                    data: 'nhaphoc_trungtuyensom',
                    render: function(data, type, row){
                        return row.soluongtrungtuyen == 0 ?  0 : ( data/row.soluongtrungtuyen * 100).toFixed(1)
                    }
                },
                {
                    title: "TTS/NH",
                    data: 'nhaphoc_trungtuyensom',
                    render: function(data, type, row){
                        return row.soluongnhaphoc == 0 ?  0 : ( data/row.soluongnhaphoc * 100).toFixed(1)
                    }
                },
                {
                    name: "id_nganh",
                    className: 'text-center',
                    title: "#",
                    data: "id_nganh",
                    render: function(data, type, row){
                        return '<i class="fa-solid fa-circle-info" onclick="thsl_trungtuyen_nhaphoc_ds_nganh(' + data + ')"></i>'
                    }
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(index + 1);
            },
            "language": {
                "emptyTable": "Không tìm thấy sinh viên",
                "info": " _TOTAL_ sinh viên",
                "paginate": {
                    "first": "Trang đầu",
                    "last": "Trang cuối",
                    "next": "Trang sau",
                    "previous": "Trang trước"
                },
                "search": "Tìm kiếm:",
                "loadingRecords": "Đang tìm kiếm ... ",
                "lengthMenu": "Hiện thị _MENU_ SV",
                "infoEmpty": "",
            },
            "retrieve": true,
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            scrollY: 430
        });

        if ($.fn.dataTable.isDataTable('#thsl_trungtuyen_nhaphoc_thongke')) {
            table.clear();
            table.rows.add(data);
            table.draw();
        }
        $('#thsl_trungtuyen_nhaphoc_thongke tbody').on('click', 'td:nth-child(2)', function () {
            var tr = $(this);
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                var data = row.data();
                var childContent = '<div class="table-responsive"><table class="table table-bordered table-sm m-0">';
                childContent += '<tbody>';
                if (data.danhsachthisinh) {
                    $.each(data.chuyennganh, function(index, chuyennganh) {
                        childContent += '<tr>';
                        childContent += '<td style = "text-align: right;padding:0">' + chuyennganh.tenchuyennganh + '</td>';
                        childContent += '<td style = "text-align: right;padding:0">' + chuyennganh.soluongtrungtuyen + '</td>';
                        childContent += '<td style = "text-align: right;padding:0">' + chuyennganh.trungtuyensom + '</td>';
                        childContent += '<td style = "text-align: right;padding:0">' + chuyennganh.soluongnhaphoc + '</td>';
                        childContent += '</tr>';
                    });
                }
                childContent += '</tbody></table></div>';
                row.child(childContent).show();
                tr.addClass('shown');
            }
        });

        resolve(table);
    })
}
function html_table_to_excel(type) {
    var table = $('#thsl_trungtuyen_nhaphoc_modal_danhsachnganh').DataTable();
    var rows = table.rows().data();
    var selectedColumns = [
        { title: "#", render: function(data, type, row, meta) {
            return meta.row + 1;
        }},
        { title: "Họ tên", data: "hoten" },
        { title: "Ngày sinh", data: "ngaysinh" },
        { title: "CCCD/CMND", data: "cccd", render: function(data) {
            return data.toString()
        }},
        { title: "Chuyên ngành", data: "tenchuyennganh" },
        { title: "Điểm TH", data: "diemtohop" },
        { title: "Điểm XT", data: "diemxettuyen" },
        { title: "TT Sớm", data: "trungtuyensom", render: function(data) {
            return data == 1 ? 'X' : '';  // Thay '1' bằng 'X' cho cột TT Sớm
        }},
        { title: "Nhập học", data: "nhaphoc", render: function(data) {
            return data == 1 ? 'X' : '';  // Thay '1' bằng 'X' cho cột Nhập học
        }},
        { title: "Đọt TS", data: "tendottuyensinh" },
        { title: "MSSV", data: "mssv" },
    ];

    var data = [];
    var columnWidths = new Array(selectedColumns.length).fill(0);  // Khởi tạo mảng lưu chiều rộng cột

    rows.each(function(row, index) {
        var rowData = {};
        selectedColumns.forEach(function(col, colIndex) {
            var value = col.render ? col.render(row[col.data], null, row, { row: index }) : row[col.data];
            rowData[col.title] = value;
            var valueLength = value ? value.toString().length : 0;
            columnWidths[colIndex] = Math.max(columnWidths[colIndex], valueLength);
        });

        data.push(rowData);
    });
    columnWidths = columnWidths.map(function(width) {
        return width + 2;
    });
    var ws = XLSX.utils.json_to_sheet(data);
    ws['!cols'] = columnWidths.map(function(width) {
        return { wpx: width * 10 };
    });
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Danh sách thí sinh");
    XLSX.writeFile(wb, "danhsachthisinhtungtuyen.xlsx");
}
const export_button = document.getElementById('thsl_trungtuyen_nhaphoc_xuat_ds_nganh');
export_button.addEventListener('click', () =>  {
    html_table_to_excel('xlsx');
});





async function html_table_to_excel_thongke(type,idnam,iddot) {
    var wb = XLSX.utils.book_new();
    var table = $('#thsl_trungtuyen_nhaphoc_thongke').DataTable();
    var rows = table.rows().data();
    var selectedColumns = [
        {
            name: "tennganh",
            className: 'text-left',
            title: "Tên Ngành",
            data: "tennganh",
        },
        {
            title: "CT",
            data: 'chitieu',
        },
        {
            name: "soluongdangky",
            className: 'text-center',
            title: "SL",
            data: "soluongdangky",
        },
        {
            title: "TLCT",
            data: 'soluongdangky',
            render: function(data, type, row) {
                return row.chitieu == 0 ? "" : "1:" + (data / row.chitieu).toFixed(0);
            }
        },
        {
            title: "TTS",
            data: 'dangky_trungtuyensom',
        },
        {
            title: "TTS/CT",
            data: 'dangky_trungtuyensom',
            render: function(data, type, row) {
                return row.chitieu == 0 ? 0 : (data / row.chitieu * 100).toFixed(1);
            }
        },

        {
            name: "soluongtrungtuyen",
            className: 'text-center',
            title: "SL",
            data: "soluongtrungtuyen",
        },
        {
            title: "TLCT",
            data: 'soluongtrungtuyen',
            render: function(data, type, row) {
                return data == 0 ? "" : "1:" + (row.soluongdangky / data).toFixed(0);
            }
        },
        {
            name: "soluongtrungtuyen",
            className: 'text-center',
            title: "TL/CT",
            data: "soluongtrungtuyen",
            render: function(data, type, row) {
                return row.chitieu == 0 ? 0 : (data / row.chitieu * 100).toFixed(1);
            }
        },
        {
            name: "soluongtrungtuyen",
            className: 'text-center',
            title: "TL/ĐK",
            data: "soluongtrungtuyen",
            render: function(data, type, row) {
                return row.soluongdangky == 0 ? 0 : (data / row.soluongdangky * 100).toFixed(1);
            }
        },


        {
            title: "TTS",
            data: 'trungtuyensom',
        },
        {
            name: "trungtuyensom",
            className: 'text-center',
            title: "TTS/TT",
            data: "trungtuyensom",
            render: function(data, type, row) {
                return row.soluongtrungtuyen == 0 ? 0 : (data / row.soluongtrungtuyen * 100).toFixed(1);
            }
        },
        {
            name: "trungtuyensom",
            className: 'text-center',
            title: "TTS/CT",
            data: "trungtuyensom",
            render: function(data, type, row) {
                return row.chitieu == 0 ? 0 : (data / row.chitieu * 100).toFixed(1);
            }
        },
        {
            name: "soluongnhaphoc",
            className: 'text-center',
            title: "SL",
            data: "soluongnhaphoc",
        },
        {
            title: "TL/CT",
            data: 'soluongnhaphoc',
            render: function(data, type, row) {
                return row.chitieu == 0 ? 0 : (data / row.chitieu * 100).toFixed(1);
            }
        },
        {
            name: "soluongnhaphoc",
            title: "TL/TT",
            data: "soluongnhaphoc",
            render: function(data, type, row) {
                return row.soluongtrungtuyen == 0 ? 0 : (data / row.soluongtrungtuyen * 100).toFixed(1);
            }
        },
        {
            name: "soluongnhaphoc",
            title: "TL/ĐK",
            data: "soluongnhaphoc",
            render: function(data, type, row) {
                return row.soluongdangky == 0 ? 0 : (data / row.soluongdangky * 100).toFixed(1);
            }
        },
        {
            title: "TTS",
            data: 'nhaphoc_trungtuyensom',
        },
        {
            title: "TTS/TT",
            data: 'nhaphoc_trungtuyensom',
            render: function(data, type, row) {
                return row.soluongtrungtuyen == 0 ? 0 : (data / row.soluongtrungtuyen * 100).toFixed(1);
            }
        },
        {
            title: "TTS/ĐKTTS",
            data: 'nhaphoc_trungtuyensom',
            render: function(data, type, row) {
                return row.trungtuyensom == 0 ? 0 : (data / row.trungtuyensom * 100).toFixed(1);
            }
        },

        {
            title: "TTS/NH",
            data: 'nhaphoc_trungtuyensom',
            render: function(data, type, row) {
                return row.soluongnhaphoc == 0 ? 0 : (data / row.soluongnhaphoc * 100).toFixed(1);
            }
        },
        {
            title: "TTS/CT",
            data: 'nhaphoc_trungtuyensom',
            render: function(data, type, row) {
                return row.chitieu == 0 ? 0 : (data / row.chitieu * 100).toFixed(1);
            }
        }
    ];
    var headers1 = [ 'Ngành đào tạo','','Đăng ký','','','','Trúng tuyển','','','','','','','Nhập học'];
    var headers2 = [ 'Tên ngành', 'Chỉ tiêu', 'SL','TLCT','TTS','TTS/CT','SL','TLCT','TL/CT','TL/ĐK','TTS','TTS/TT','TTS/CT','SL','TL/CT','TL/TT','TL/ĐK','TTS','TTS/TT','TTS/ĐKTTS','TTS/NH','TTS/CT'];
    var tdata = [ headers1, headers2 ];
    rows.each(function(row, index) {
        var rowData = [];
        selectedColumns.forEach(function(col) {
            var value = col.render ? col.render(row[col.data], null, row, { row: index }) : row[col.data];
            rowData.push(value);
        });
        tdata.push(rowData);
    });
    var ws = XLSX.utils.aoa_to_sheet(tdata);
    ws['!merges'] = [
        { s: { r: 0, c: 0 }, e: { r: 0, c: 1 } },
        { s: { r: 0, c: 2 }, e: { r: 0, c: 5 } },
        { s: { r: 0, c: 6 }, e: { r: 0, c: 12 } },
        { s: { r: 0, c: 13 }, e: { r: 0, c: 21 } },
    ];

    XLSX.utils.book_append_sheet(wb, ws, "Thongke");
    var dstong = [];
    var data_nganh = await thsl_trungtuyen_nhaphoc_data(idnam, iddot);
    var i = 0;
    data_nganh.data.forEach(nganh => {
        i++;
        var nganhdatao = [];
        var manganh = nganh.manganh
        nganh.danhsachthisinh.forEach(thisinh => {
            dstong.push([
            thisinh.hoten,
            thisinh.ngaysinh,
            thisinh.cccd,
            thisinh.id_chuyennganh,
            thisinh.tenchuyennganh,
            thisinh.xacnhan_ttsom,
            thisinh.nhaphoc,
            thisinh.trungtuyensom,
            thisinh.id_nganh,
            thisinh.tennganh,
            thisinh.diemxettuyen,
            thisinh.diemtohop
            ]);
            nganhdatao.push([
            thisinh.hoten,
            thisinh.ngaysinh,
            thisinh.cccd,
            thisinh.id_chuyennganh,
            thisinh.tenchuyennganh,
            thisinh.xacnhan_ttsom,
            thisinh.nhaphoc,
            thisinh.trungtuyensom,
            thisinh.id_nganh,
            thisinh.tennganh,
            thisinh.diemxettuyen,
            thisinh.diemtohop
            ]);
        });
        var ws_nganh = XLSX.utils.aoa_to_sheet(nganhdatao);
        XLSX.utils.book_append_sheet(wb, ws_nganh, 'DS'+manganh);
    });
    var ws_dstong = XLSX.utils.aoa_to_sheet(dstong);
    XLSX.utils.book_append_sheet(wb, ws_dstong, "DSTong");
    XLSX.writeFile(wb, "thongkethisinhtungtuyen.xlsx");
}


const export_button2 = document.getElementById('thsl_trungtuyen_nhaphoc_xuat_ds_thongke');
export_button2.addEventListener('click', () =>  {
    var idnam = $('#thsl_trungtuyen_nhaphoc_namts').val();
    var iddot = $('#thsl_trungtuyen_nhaphoc_dotts').val();
    html_table_to_excel_thongke('xlsx',idnam,iddot);
});

async function thsl_trungtuyen_nhaphoc_clear(){
    thsl_trungtuyen_nhaphoc_index()
}






