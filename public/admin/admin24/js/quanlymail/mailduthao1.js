$(document).ready(function() {
    $('#find_dot').select2()
    $('#chonmail').select2()



    // Gọi hàm fetchData sau mỗi 10 giây

});

const eventSource = new EventSource('/admin24/sse');
eventSource.onmessage = function(event) {
    var data_arr = event.data.split('xxx');
    if(data_arr[0] == 0){
        console.log(data_arr)
        eventSource.close();
    }else{
        console.log(data_arr)
    }
    // for (let i = 0; i < data_arr.length; i++) {

    // }



    // if(data_arr[1] == 1){
    //     $("#result").text("");
    //     $("#result").text(data_arr[0]);
    // }else{
    //
    // }


    // console.log(data_arr[0])

};

eventSource.onmessage('error', function(event) {
    console.error('Error occurred:', event);
});





// eventSource.onmessage = function(event) {
//     var data = JSON.parse(event.data);
//     // $('#testab').text('111111');
//     // $('#testab').text(event.data);
//     console.log('Received message: 111111111 ');
// };



// fetch('/admin24/sse', {
//   method: 'GET',
//   headers: {
//     'Content-Type': 'application/json', // Chú ý đặt kiểu dữ liệu gửi đi là JSON nếu cần
//   },
//   body: JSON.stringify({
//     key: 'value', // Thay 'value' bằng giá trị thực tế nếu cần
//   }),
// })
// .then(response => {
//   if (!response.ok) {
//     console.log(222222222222222222222)
//   }
//   return response.json(); // Chuyển đổi dữ liệu nhận được thành JSON
// })
// .then(data => {
//   console.log(111111111111); // In dữ liệu nhận được vào console
// })
// .catch(error => {
//   console.error('There was a problem with your fetch operation:');
// });



// fetch('https://xettuyentest.ctuet.edu.vn/admin24/see')
// .then((response)=>response.json())
// .then((json)=> console.log(111111111111));








$('#test').on('click',function(){
    var newTab = window.open('/admin24/startqueue', '_blank');
    // Đợi một khoảng thời gian, sau đó đóng tab mới
    setTimeout(function() {
        newTab.close();
    }, 1000); // Đóng tab sau 3 giây (3000 miligiây)
    // // fetchData();

})


    // var table_tientrinhguimail =  $('#table_tientrinhguimail').DataTable({
    //     type:'get',
    //     ajax: '/admin24/table_tientrinhguimail',
    //     columns: [
    //         {   title: "Email",
    //             data: 'email' },

    //         { title: "Tranthai",
    //         data: 'status' },
    //     ],
    //     // columnDefs: [
    //     //     {
    //     //         targets: 0,
    //     //         className: 'dt-body-left'
    //     //     },
    //     //     {
    //     //         targets: 1,
    //     //         className: 'dt-body-left'
    //     //     },
    //     //     {
    //     //         targets: 2,
    //     //         className: 'dt-body-left'
    //     //     },
    //     //     {
    //     //         targets: 4,
    //     //         className: 'dt-body-left'
    //     //     },
    //     //     {
    //     //         targets: 5,
    //     //         className: 'dt-body-left'
    //     //     },
    //     //     {
    //     //         targets: 6,
    //     //         className: 'dt-body-left'
    //     //     },
    //     //     {
    //     //         targets: 7,
    //     //         className: 'dt-body-left'
    //     //     },

    //     // ],

    //     "language": {
    //         "emptyTable": "Không tìm thấy hóa đơn",
    //         "info": " _START_ / _END_ trên _TOTAL_ hóa đơn",
    //         "paginate": {
    //             "first":      "Trang đầu",
    //             "last":       "Trang cuối",
    //             "next":       "Trang sau",
    //             "previous":   "Trang trước"
    //         },
    //         "search":         "Tìm kiếm:",
    //         "loadingRecords": "Đang tìm kiếm ... ",
    //         "lengthMenu":     "Hiện thị _MENU_ hóa đơn",
    //         "infoEmpty":      "",
    //         },


    //     "retrieve": true,
    //     "paging": false,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": false,
    //     "info": false,
    //     "autoWidth": true,
    //     "responsive": false,
    //     scrollY: 380,
    // });


