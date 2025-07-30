$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    show_bill();
});
//
//
function inhoadon(id_hd) {
    window.open("http://congmotcua.ctuet.edu.vn/admin/hoadon/printhd/"+id_hd, "_blank");
    // window.open("https://xettuyentest.ctuet.edu.vn/admin/hoadon/printhd/"+id_hd, "_blank");
}

//

function show_bill() {
    $("#show_bill").empty();
    $("#show_bill").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="list_bill"></table>'
    );
    var table = $("#list_bill").DataTable({
        ajax: {
            type: "get",
            url: "hoadon/show_bill",
        },

        // dom: 'frtip',
        columns: [
            { title: "Mã hóa đơn", data: "ngayhd" },
            { title: "Người phát", data: "nguoiphat" },
            { title: "Người mua", data: "ho_ten" },
            { title: "MSSV", data: "mssv" },
            { title: "Ngày bán", data: "update_at" },
            {
                title: "Chức năng",
                data: "id_hd",
                render: function (data) {
                    var html =
                        '<i style ="color: #0000FF;" class="fa-solid fa-print"  onclick = "inhoadon(' +
                        data +
                        ')">&nbsp&nbsp</i>';
                        html += '<i style ="color: red;" class="fa fa-trash"  onclick = "xoahoadon(' +
                        data +
                        ')"></i>';
                    return html;
                },
            },
        ],
        columnDefs: [
            {
                targets: 5,
                className: "text-center",
            },
        ],
        scrollY: 450,
        language: {
            emptyTable: "Không có sản phẩm",
            info: " _START_ / _END_ trên _TOTAL_ sản phẩm",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: "Hiện thị _MENU_ sản phẩm",
            infoEmpty: "",
        },
        retrieve: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        responsive: true,
        select: true,
    });
}


function xoahoadon(id) {
    $.ajax({
        type: "post",
        url: " hoadon/xoahoadon",
        data:
        {
            id: id,
        },
        success: function (res) {
            if(res > 0){
                toastr.success("Xóa thành công");
                show_bill();
            }else{
                toastr.warning("Xóa không thành công");
            }
        },
    });
}

