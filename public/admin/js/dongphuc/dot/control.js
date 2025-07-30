$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    hienthidot();
});
//

function dot_them()
{
    if ($("#dot_ngay").val() == "" || $("#dot_ten").val() == "") {
        toastr.warning("Ngày và đợt không được trống!");
    } else {
        $.ajax({
            type: "post",
            url: "dot/dot_them",
            // dataType: 'json',
            data: {
                dot_ngay: $("#dot_ngay").val(),
                dot_ten: $("#dot_ten").val(),
            },
            success: function (res) {
                if (res == 1) {
                  hienthidot();
                    toastr.success("Thêm thành công");
                } else if (res == 2) {
                    toastr.warning("Thêm không thành công, liên hệ admin");
                } else {
                    toastr.warning("Tên đợt đã tồn tại");
                }
                // $('#nsx_tennsx').select2({
                //     data: res
                // });
            },
        });
    }
}



function delete_dot(id)
{
  $.ajax({
    type: "post",
    url: "dot/delete_dot/" + id,
    success: function (res) {
          if (res == 1) {
            hienthidot();
            return toastr.success("Xóa thành công");
          } else {
            // $('#info_login').html('<span style = "color: red">Mật khẩu hoặc email không đúng</span>')
            return toastr.warning("Xóa không thành công!!Đợt nhập đang tồn tại trong hóa đơn nhập");
            // toastr.warning('aaaaaaaaaaaaaaaaaaaaa');
          }
    },
});
}
//Get data ke
function edit_dot(id) {
  $('#model_editdot').show()
  $("#editMenu").attr("data-id", id);
  $.ajax({
      type: "get",
      url: "dot/edit_dot/" + id,
      dataType: "json",
      success: function (res) {
        var ten_dot = res.ten_dot;
        var ngay_dot = res.ngay_dot;
        $("#e_link").val(ngay_dot);
        $("#e_name").val(ten_dot);s
      },
  });
}
//Update data ke
function submit_dot()
{
  var iddot = $("#editMenu").attr("data-id");
    var ten_dot = $("#e_name").val();
    var ngay_dot = $("#e_link").val();
    $.ajax({
        type: "post",
        url: "dot/submit_dot",
        data: {
          iddot: iddot,
          ten_dot: ten_dot,
          ngay_dot : ngay_dot,
        },
        success: function (res) {
          if (res == 1) {
            hienthidot();
            model_close_dot();
            return toastr.success("Cập nhật thành công");
          } else {
            return toastr.warning("Cập nhật không thành công");
          }
        },
    });
}
//
function clear_dot()
{
  var id=$("#editMenu").attr("data-id");
  edit_dot(id);

}
//
function model_close_dot() {
  $('#model_editdot').hide()
}
function hienthidot() {
    $("#hiendot").empty();
    $("#hiendot").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="danhsachdot"></table>'
    );
    var table = $("#danhsachdot").DataTable({
        ajax: {
            type: "get",
            url: "dot/hienthidot",
        },

        // dom: 'frtip',
        columns: [
            { title: "Tên đợt", data: "ten_dot" },
            { title: "Ngày tạo đợt", data: "ngay_dot" },
            { title: "Chức năng", data: "iddot",
              render:function(data){
                  var html=
                  '<i style ="color: #0000FF;" class="fa-regular fa-pen-to-square"  onclick = "edit_dot(' +
                  data +
                  ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"onclick = delete_dot(' +
                  data +
                  ")></i>";

              return html;
              }
          },
        ],
        'columnDefs': [
          {
              "targets": 2,
              "className": "text-center",
          },
          {
            "targets": 1,
            "className": "text-center",
        },
        ],
        scrollY: 450,
        language: {
            emptyTable: "Không có sản phẩm",
            info: " _START_ / _END_ trên _TOTAL_",
            paginate: {
                first: "Trang đầu",
                last: "Trang cuối",
                next: "Trang sau",
                previous: "Trang trước",
            },
            search: "Tìm kiếm:",
            loadingRecords: "Đang tìm kiếm ... ",
            lengthMenu: " _MENU_",
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

function dot_clear(){
    var today = new Date();
    var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
    $("#dot_ngay").val(date)
    $("#dot_ten").val('')
}