// function dieukiendung(){
//     return new Promise(function(resolve, reject) {

//     })

// }

// async function fetchData() {

//     if(await dieukiendung() > 0){
//         table_tientrinhguimail.ajax.reload();
//     }else{
//         alert(11111111)
//     }


    // setTimeout(() => {
    // }, 1000);
    // Thực hiện truy vấn dữ liệu ở đây
    // setTimeout(() => {


// }





function check(){
    return new Promise(function(resolve, reject) {

    })

}



function xemtientrinh(){
    // table_tientrinhguimail.ajax.reload();
    // setTimeout(() => {
            $.ajax({
                url: '/admin24/table_tientrinhguimail_active',
                type: 'GET',
                success: function(data) {
                    console.log(data)

                    // if(data == 0){
                    //     console.log(data);
                    // }else{
                    //     xemtientrinh()
                    //     console.log(data);
                    // }

                    // if(data == 1){
                    //     $.ajax({
                    //         url: '/admin24/table_tientrinhguimail',
                    //         type: 'GET',
                    //         async:false,
                    //         success: function(data) {
                    //            console.log(data)
                    //         },
                    //         complete: function(xhr, status) {
                    //             // Xử lý sau khi yêu cầu AJAX hoàn thành, bất kể thành công hay thất bại
                    //             xemtientrinh()
                    //             console.log("AJAX request completed with status:", status);
                    //         }
                    //     })
                    // }else{
                    //     console.log(11111111);
                    // }
                }
            })








            // table_tientrinhguimail.ajax.reload();






    // }, 5000);
}


function fetchData() {
    fetch('https://xettuyentest.ctuet.edu.vn/admin24/email')
        // .then(response => {
        //     if (!response.ok) {
        //         throw new Error('Network response was not ok');
        //     }
        //     return response.json();
        // })
        .then(data => {

            // Xử lý dữ liệu ở đây
            console.log(data);
        })
        // .catch(error => {
        //     // Xử lý lỗi nếu có
        //     console.error('There was a problem with the fetch operation:', error);
        // });
}

// Gọi fetchData() ngay lập tức khi trang được tải lên

// function xemtientrinh(){
//     fetchData();
//     setInterval(fetchData, 5000); // 10 giây = 10000 miligiây
// }


// Sau đó, sử dụng setInterval để tự động gọi fetchData() sau mỗi 10 giây







