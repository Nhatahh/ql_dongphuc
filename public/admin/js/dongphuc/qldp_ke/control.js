$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    hienthike();
});
//
function ke_112() {
  // window.location.href =  "http://quanlydongphuc.ctuet.edu.vn:8080/ke/ke_them, '_blank'";

  window.open("http://quanlydongphuc.ctuet.edu.vn:8080/ke/ke_them", '_blank');
    // if ($("#ke_ten").val() == "") {
    //     toastr.warning("Tên kệ không được trống!");
    // } else if ($("#ke_slmax").val() == "") {
    //     toastr.warning("Sức chứa không được trống!");
    // } else if ($("#ke_slmax").val() <= 0) {
    //     toastr.warning("Sức chứa phải lớn hơn 0!");
    // } else {
    //     $.ajax({
    //         type: "post",
    //         url: "ke/ke_them",
    //         // dataType: 'json',
    //         data: {
    //             ten: $("#ke_ten").val(),
    //             slmax: $("#ke_slmax").val(),
    //         },
    //         success: function (res) {
    //             if (res == 1) {
    //               hienthike();
    //                 toastr.success("Thêm thành công");
    //             } else if (res == 2) {
    //                 toastr.warning("Cập nhật không thành công, liên hệ admin");
    //             } else {
    //                 toastr.warning("Tên kệ đã tồn tại");
    //             }
    //             // alert(res)
    //             // $('#nsx_tennsx').select2({
    //             //     data: res
    //             // });
    //         },
    //     });
    // }
}
function delete_ke(id)
{
  $.ajax({
    type: "post",
    url: "ke/delete_ke/" + id,
    success: function (res) {
          if (res == 1) {
            hienthike()
            return toastr.success("Xóa thành công");
          } else {
            // $('#info_login').html('<span style = "color: red">Mật khẩu hoặc email không đúng</span>')
            return toastr.warning("Xóa không thành công");
            // toastr.warning('aaaaaaaaaaaaaaaaaaaaa');
          }
    },
});
}
//Get data ke
function edit_ke(id) {
  $('#modal_editnsx').show()
  $("#editMenu").attr("data-id", id);
  $.ajax({
      type: "get",
      url: "ke/edit_ke/" + id,
      dataType: "json",
      success: function (res) {
        var name = res.name;
        var slmax = res.slmax;
        $("#e_link").val(slmax);
        $("#e_name").val(name);s
      },
  });
}
//Update data ke
function submit_ke()
{
  var id = $("#editMenu").attr("data-id");
    var name = $("#e_name").val();
    var slmax = $("#e_link").val();
    $.ajax({
        type: "post",
        url: "ke/submit_ke",
        data: { 
          id: id, 
          name: name, 
          slmax : slmax, 
        },
        success: function (res) {
          if (res == 1) {
            hienthike()
            return toastr.success("Cập nhật thành công");
          } else {
            return toastr.warning("Cập nhật không thành công");
          }
        },
    });
}
//
function clear_Ke()
{
  var id=$("#editMenu").attr("data-id");
  edit_ke(id);

}
//
function modal_close_nsx() {
  $('#modal_editnsx').hide()
}
function hienthike() {
    $("#hienke").empty();
    $("#hienke").append(
        '<table class="table table-hover text-nowrap" id="danhsachke"></table>'
    );
    var table = $("#danhsachke").DataTable({
        ajax: {
            type: "get",
            url: "ke/hienthike",
        },

        // dom: 'frtip',
        columns: [
            { title: "Tên Kệ", data: "name" },
            { title: "Số lượng", data: "slmax" },
            { title: "Chức năng", data: "idk",
              render:function(data){
                  var html=
                  '<i style ="color: #0000FF;" class="fa-regular fa-pen-to-square"  onclick = "edit_ke(' +
                  data +
                  ')">&nbsp&nbsp</i><i style ="color: red;" class="fa-regular fa-trash-can"onclick = delete_ke(' +
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
          },],
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
