$(document).ready(function () {
    $('#import_dotts').select2();
    load_ketquahoctap(0,0,0).ajax.url("/admin24/import_loadketquahoctap/0/0/0").load();
})

    //Import điểmt thi THPT
    function open_ketquahoctap(){
        $('#ketquahoctap').click();
    }
    function import_ketquahoctap(){
        $('#submit_ketquahoctap').submit();
    }
    $('#submit_ketquahoctap').on('submit', function(e){
        e.preventDefault();
        if($('#ketquahoctap').val() == ""){
            thongbao('imp_2')
        }else{
            var kiemtradinhdang = kiemtrafileupload('ketquahoctap',1)
            if(kiemtradinhdang != 1){
                thongbao(kiemtradinhdang)
            }else{
                $.ajax({
                    url: "/admin24/submit_ketquahoctap",
                    type:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data){
                        thongbao(data)
                        load_ketquahoctap().ajax.url("/admin24/import_loadketquahoctap/0/0/0").load();
                    }
                });
            }
        }
    });

    function kiemtrasoluongthisinh(import_dotts,import_start_id,import_end_id){
        var difference = import_end_id - import_start_id;
        var step = 500;
        if(difference > step || difference < 0 || import_start_id <= 0 || import_end_id <= 0 || import_dotts == 0 ){
            return step;
        }else{
            return 1
        }
    }

    function export_ketquahoctap(){
        var import_end_id = $('#import_end_id').val()
        var import_start_id = $('#import_start_id').val()
        var import_dotts = $('#import_dotts').val()
        var soluong = kiemtrasoluongthisinh(import_dotts,import_start_id,import_end_id)
        alert(soluong)
        if(soluong == 1){
            window.location.href = "/admin24/export_ketquahoctap/"+import_dotts+"/"+import_start_id+"/"+import_end_id;
        }else{
            toastr.warning('Vui lòng không chọn số lượng thí sinh, không chọn nhiều hơn '+soluong+' thisinh, chọn đợt tuyển sinh');
        }
    }

    function load_ketquahoctap(import_start_id,import_end_id){
        $('#remove_import_loadketquahoctap').empty();
        $('#remove_import_loadketquahoctap').append('<table class="table table-bordered table-hover table-striped dataTable no-footer dtr-inline" id="import_loadketquahoctap"></table>');
        var dotts = $('#import_dotts').val()
        var myDataTable = $("#import_loadketquahoctap").DataTable({
            processing: true,
            // serverSide: true,
            deferRender: true,
            ajax: "/admin24/import_loadketquahoctap/"+dotts+"/"+import_start_id+"/"+import_end_id,
            columns: [
                {
                    title: "STT",
                    className: 'text-center',
                    data: "thutu",
                },
                {
                    name: "id_taikhoan",
                    className: 'text-center',
                    title: "ID",
                    data: "id_taikhoan",
                },
                {
                    name: "hoten",
                    title: "Họ và tên",
                    data: "hoten",
                },
                {
                    name: "cccd",
                    title: "CCCD/CMND",
                    data: "cccd",
                },
                {
                    name: "lop",
                    title: "Lớp",
                    data: "lop",
                },
                {
                    name: "hocki",
                    title: "HK",
                    data: "hocki",
                },
                {
                    name: "mon",
                    title: "Môn",
                    data: "mon",
                },
                {
                    name: "diem",
                    title: "Điểm",
                    data: "diem",
                },
            ],

            // columnDefs: [
            //     {
            //         targets: [0, 1, 2,3,4,5,7,8,9,10,11,12],
            //         orderable: false
            //         // className: "text-center"
            //     },
            // ],
            scrollY: 400,
            language: {
                emptyTable: "Không tìm thấy thí sinh",
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


    function search_ketquahoctap(){
        var import_end_id = $('#import_end_id').val()
        var import_start_id = $('#import_start_id').val()
        var import_dotts = $('#import_dotts').val()
        var soluong = kiemtrasoluongthisinh(import_dotts,import_start_id,import_end_id)
        if(soluong == 1){
            load_ketquahoctap().ajax.url("/admin24/import_loadketquahoctap/"+import_dotts+"/"+import_start_id+"/"+import_end_id).load();
        }else{
            toastr.warning('Vui lòng không chọn số lượng thí sinh, không chọn nhiều hơn '+soluong+' thisinh, chọn đợt tuyển sinh');
        }
    }