var table = $("#list_mail_sv").DataTable({

        // type: "get",
        ajax: "/admin24/tt_mail_sinhvien",

    // dom: '<"top"i>rCt<"footer"><"bottom"flp><"clear">',
    columns: [
        {
            title:"<div style = 'display: flex;justify-content: center;align-items: center;'><input style=' height: auto' id ='check_all' class = 'check_all' type='checkbox'></div><div style='border-top:2px solid  #dee2e6'> <input style='height:28px; width:1px; border:none' ></div>" ,
            data: "id",
            render: function(data, type, row) {
                return '<input style = "height: auto" class = "guimail" id_taikhoan="' + data + '" id = "guimail' + data + '" type="checkbox">';
            },
        },
        {
            title:"<div style = 'text-align: center;'>Email</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_mail' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            // title:"<input id='search_mail'>",
            data:"email",
            render: function(data, type, row) {
                if (data != "") {
                    return '&nbsp;&nbsp;' + data;
                } else {
                    return '-';
                }
            },
        },
        {
            title:"<div style = 'text-align: center;'>Họ tên</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input id='search_hoten' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'><i style='color:#dee2e6;position:absolute;right:5px;top:50%;transform:translateY(-50%);pointer-events:none;' class='fa-solid fa-magnifying-glass'></i></div>",
            data:"hoten",
            render: function(data, type, row) {
                if (data == null) {
                    return '&nbsp;&nbsp; -';
                } else {
                    return '&nbsp;&nbsp;' + data;
                }
            },
        },
        // {
        //     title:"<div>Đợt</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'><input type='checkbox' id='search_dot' class='form-control' style='width:90%;height:28px;border:none;padding-right:30px;'></div>",
        //     data: "dot",
        //     render: function(data, type, row) {
        //         if (parseInt(data) > 0) {
        //             return  '<span style ="display: none">1</span><i style="color:rgb(10 85 140)" class="fas fa-check"></i>'
        //         } else {
        //             return'<span style ="display: none">0</span> <i style="color:red" class="fas fa-times"></i>';
        //         }
        //     },
        // },
        {
            title:"<div>TTCN</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:28px; border:none;color:#8a8c8f;' id = 'search_ttcn'> <option value =''></option> <option value ='1'>Đã có</option> <option value ='0'>Chưa có</option> </select> </div>",
            data: "thongtincanhan",
            render: function(data, type, row) {
                if (parseInt(data) > 0) {
                    return  '<span style ="display: none">1</span><i style="color:rgb(10 85 140)" class="fas fa-check"></i>'
                } else {
                    return'<span style ="display: none">0</span> <i style="color:red" class="fas fa-times"></i>';
                }
            },
        },
        {
            title:"<div>NV</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:28px; border:none;color:#8a8c8f;' id = 'search_nv'> <option value =''></option> <option value ='1'>Đã có</option> <option value ='0'>Chưa có</option> </select> </div>",
            data: "nguyenvong",
            render: function(data, type, row) {
                if (parseInt(data) > 0) {
                    return  '<span style ="display: none">1</span><i style="color:rgb(10 85 140)" class="fas fa-check"></i>'
                } else {
                    return'<span style ="display: none">0</span> <i style="color:red" class="fas fa-times"></i>';
                }
            },
        },
        {
            title:"<div>KQTT</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:28px; border:none;color:#8a8c8f;' id = 'search_kqtt'> <option value =''></option> <option value ='1'>Đã có</option> <option value ='0'>Chưa có</option> </select> </div>",
            data: "kqthanhtoan",
            render: function(data, type, row) {
                if (parseInt(data) > 0) {
                    return  '<span style ="display: none">1</span><i style="color:rgb(10 85 140)" class="fas fa-check"></i>'
                } else {
                    return'<span style ="display: none">0</span> <i style="color:red" class="fas fa-times"></i>';
                }
            },
        },
        {
            title:"<div>KĐK</div><div style='border-top:2px solid #dee2e6;width:100%;display: flex;justify-content: center;align-items: center;position:relative;'> <select style='height:28px; border:none;color:#8a8c8f;' id = 'search_kdk'> <option value =''></option> <option value ='1'>Đã có</option> <option value ='0'>Chưa có</option> </select> </div>",
            data: "khoadangky",
            render: function(data, type, row) {
                if (parseInt(data) > 0) {
                    return  '<span style ="display: none">1</span><i style="color:rgb(10 85 140)" class="fas fa-check"></i>'
                } else {
                    return'<span style ="display: none">0</span> <i style="color:red" class="fas fa-times"></i>';
                }
            },
        }
    ],
    columnDefs: [
        { targets: [0, 3, 4, 5, 6], className: "text-center" },
        { targets: [1, 2], className: "text-left" },
        {targets: [0], "searchable": true}
    ],
    scrollY: 420,
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
    lengthChange: true,
    searching: true,
    ordering: false,
    info: false,
    autoWidth: true,
    responsive: true,
    select: true,
    initComplete: function () {
        // Lặp qua mỗi cột để tạo các bộ lọc
        this.api().columns().every(function () {
            let column = this;
            let select = document.createElement('select');
            select.add(new Option(''));

            // Lấy dữ liệu duy nhất từ cột và thêm vào các tùy chọn của select
            column.data().unique().sort().each(function (d, j) {
                select.add(new Option(d));
            });

            // Thêm sự kiện cho select để lọc dữ liệu
            $(select).on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                column
                    .search(val ? '^' + val + '$' : '', true, false)
                    .draw();
            });

            // Thêm select vào div "selectFilters"
            $('#selectFilters').append(select);
        });
    }
});


