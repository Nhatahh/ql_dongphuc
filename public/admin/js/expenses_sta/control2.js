
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    if($(document).width() > 992){
        $('#right_check').css('min-height','630px')
        $('#left_check').css('min-height','630px')
    }else{
        $('#right_check').css('min-height','0x')
        $('#left_check').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check').css('min-height','630px')
            $('#left_check').css('min-height','630px')
        }else{
            $('#right_check').css('min-height','0x')
            $('#left_check').css('min-height','0px')
        }
    });

    $('#year_ex_sta').select2();
    $('#form_ex_sta').select2();
    $('#user_ex_sta').select2();
    // $('.excel_ex_sta').hide();


   // Load Search
    load_search_sta()
    load_list_infor()





    //Tìm kiếm
    $('#search_ex_sta').on('click',function(){
        result()
    });


    //Clear
    $('#clear_ex_sta').on('click',function(){
        $('#remove_load_list_ex').empty();
        $('#remove_load_list_ex').append('<table class="table table-hover text-nowrap"  id = "load_list_ex"></table>');
        $('#remove_load_list_ex1').empty();
        $('#remove_load_list_ex1').append('<table class="table table-hover text-nowrap"  id = "load_list_ex1"></table>');
        load_search_sta()
    })


  //Xuaat exel
  $('#excel_ex_sta').on('click',function(){
    var a = $('#load_list_ex1_wrapper').find('.buttons-excel').click()
});


});
// //Load thông tin tìm kiếm


// //Kết quả tìm kiếm
function result(){
    $('#remove_load_list_ex').empty();
    $('#remove_load_list_ex').append('<table class="table table-hover text-nowrap"  id = "load_list_ex"></table>');
    $('#remove_load_list_ex1').empty();
    $('#remove_load_list_ex1').append('<table class="table table-hover text-nowrap"  id = "load_list_ex1"></table>');
    var year = $('#year_ex_sta').val();
    var form = $('#form_ex_sta').val();
    var user = $('#user_ex_sta').val();
    var day = $('#day_ex_sta').val();

    if(year == 0){
        toastr.warning("Chọn năm tuyển sinh")
    }else{
        var data;
        data = [year,form,user,day]
        var table = $('#load_list_ex').DataTable( {
            ajax: {
                type: "get",
                url: 'expenses_sta/load_list_ex',
                data:
                {
                    data: data
                },
            },
            columns: [
                {title: "ID",               data: 'id_user'},
                {title: "Họ và tên",        data: 'name_user'},
                {title: "Ngày sinh",        data: 'birth_user'},
                {title: "Điện thoại",       data: 'phone_users'},
                {title: "CMND/TCC",         data: 'id_card_users'},
                {title: "Số tiền",          data: 'price'},
                {title: "Người thu",        data: 'name'},
                {title: "Ngày thu",         data: 'create_at'},
                {title: "Hình thức",        data: 'form_check1'},
            ],

            "language": {
                "emptyTable": "Không tìm thấy thí sinh",
                "info": " _START_ / _END_ trên _TOTAL_ thí sinh",
                "paginate": {
                    "first":      "Trang đầu",
                    "last":       "Trang cuối",
                    "next":       "Trang sau",
                    "previous":   "Trang trước"
                },
                "search":         "Tìm kiếm:",
                "loadingRecords": "Đang tìm kiếm ... ",
                "lengthMenu":     "Hiện thị _MENU_ thí sinh",
                "infoEmpty":      "",
                },
            "retrieve": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        })

        var table1 = $('#load_list_ex1').DataTable( {
            ajax: {
                type: "get",
                url: 'expenses_sta/load_list_ex',
                data:
                {
                    data: data
                },
            },
            columns: [
                {title: "ID",               data: 'id_user'},
                {title: "Họ và tên",        data: 'name_user'},
                {title: "Ngày sinh",        data: 'birth_user'},
                {title: "Điện thoại",       data: 'phone_users'},
                {title: "CMND/TCC",         data: 'id_card_users'},
                {title: "Số tiền",          data: 'price'},
                {title: "Người thu",        data: 'name'},
                {title: "Ngày thu",         data: 'create_at'},
                {title: "Hình thức",        data: 'form_check1'},

            ],
            "dom": 'B',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],


            "language": {
                "emptyTable": "Không tìm thấy thí sinh",
                "info": " _START_ / _END_ trên _TOTAL_ thí sinh",
                "paginate": {
                    "first":      "Trang đầu",
                    "last":       "Trang cuối",
                    "next":       "Trang sau",
                    "previous":   "Trang trước"
                },
                "search":         "Tìm kiếm:",
                "loadingRecords": "Đang tìm kiếm ... ",
                "lengthMenu":     "Hiện thị _MENU_ thí sinh",
                "infoEmpty":      "",
                },
            "retrieve": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "responsive": true,

        })

    }
}

// //Load tìm kiếm
function load_search_sta(){
    $.ajax({
        url: "/admin/expenses_sta/load_search_sta",
        type:'get',
        dataType: 'json',
        success:function(data){
            $('#year_ex_sta').html('').select2({
                data: data.year,
            });
            $('#user_ex_sta').html('').select2({
                data: data.user
            });

        }
    })
}

//Load Tra cứu thông tin

function load_list_infor(){
    $('#remove_load_list_infor').empty();
    $('#remove_load_list_infor').append('<table class="table table-hover text-nowrap"  id = "load_list_infor"></table>');
    var table = $('#load_list_infor').DataTable( {
        ajax: {
            type: "get",
            url: 'expenses_sta/load_list_infor',
        },
        columns: [
            {title: "ID",               data: 'id_user'},
            {title: "Họ và tên",        data: 'name_user'},
            {title: "CMND/TCC",         data: 'id_card_users'},
            {title: "SDT",              data: 'phone_users'},

        ],

        "language": {
            "emptyTable": "Không tìm thấy thí sinh",
            "info": " _START_ / _END_ trên _TOTAL_ thí sinh",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Sau",
                "previous":   "Trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ thí sinh",
            "infoEmpty":      "",
            },
        "retrieve": true,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "responsive": true,
    })
    $('#load_list_infor_filter').parent().removeClass('col-md-6');
    $('#load_list_infor_filter').parent().addClass('col-md-12');
}



