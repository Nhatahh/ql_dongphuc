$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('#summernote').summernote({
        // placeholder: 'Nhập nội dung mail...',
        tabsize: 2,
        height: 350,
        tooltip:false,

    });




    $('#them_summernote').summernote({
        placeholder: 'Nhập nội dung mail...',
        tabsize: 2,
        height: 390,
        tooltip:false,
    });


});
//table mail
$("#list_model_mail").empty();
$("#list_model_mail").append(
    '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="ds_mail"></table>'
);
var table = $("#ds_mail").DataTable({
    ajax: {
        type: "get",
        url: "/admin24/ds_mail",
    },
    dom: 'frtip',
    columns: [
        { title: "STT", data: "STT" },
        { title: "Tên Email", data: "ten_mail" },
        {
            title: "Chức năng",
            width: "40%",
            data: "id",
            render: function (data) {
                var html =
                    '<i style ="color: #696969;"  id="btt_setting_edit" id_edit="2" data-id="' +
                    data +
                    '" class="fa-solid fa-copy"  onclick = "copy_mail(' +
                    data +
                    ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"  id="btt_chucnang_dlt" data-id="' +
                    data +
                    '" id_delete="4" onclick = remove_mail(' +
                    data +
                    ")></i>";
                return html;
            },
        },
    ],
    columnDefs: [
        {
            targets: 2, // Cột thứ 3
            className: "text-center"
        },
        {
            targets: 0, // Cột thứ 3
            className: "text-center"
        }
    ],
    scrollY: 415,
    language: {
        emptyTable: "There are no accounts to display",
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
    paging: false,
    lengthChange: false,
    searching: true,
    ordering: false,
    info: false,
    autoWidth: true,
    responsive: true,
    select: true,
    drawCallback: function () {
        $('#ds_mail tbody').off('click', 'tr').on('click', 'tr', function () {
            var tableData = '';
            var tableData = table.rows().data().toArray();
            var data = table.row(this).data();
            load_mail(data.id);
            $('#ds_mail tbody tr.selected').removeClass('selected').css({ 'background-color': '', 'color': '' });
            $(this).addClass('selected').css({ 'background-color': '#00FFFF', 'color': '#303030' });
            // Đính kèm sự kiện keyup và keydown cho hàng được chọn
            $(document).on('keyup', function (e) {
                // Kiểm tra xem nút nào đã được nhấn
                if (e.which === 38) { // Phím lên
                    // Lấy chỉ số index của hàng hiện tại
                    var currentIndex = table.row('.selected').index();

                    // Kiểm tra xem có thể lấy dữ liệu của hàng trước đó hay không
                    if (currentIndex > 0) {
                        var prevRowData = tableData[currentIndex - 1];
                        console.log('Dữ liệu của hàng trước đó:', prevRowData);
                        // Thực hiện xử lý với dữ liệu của hàng trước đó
                        load_mail(prevRowData.id);

                        // Xóa lớp selected của hàng hiện tại và thêm lớp selected vào hàng mới được chọn
                        $('#ds_mail tbody tr.selected').removeClass('selected').css({ 'background-color': '', 'color': '' });
                        $('#ds_mail tbody tr').eq(currentIndex - 1).addClass('selected').css({ 'background-color': '#00FFFF', 'color': '#303030' });
                    }
                } else if (e.which === 40) { // Phím xuống
                    // Lấy chỉ số index của hàng hiện tại
                    var currentIndex = table.row('.selected').index();
                    // Kiểm tra xem có thể lấy dữ liệu của hàng kế tiếp hay không
                    if (currentIndex < tableData.length - 1) {
                        var nextRowData = tableData[currentIndex + 1];
                        console.log('Dữ liệu của hàng kế tiếp:', nextRowData);
                        // Thực hiện xử lý với dữ liệu của hàng kế tiếp
                        load_mail(nextRowData.id);
                        // Xóa lớp selected của hàng hiện tại và thêm lớp selected vào hàng mới được chọn
                        $('#ds_mail tbody tr.selected').removeClass('selected').css({ 'background-color': '', 'color': '' });
                        $('#ds_mail tbody tr').eq(currentIndex + 1).addClass('selected').css({ 'background-color': '#00FFFF', 'color': '#303030' });
                    }
                }
                // Ngăn chặn sự kiện keyup và keydown lan truyền đến các phần tử khác
                e.stopPropagation();
            });
        });
    }
});
//copy_mail mẫu
async function copy_mail(id) {
    const check = await laythongtincheckquyen(2);
    $('#update_mail').attr('id_mail', id);
    $('#summernote').val(" ")
    $('#tieude_mail').val(" ")
    $('#ten_mail').val(" ")
    $.ajax({
        type: "get",
        url: "/admin24/copy_mail/" + id,
        data: {
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function (res) {
            if(res==1){
                table.ajax.reload();
            }
            else{
                thongbao(res)
            }
        },
    });
}
//Load mail mẫu
function load_mail(id) {
    id_mail = $('#update_mail').attr('id_mail', id);
    $.ajax({
        type: "get",
        url: "/admin24/load_mail/" + id,
        success: function (res) {
            $("#tieude_mail").val(res.tieude);
            $("#ten_mail").val(res.ten_mail);
            $('#summernote').summernote("code", res.noidung);
        },
    });
}
//Xóa mail mẫu
async function remove_mail(id) {
    const check = await laythongtincheckquyen(4);
    $.ajax({
        type: "post",
        url: "/admin24/remove_mail/" + id,
        data:{
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 4,
            active: 1,
        },
        success: function (res) {
            thongbao(res)
            table.ajax.reload();
        },
    });
}
//Đóng modal thêm mail
function close_modal_them_mail(){
    $('#themmail').hide();
}
//show modal_mail
async function modal_mail(){
    const check = await laythongtincheckquyen(3);
    $.ajax({
        type: "get",
        url: "/admin24/modal_mail",
        data: {
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 3,
            active: 1,
        },success: function (res) {
            if(res==1){
                $('#themmail').show();
            }else{
                thongbao(res)
            }

        }
    });
}
//Thêm mail mẫu
async function add_mail() {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(3);
    let noidung_mail = $('#them_summernote').val()
    let tieude_mail = $('#them_tieude_mail').val()
    let ten_mail = $('#them_ten_mail').val()
    $.ajax({
        type: "post",
        url: "/admin24/add_mail",
        data: {
            noidung_mail: noidung_mail,
            tieude_mail: tieude_mail,
            ten_mail: ten_mail,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 3,
            active: 1,
        },
        success: function (res) {
            $('#modal_event').hide();
            if (res.trangthai == 1) {
                table.ajax.reload();
                thongbao(res.noidung);
                $('#themmail').hide();
            } else {
                if (res.kieudulieu == 'json') {
                    var data = Object.values(res.noidung['original'])
                    toastr.warning(data[0]);
                } else {
                    thongbao(res.noidung);
                }
            }
        },
    });
}
//Gửi thử
function gui_thu(){
    $('#modal_event').show();
    let noidung_mail = $('#them_summernote').val()
    let tieude_mail = $('#them_tieude_mail').val()
    let ten_mail = $('#them_ten_mail').val()
    let mail_thu = $('#mail_thu').val()
    $.ajax({
        type: "post",
        url: "/admin24/gui_thu",
        data: {
            noidung_mail: noidung_mail,
            tieude_mail: tieude_mail,
            ten_mail: ten_mail,
            mail_thu: mail_thu,
        },
        success: function (res) {
            $('#modal_event').hide();
            if(res==1){
                return toastr.success('Đã gửi thử thành công');
            }else{
                return toastr.warning('Gửi thử không thành công');
            }
        },
    });
}
//Làm mới form
function refresh_mail() {
    var id_mail = $('#update_mail').attr('id_mail');
    load_mail(id_mail)
}

//Update mail
async function update_mail() {
    $('#modal_event').show();
    const check = await laythongtincheckquyen(2);
    let noidung_mail = $('#summernote').val()
    let tieude_mail = $('#tieude_mail').val()
    let ten_mail = $('#ten_mail').val()
    let id_mail = $('#update_mail').attr('id_mail');
    $.ajax({
        type: "post",
        url: "/admin24/update_mail",
        data: {
            noidung_mail: noidung_mail,
            tieude_mail: tieude_mail,
            ten_mail: ten_mail,
            id_mail: id_mail,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 2,
            active: 1,
        },
        success: function (res) {
            $('#modal_event').hide();
            if (res.trangthai == 1) {
                table.ajax.reload();
                thongbao(res.noidung);
            } else {
                if (res.kieudulieu == 'json') {
                    var data = Object.values(res.noidung['original'])
                    toastr.warning(data[0]);
                } else {
                    thongbao(res.noidung);
                }
            }
        },
    });
}