function tt_mail_sinhvien() {
    // $("#tt_mail_sinhvien").empty();
    $("#tt_mail_sinhvien").append(
        '<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="list_mail_sv"></table>'
    );
    // var id_manhinh = $("#btt_submit_mail").attr("data-id");
    // var table = $("#list_mail_sv").DataTable({
    //     ajax: {
    //         type: "get",
    //         url: "/admin24/tt_mail_sinhvien",
    //     },
    //     // dom: '<"top"i>rCt<"footer"><"bottom"flp><"clear">',
    //     columns: [
    //         {
    //             title:"<input style = 'height: auto' class = 'check_all' type='checkbox'>" ,
    //             data: "id",
    //             render: function(data, type, row) {
    //                 return '<input style = "height: auto" class = "guimail" id_taikhoan="' + data + '" id = "guimail' + data + '" type="checkbox">';
    //             }
    //         },
    //         {title:"Email",data:"email"},
    //         {
    //             title: "Đợt",
    //             data: "dot",
    //             render: function(data, type, row) {
    //                 if (parseInt(data) > 0) {
    //                     return data;
    //                 } else {
    //                     return '<i style="color:red" class="fas fa-times"></i>';
    //                 }
    //             }
    //         },
    //         {
    //             title: "TTCN",
    //             data: "thongtincanhan",
    //             render: function(data, type, row) {
    //                 if (parseInt(data) > 0) {
    //                     return '<i style="color:rgb(10 85 140)" class="fas fa-check"></i>';
    //                 } else {
    //                     return '<i style="color:red" class="fas fa-times"></i>';
    //                 }
    //             }
    //         },
    //         {
    //             title: "NV",
    //             data: "nguyenvong",
    //             render: function(data, type, row) {
    //                 if (parseInt(data) > 0) {
    //                     return '<i style="color:rgb(10 85 140)" class="fas fa-check"></i>';
    //                 } else {
    //                     return '<i style="color:red" class="fas fa-times"></i>';
    //                 }
    //             }
    //         },
    //         {
    //             title: "KQTT",
    //             data: "kqthanhtoan",
    //             render: function(data, type, row) {
    //                 if (parseInt(data) > 0) {
    //                     return '<i style="color:rgb(10 85 140)" class="fas fa-check"></i>';
    //                 } else {
    //                     return '<i style="color:red" class="fas fa-times"></i>';
    //                 }
    //             }
    //         },
    //         {
    //             title: "KĐK",
    //             data: "khoadangky",
    //             render: function(data, type, row) {
    //                 if (parseInt(data) > 0) {
    //                     return '<i style="color:rgb(10 85 140)" class="fas fa-check"></i>';
    //                 } else {
    //                     return '<i style="color:red" class="fas fa-times"></i>';
    //                 }
    //             }
    //         }
    //     ],
    //     columnDefs: [
    //         { targets: [0, 2, 3, 4, 5, 6], className: "text-center" },
    //         {targets: [0], "searchable": true}
    //     ],
    //     scrollY: 420,
    //     language: {
    //         emptyTable: "There are no accounts to display",
    //         info: " _START_ / _END_ trên _TOTAL_",
    //         paginate: {
    //             first: "Trang đầu",
    //             last: "Trang cuối",
    //             next: "Trang sau",
    //             previous: "Trang trước",
    //         },
    //         search: "Tìm kiếm:",
    //         loadingRecords: "Đang tìm kiếm ... ",
    //         lengthMenu: "Hiện thị _MENU_",
    //         infoEmpty: "",
    //     },
    //     retrieve: true,
    //     paging: false,
    //     lengthChange: true,
    //     searching: true,
    //     ordering: false,
    //     info: false,
    //     autoWidth: true,
    //     responsive: true,
    //     select: true,
    //     initComplete: function () {
    //         // Lặp qua mỗi cột để tạo các bộ lọc
    //         this.api().columns().every(function () {
    //             let column = this;
    //             let select = document.createElement('select');
    //             select.add(new Option(''));

    //             // Lấy dữ liệu duy nhất từ cột và thêm vào các tùy chọn của select
    //             column.data().unique().sort().each(function (d, j) {
    //                 select.add(new Option(d));
    //             });

    //             // Thêm sự kiện cho select để lọc dữ liệu
    //             $(select).on('change', function () {
    //                 var val = $.fn.dataTable.util.escapeRegex(
    //                     $(this).val()
    //                 );

    //                 column
    //                     .search(val ? '^' + val + '$' : '', true, false)
    //                     .draw();
    //             });

    //             // Thêm select vào div "selectFilters"
    //             $('#selectFilters').append(select);
    //         });
    //     }
    // });


}
// tìm kiếm theo mail
$('#search_mail').on('keyup', function() {
    table.column(1).search(this.value).draw();
});
// tìm kiếm theo mail
$('#search_hoten').on('keyup', function() {
    table.column(2).search(this.value).draw();
});
// tìm kiếm theo đợt
$('#search_ttcn').on('change', function() {
    table.column(3).search(this.value).draw();
});
// tìm kiếm theo nguyện vọng
$('#search_nv').on('change', function() {
    table.column(4).search(this.value).draw();
});
// tìm kiếm theo kết quả thanh toán
$('#search_kqtt').on('change', function() {
    table.column(5).search(this.value).draw();
});
// tìm kiếm theo khóa đăng kí
$('#search_kdk').on('change', function() {
    table.column(6).search(this.value).draw();
});

