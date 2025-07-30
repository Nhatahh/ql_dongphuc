$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if($(document).width() > 992){
        $('#right_check_user').css('min-height','760px')
        $('#left_check_user').css('min-height','760px')
    }else{
        $('#right_check_user').css('min-height','0x')
        $('#left_check_user').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_check_user').css('min-height','760px')
            $('#left_check_user').css('min-height','760px')
        }else{
            $('#right_check_user').css('min-height','0x')
            $('#left_check_user').css('min-height','0px')
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


    // $('#investigate_table').hide()

    $('#elect_batch').select2();
    $('#elect_major').select2();
    $('#elect_year').select2();
    $('#elect_method').select2();
    $('#elect_hktt').select2();

    $('#elect_year').on('change',function(){
        list_elect();
    });
    $('#elect_hktt').on('change',function(){
        list_elect();
    });
    $('#elect_batch').on('change',function(){
        list_elect();
    });
    $('#elect_method').on('change',function(){
        list_elect();
    });
    $('#elect_major').on('change',function(){
        list_elect();
    });
    $('#elect_id_card').on('change',function(){
        list_elect();
    });
    $('#elect_id').on('change',function(){
        list_elect();
    });

    $('#type_top2').on('change',function(){
        list_elect();
    });

    $('#type_top1').on('change',function(){
        list_elect();
    });

    load_search()

    $('#elect_exp').on('click',function(){
        var elect_year = $('#elect_year').val();
        var elect_batch = $('#elect_batch').val();
        var elect_method = $('#elect_method').val();
        var elect_major = $('#elect_major').val();
        var elect_id_card = $('#elect_id_card').val();
        var elect_id = $('#elect_id').val();
        var elect_hktt = $('#elect_hktt').val();
        if(elect_id_card == ""){
            elect_id_card = 0;
        }else{
            elect_id_card = elect_id_card;
        }
        if(elect_id == ""){
            elect_id = 0;
        }else{
            elect_id = elect_id;
        }
        var type_tops =  document.getElementsByClassName('type_top')
        var j = 0;
        for(let i = 0; i <type_tops.length; i++){
            if($(type_tops[i]).prop('checked') ==  true){
                var type_top = $(type_tops[i]).attr('id-data')
                j++
                break;
            }
        }
        if( j >0){
            var type_top = type_top
        }else{
            var type_top = 0
        }

        window.location.href = "https://congmotcua.ctuet.edu.vn/admin/admission/elect_exp"+'/'+elect_year+'/'+elect_batch+'/'+elect_method+'/'+elect_major+'/'+elect_id_card+'/'+elect_id+'/'+elect_hktt+'/'+type_top

        // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/admission/elect_exp"+'/'+elect_year+'/'+elect_batch+'/'+elect_method+'/'+elect_major+'/'+elect_id_card+'/'+elect_id+'/'+elect_hktt+'/'+type_top

    });

    $('#elect_ttsv').on('click',function(){
        $("#modal_loadding_elect").show();
        var elect_year = $('#elect_year').val();
        var elect_batch = $('#elect_batch').val();
        var elect_method = $('#elect_method').val();
        var elect_major = $('#elect_major').val();
        var elect_id_card = $('#elect_id_card').val();
        var elect_id = $('#elect_id').val();
        var elect_hktt = $('#elect_hktt').val();
        if(elect_id_card == ""){
            elect_id_card = 0;
        }else{
            elect_id_card = elect_id_card;
        }
        if(elect_id == ""){
            elect_id = 0;
        }else{
            elect_id = elect_id;
        }

        window.location.href = "https://congmotcua.ctuet.edu.vn/admin/admission/elect_ttsv"+'/'+elect_year+'/'+elect_batch+'/'+elect_method+'/'+elect_major+'/'+elect_id_card+'/'+elect_id+'/'+elect_hktt;

        setTimeout(() => {
            $("#modal_loadding_elect").hide();
        }, 10000);


        // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/admission/elect_ttsv"+'/'+elect_year+'/'+elect_batch+'/'+elect_method+'/'+elect_major+'/'+elect_id_card+'/'+elect_id+'/'+elect_hktt;


    });

});

