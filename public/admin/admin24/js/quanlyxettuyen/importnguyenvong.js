$(document).ready(function () {
    $('#import_nguyenvong').select2();
    import_loadnguyenvongxettuyen().ajax.url("/admin24/import_loadnguyenvongxettuyen/0").load();
})

    //Import nguyện vong xét tuyển
    function open_nguyenvongxettuyen(){
        $('#nguyenvongxettuyen').click();
    }
    function import_nguyenvongxettuyen(){
        $('#submit_nguyenvongxettuyen').submit();
    }
    $('#submit_nguyenvongxettuyen').on('submit', function(e){
        e.preventDefault();
        if($('#nguyenvongxettuyen').val() == ""){
            thongbao('imp_2')
        }else{
            var kiemtradinhdang = kiemtrafileupload('nguyenvongxettuyen',1)
            if(kiemtradinhdang != 1){
                thongbao(kiemtradinhdang)
            }else{
                $.ajax({
                    url: "/admin24/submit_nguyenvongxettuyen",
                    type:"POST",
                    data: new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data){
                        thongbao(data)
                        var dotts = $('#import_nguyenvong').val()
                        import_loadnguyenvongxettuyen().ajax.url("/admin24/import_loadnguyenvongxettuyen/"+dotts).load();
                    }
                });
            }
        }
    });

    // function kiemtrasoluongthisinh(import_dotts,import_start_id,import_end_id){
    //     var difference = import_end_id - import_start_id;
    //     var step = 500;
    //     if(difference > step || difference < 0 || import_start_id <= 0 || import_end_id <= 0 || import_dotts == 0 ){
    //         return step;
    //     }else{
    //         return 1
    //     }
    // }

    function import_loadnguyenvongxettuyen(){
        var dotts = $('#import_nguyenvong').val()
        var myDataTable = $("#import_loadnguyenvongxettuyen").DataTable({
            processing: true,
            // serverSide: true,
            deferRender: true,
            ajax: "/admin24/import_loadnguyenvongxettuyen/"+dotts,
            columns: [
                {
                    title: "STT",
                    className: 'text-center',
                    data: "stt",
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
                    name: "thutu",
                    title: "TTNV",
                    data: "thutu",
                },
                {
                    name: "nganh",
                    title: "Ngành xét tuyển",
                    data: "nganh",
                },
                {
                    name: "phuongthuc",
                    title: "PT",
                    data: "phuongthuc",
                },
                {
                    name: "tohop",
                    title: "TH",
                    data: "tohop",
                },
                {
                    name: "diemtohop",
                    title: "ĐTH",
                    data: "diemtohop",
                },
                {
                    name: "diemuutien",
                    title: "ĐUT",
                    data: "diemuutien",
                },
                {
                    name: "diemxettuyen",
                    title: "ĐXT",
                    data: "diemxettuyen",
                },
                {
                    name: "tts",
                    title: "TTS",
                    data: "tts",
                },
            ],

            columnDefs: [
                {
                    targets: [0,2,3,4,6,7,8,9],
                    orderable: false,
                    className: "text-center"
                },
                {
                    targets: [10,11],
                    className: "text-center"
                },
            ],
            scrollY: 400,
            language: {
                emptyTable: "Không tìm thấy nguyện vọng",
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


    function search_nguyenvongxettuyen(){
        var dotts = $('#import_nguyenvong').val()
        import_loadnguyenvongxettuyen().ajax.url("/admin24/import_loadnguyenvongxettuyen/"+dotts).load();
    }

    function export_nguyenvongxettuyen(){
        // var dotts = $('#import_nguyenvong').val()
        // $.ajax({
        //     type: "post",
        //     url: "/admin24/export_nguyenvongxettuyen_kiemtrasoluong/"+dotts,
        //     success:function(res){
        //         alert(res);
        //         var start = 0
        //         var step = 5000;
        //         for (let i = 0; i < res; i++) {
        //             const element = array[i];

        //         }
        //         do {
        //             window.location.href = "/admin24/export_nguyenvongxettuyen/"+dotts+"/"+start+"/"+(start+step);
        //             start = start+step;
        //         } while (start < res);
        //     }
        // });
    }
    function cal_nguyenvongxettuyen(){
        var cal_start_id = $('#cal_start_id').val()
        var cal_end_id = $('#cal_end_id').val()
        var dotts = $('#import_nguyenvong').val()
        $('#modal_event').show();
        if(cal_start_id == '' || cal_end_id == '' || dotts == 0){
            toastr.warning("Vui lòng chọn id thí sinh và đợt tuyển sinh")
        }else{
            $.ajax({
                type: "post",
                url: "/admin24/cal_nguyenvongxettuyen",
                data: {
                    start: cal_start_id,
                    end: cal_end_id,
                    dotts: dotts,
                },
                success:function(res){
                    $('#modal_event').hide('fast');
                    thongbao(res)
                    var dotts = $('#import_nguyenvong').val()
                    import_loadnguyenvongxettuyen().ajax.url("/admin24/import_loadnguyenvongxettuyen/"+dotts).load();
                }
            });
        }

    }