$('#check_all').on('change', function() {
    $(this).prop('checked') == true ? $('.guimail').prop('checked', true): $('.guimail').prop('checked', false)
});


// tìm mẫu mail
function tim_maumail(){
    let id = $('#chonmail').val()
    if(id == 0){
        $('#tieude_maumail').val("")
        $('#nd_maumail').html("")
    }else{
        $.ajax({
            type: "get",
            url: "/admin24/tim_maumail/"+id,
            success: function(res) {
               $('#tieude_maumail').val(res.tieude)
               $('#nd_maumail').html(res.noidung)
            },
        });
    }

}


function guimail(){
    let mailall = document.getElementsByClassName("guimail");
    let noidung_mail = $('#summernote').val()
    let tieude_mail = $('#tieude_mail').val()
    let arr_json = [];
    let index_mail = 0;

    for (let i = 0; i < mailall.length; i++) {
        if ($(mailall[i]).prop("checked")) {
            arr_json.push({
                "id_nguoidung": $(mailall[i]).attr("id_taikhoan"),
                // "noidung": noidung_mail,
                // "tieude": tieude_mail,
            });
        }
    }
    $.ajax({
        type: "post",
        url: "/admin24/mail_checked",
        data: {
            arr_json: arr_json,
            noidung_mail:noidung_mail,
            tieude_mail:tieude_mail,
        },
        success: function(res) {
            if(res == 1){
                return toastr.success("Gửi mail thành công.")
            }else if(res == 0){
                return toastr.warning("Gửi mail không thành công.")
            }else{
                return toastr.warning("Gửi mail không thành công.Liên hệ admin")
            }
        },
    });
}








function guimailtest(){
    let email_test = $('#mail_test').val()
    let noidung_mail = $('#summernote').val()
    let tieude_mail = $('#tieude_mail').val()
    let id_nguoidung = $('#btt_guimailtest').attr('id_nguoidung')
    if(tieude_mail == ""){
        return toastr.warning("Vui lòng nhập tiêu đề Email!")
    }
    if(noidung_mail == ""){
        return toastr.warning("Vui lòng nhập nội dung Email!")
    }
    $.ajax({
        type: "post",
        url: "/guimail_test",
        data: {
            id_nguoidung: id_nguoidung,
            email_test: email_test,
            noidung_mail: noidung_mail,
            tieude_mail: tieude_mail,
        },
        success: function(res) {
            if(res == 1){
                return toastr.success("Gửi mail thành công.")
            }else if(res == 0){
                return toastr.warning("Gửi mail không thành công.")
            }else{
                return toastr.warning("Gửi mail không thành công.Liên hệ admin")
            }
        },
    });
}