//Load tìm kiếm
function load_search(){
    $.ajax({
        url: "/admin/admission/load_search",
        type:'get',
        dataType: 'json',
        success:function(data){
            $('#elect_batch').html('').select2({
                data: data.batch
            });
            $('#elect_major').html('').select2({
                data: data.major
            });
            $('#elect_year').html('').select2({
                data: data.year
            });
            $('#elect_method').html('').select2({
                data: data.method
            });
            $('#elect_hktt').html('').select2({
                data: data.hktt
            });
        }
    })
}


//Kết quả tìm kiếm
function list_elect(){
    if( $('#elect_year').val() == 0){
        toastr.warning("Chọn năm tuyển sinh")
        $('#remove_list_elect').empty();
    }else{
        $('#remove_list_elect').empty();
        $('#remove_list_elect').append('<table class="table table-bordered table-hover" style = "width: 100%;font-size:13px" id = "list_elect"></table>');
        var elect_year = $('#elect_year').val();
        var elect_batch = $('#elect_batch').val();
        var elect_method = $('#elect_method').val();
        var elect_major = $('#elect_major').val();
        var elect_id_card = $('#elect_id_card').val();
        var elect_id = $('#elect_id').val();
        var elect_hktt = $('#elect_hktt').val();
        var type_tops =  document.getElementsByClassName('type_top')

        var j = 0;
        for(let i = 0; i <type_tops.length; i++){
            if($(type_tops[i]).prop('checked') ==  true){
                var type_top = $(type_tops[i]).attr('id-data')
                j++
                break;
            }
        }
        if( j >0){
            var type_top = type_top
        }else{
            var type_top = 0
        }
        var data;
        data = [elect_year,elect_batch,elect_method,elect_major,elect_id_card,elect_id,type_top,elect_hktt]
        var table = $('#list_elect').DataTable({
            ajax: {
                type: "get",
                url: 'admission/list_elect',
                data:
                {
                    data: data
                },
            },
            scrollY: 450,
            columns: [
                { title: "STT",               data: 'stt'},
                {title: "ID",               data: 'id_user'},
                {title: "Họ và tên",        data: 'name_user'},
                {title: "CMND/TCC",         data: 'id_card_users'},
                {title: "Phương thức",         data: 'name_method'},
                {title: "Ngành trúng tuyển",            data: 'name_major'},
                {title: "Điểm XT",            data: 'mark'},
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'dt-body-center'
                },
                {
                    targets: 1,
                    className: 'dt-body-center'
                },
                {
                    targets: 2,
                    className: 'dt-body-center'
                },
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
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": false,
        })
    }

}

function elect_checkall(){
    if($('#elect_checkall').prop('checked') == true){
        $('.elect_check').attr('checked',true)
    }else{
        $('.elect_check').attr('checked',false)
    }
}

// function load_admin_sig(){
//     $.ajax({
//         url: "/admin/qlsv_nvqs/load_admin_sig",
//         type:'get',
//         dataType: 'json',
//         success:function(data){
//             // $('#year_check').html('').select2({
//             //     data: data.year,
//             // });
//             $('#load_admin_sig').html('').select2({
//                 data: data
//             });
//         }
//     })
// }


function elect_print(){
    var major = $('#elect_major').val();
    var batch = $('#elect_batch').val();

    if(major == 0 || $('#remove_list_elect').html() == "" || batch == 0){
        toastr.warning("Chưa chọn đợt tuyển sinh và ngành đào tạo")
    }else{
        var elect_sig = $('#elect_sig').val();
        var checks = document.getElementsByClassName('elect_check')
        var check = [];
        var j = 0;
        for (let i = 0; i < checks.length; i++) {
            if($(checks[i]).prop('checked') == true){
                check[j] =  $(checks[i]).attr('id-data')
                j++;
            }
        }

        if(check.length == 0){
            toastr.warning("Chọn thí sinh để in")
            where = 0;
        }else{
            var where = '';
            var j = 0;
            for (let i = 0; i < check.length; i++) {
                where += check[i];
                if(j < check.length - 1){
                    where += ',';
                }
                j++;
            }
            var where_base = btoa(where)
            // window.open('https://xettuyentest.ctuet.edu.vn/admin/elect/elect_print'+'/'+where_base+'/'+elect_sig,'_blank')
            window.open('https://congmotcua.ctuet.edu.vn/admin/elect/elect_print'+'/'+where_base+'/'+elect_sig,'_blank')
        }
    }
}






