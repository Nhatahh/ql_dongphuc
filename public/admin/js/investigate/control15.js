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


    $('#investigate_table').hide()

    // $('#year_check').select2();
    $('#batch_investigate').select2();
    $('#major_investigate').select2();
    $('#check_investigate_seen').select2();
    $('#check_investigate_onl').select2();
    $('#check_investigate_off').select2();
    $('#check_investigate_go').select2();


    $('#batch_investigate').on('change',function(){
        insv_chart_admin($(this).val());
        $.ajax({
            url: "/admin/investigate/change_batch/"+$(this).val(),
            type:'get',
            dataType: 'json',
            success:function(data){
                $('#major_investigate').html('').select2({
                    data: data
                });
            }
        })

    });

    load_search()

    //Tìm kiếm
    $('#search_investigate').on('click',function(){
        result()

    });

    $('#clear_check').on('click',function(){
        $('#remove_load_list_reg').empty();
        $('#remove_load_list_reg').append('<table class="table table-hover text-nowrap"  id = "load_list_reg"></table>');
        load_search()
    })

    $('#close_check').on('click',function(){
        // result();
        $('#modal_check').hide('slow')
    })


    $('#investigate_excel').on('click',function(){
        var type = "xlsx"
        var id_batch = $('#batch_investigate').val()
        var data = document.getElementById('investigate_table');
        var excelFile = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
        XLSX.write(excelFile, { bookType: type, bookSST: true, type: 'base64' });
        XLSX.writeFile(excelFile, 'ThongKetXacNhanNhapHoc'+id_batch+'.'+ type);
    })

});

function excel_investigate(){
    var batch = $('#batch_investigate').val();
    var major = $('#major_investigate').val();
    var seen = $('#check_investigate_seen').val();
    var onl = $('#check_investigate_onl').val();
    var off = $('#check_investigate_off').val();
    var go = $('#check_investigate_go').val();
    window.location.href = "https://congmotcua.ctuet.edu.vn/admin/investigate/excel_investigate"+'/'+major+'/'+seen+'/'+onl+'/'+off+'/'+go
    // window.location.href = "https://xettuyentest.ctuet.edu.vn/admin/investigate/excel_investigate"+'/'+major+'/'+seen+'/'+onl+'/'+off+'/'+go
}

//Kết quả tìm kiếm
function result(){
    $('#remove_list_investigate').empty();
    // $('#remove_list_investigate').append('<table class="table table-hover text-nowrap" style = "width: 100%" id = "list_investigate"></table>');
    $('#remove_list_investigate').append('<table class="table table-bordered table-hover" style = "width: 100%;font-size:13px" id = "list_investigate"></table>');
    var batch = $('#batch_investigate').val();
    var major = $('#major_investigate').val();
    var seen = $('#check_investigate_seen').val();
    var onl = $('#check_investigate_onl').val();
    var off = $('#check_investigate_off').val();
    var go = $('#check_investigate_go').val();
    if(batch == 0){
        toastr.warning("Chọn đợt tuyển sinh")
    }else{
        var data;
        data = [major,seen,onl,off,go]
        var table = $('#list_investigate').DataTable({
            ajax: {
                type: "get",
                url: 'investigate/list_investigate',
                data:
                {
                    data: data
                },
            },
            scrollY: 450,
            columns: [
                {title: "ID",               data: 'id_user'},
                {title: "Họ và tên",        data: 'name_user'},
                {title: "Điện thoại",       data: 'phone_users'},
                // {title: "DT 2 ",       data: 'phone_users'},
                {title: "CMND/TCC",         data: 'id_card_users'},
                {title: "Email",            data: 'email_users'},
                {title: "Ngành trúng tuyển",            data: 'name_major'},
                // {title: "Đợt tuyển sinh",   data: 'name_batch'},
                {
                    title: "Đã xem",
                    data: 'id_ins',
                    render: function(data){
                        if(data == 1){
                            return '<span><small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã xem</small></span>'
                        }else{
                            return '<span><small class="badge badge-warning"><i class="fa fa-spinner"></i>&nbsp;Chưa xem</small></span>'
                        }
                    }
                },
                {
                    title: "XN Online",
                    data: 'check_end',
                    render: function(data){
                        if(data == 1){
                            return '<span><small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã xác nhận</small></span>'
                        }else{
                            return '<span><small class="badge badge-warning"><i class="fa fa-spinner"></i>&nbsp;Chưa xác nhận</small></span>'
                        }
                    }
                },

                {
                    title: "XN Trường",
                    data: 'check_user',
                    render: function(data){
                        if(data == 1){
                            return '<span><small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã xác nhận</small></span>'
                        }else{
                            return '<span><small class="badge badge-warning"><i class="fa fa-spinner"></i>&nbsp;Chưa xác nhận</small></span>'
                        }
                    }
                },
                {
                    title: "Điều tra",
                    data: 'active',
                    render: function(data){
                        var data = data.split('-')
                        if(data[0] == 1){
                            var disabled = "disabled";
                        }else{
                            var disabled = "";
                        }
                        var html = "";
                        switch (data[1]) {
                            case '0':
                                html += "<select onchange = insv_active_admin("+data[2]+") id = 'insv_active_admin"+data[2]+"' class = 'insv_active_admin' id-data = "+data[2]+" "+disabled+" style='backgruond-color: inhiert;border:none;width:100%;height:100%'>"
                                html += "<option value = '0' selected>Chọn trạng thái</option>"
                                html += "<option value = '1'>Sẽ nhập học</option>"
                                html += "<option value = '2'>Không nhập học</option>"
                                html += "</select>"
                                break;

                            case '1':
                                html += "<select onchange = insv_active_admin("+data[2]+") id = 'insv_active_admin"+data[2]+"' class = 'insv_active_admin' id-data = "+data[2]+" "+disabled+" style='backgruond-color: inhiert;border:none;width:100%;height:100%'>"
                                html += "<option value = '0'>Chọn trạng thái</option>"
                                html += "<option value = '1' selected>Sẽ nhập học</option>"
                                html += "<option value = '2'>Không nhập học</option>"
                                html += "</select>"
                                break;
                            case '2':
                                html += "<select onchange = insv_active_admin("+data[2]+") id = 'insv_active_admin"+data[2]+"' class = 'insv_active_admin' id-data = "+data[2]+" "+disabled+" style='backgruond-color: inhiert;border:none;width:100%;height:100%'>"
                                html += "<option value = '0'>Chọn trạng thái</option>"
                                html += "<option value = '1'>Sẽ nhập học</option>"
                                html += "<option value = '2' selected>Không nhập học</option>"
                                html += "</select>"
                                break;
                            default:
                                html += "<select onchange = insv_active_admin("+data[2]+") id = 'insv_active_admin"+data[2]+"' class = 'insv_active_admin' id-data = "+data[2]+" "+disabled+" style='backgruond-color: inhiert;border:none;width:100%;height:100%'>"
                                html += "<option value = '0'>Chọn trạng thái</option>"
                                html += "<option value = '1'>Sẽ nhập học</option>"
                                html += "<option value = '2'>Không nhập học</option>"
                                html += "</select>"
                                break;
                        }
                        return html;
                    }
                },
                {
                    title: "Ghi chú",
                    data: 'note',
                    render: function(data){
                        var data = data.split('-')
                        if(data[0] == 1){
                            var disabled = "disabled";
                        }else{
                            var disabled = "";
                        }
                        return '<input class = "insv_note_admin" onchange = insv_note_admin('+data[2]+') id = "insv_note_admin'+data[2]+'" id-data = '+data[2]+' '+disabled+' style="backgruond-color: inhiert;border:none;width:100%;height:100%" value = '+data[1]+'>'
                    }
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
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        })

    }
}

function luutrangthai(id){
    if($('#luutrangthai'+id).val() == 'Nhập học' || $('#luutrangthai'+id).val() == 'Không học' || $('#luutrangthai'+id).val() == 'Không liên lạc được' || $('#luutrangthai'+id).val() == '' ){
        if($('#luutrangthai'+id).val() == 'Nhập học'){
            var tranngthai = 1
        }
        if($('#luutrangthai'+id).val() == 'Không học'){
            var tranngthai = 2
        }
        if($('#luutrangthai'+id).val() == 'Không liên lạc được'){
            var tranngthai = 3
        }
        if($('#luutrangthai'+id).val() == ''){
            var tranngthai = 0
        }
        $.ajax({
            url: "/admin/investigate/save_trangthai/"+id+'/'+tranngthai,
            type:'get',
            // dataType: 'json',
            success:function(data){
                if(data == 1){
                    toastr.success("Cập nhật thành công")
                }else{
                    toastr.success("Cập nhật thất bại, vui lòng nhấn Ctrl F5, hoặc liên hệ Ban thư ký")
                }
            }
        })
    }else{
        toastr.warning("Chỉ nhập Nhập học hoặc Không liên lạc được hoặc Không học hoặc để trống")
    }
}


//Load tìm kiếm
function load_search(){
    $.ajax({
        url: "/admin/investigate/load_search",
        type:'get',
        dataType: 'json',
        success:function(data){
            // $('#year_check').html('').select2({
            //     data: data.year,
            // });
            $('#batch_investigate').html('').select2({
                data: data.batch
            });
        }
    })
}




function load_list_reg(){
    var data = [1,2]
    $('#load_list_reg').DataTable({
    ajax:    '/admin/checkuser/load_list_reg',
    dataSrc:  data,
    columns: [
        {title: "ID",               data: 'id'},
        {title: "Họ và tên",        data: 'name_user'},
        // {title: "Ngày sinh",        data: 'birth_user'},
        {title: "Điện thoại",       data: 'phone_users'},
        {title: "Email",            data: 'email_users'},
        {title: "CMND/TCC",         data: 'id_card_users'},
        {title: "Năm tuyển sinh",       data: 'course'},
        {title: "Đợt tuyển sinh",       data: 'name_batch'},

    ],
    "retrieve": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    });
    // table.ajax.reload()
}

function load_list_school(id){
    $.ajax({
        type: "get",
        url: 'checkuser/load_list_school/'+id,
        success: function (res) {
            if(res[0].fail == 0){
                var html = "";
                for(let i = 0; i<res.length ; i++){
                    html += '<tr class = "select_ed select_ed'+res[i].id_data+'" id-data = "'+res[i].id_data+'" id_school_check = "'+res[i].id_school_check+'">'
                        html +=  '<td><input id-data = "'+res[i].id_data+'" style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" class = "class_check" id="class_check" value ="'+res[i].class+'"></td>'
                        html +=  '<td><select style = "width:100%" class = "province_check province_check_null" id-data = "'+res[i].id_data+'">'
                        for(let j = 0;j<res[i].provinces.length;j++)
                        {
                            html +=  '<option value = "'+res[i].provinces[j].id+'"'+res[i].provinces[j].selected+'>'+res[i].provinces[j].name_province+'</option>'
                        }
                        html +='</select></td>'

                        html +=  '<td><select style = "width:100%;background-color:inherit" class = "school_check_null school_check school_check'+res[i].id_data+'" id-data = "'+res[i].id_data+'" >'
                        for(let j = 0;j<res[i].school.length;j++)
                        {
                            html +=  '<option value = "'+res[i].school[j].id+'" '+res[i].school[j].selected+'>'+res[i].school[j].name_school+'</option>'
                        }
                        html +='</select></td>'
                        html +=  '<td><input class = "time_area_check time_area_check_null time_area_check_sum'+res[i].id_data+'" style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" value ="'+res[i].time_area+'"></td>'
                        html +=  '<td><input class = "time_area_check'+res[i].id_data+'" disabled style = "width:100%;border:none;height: 28px;text-align:center;background-color:inherit" value ="'+res[i].id_priority_area+'"></td>'
                    html += '</tr>';
                }
            }else{
                var html = "<td style = 'color: #007bff ' colspan = '5'>Không tim thấy Trường của thí sinh</td>";
                $('#area_check').text('');
            }
            $('#load_list_school').html(html)

            setTimeout(() => {
                $('.province_check').select2();
                $('.province_check').next().find('.select2-selection').css('border', 'none')
                $('.province_check').next().find('.select2-selection').css('background-color', 'inherit')
                $('.school_check').select2();
                $('.school_check').next().find('.select2-selection').css('border', 'none')
                $('.school_check').next().find('.select2-selection').css('background-color', 'inherit')
            }, 0);
        }
    });
}

//Load Khu vực ưu tiên sau khi lưu Trường THPT
function load_area_check(id){
    $.ajax({
        type: "get",
        url: "checkuser/load_area_check/"+id,
        success: function (res) {
            $('#area_check').text(res)
        }
    });
}

function history(id){
    $('#remove_load_list_history').empty();
    $('#remove_load_list_history').append('<table class="table table-bordered table-hover"  id = "load_list_history"></table>');
    var table = $('#load_list_history').DataTable( {
        ajax: {
            type: "get",
            url: 'checkuser/load_list_history/'+id,
        },

        columnDefs: [
            { width: "3%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "47%", targets: 3 },
            { width: "15%", targets: 4 }
            ],
        // dom: 'frtip',
        columns: [
            {
                title: 'STT',
                data: 'stt',
            },
            {
                title: 'Nhân viên',
                data: 'name',
            },
            {
                title: "Chức năng",
                data: 'name_history',
            },

            {
                title: "Nội dung",
                data: 'content',
            },

            {
                title: "Thời gian",
                data: 'update_at',
            },
        ],

        scrollY: 530,
        "language": {
            "emptyTable": "Không có thao tác",
            "info": " _START_ / _END_ trên _TOTAL_ thao tác",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ thao tác",
            "infoEmpty":      "",
            },
        "retrieve": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        // "select": true,
    })
}

function insv_active_admin(id){
    var value = $('#insv_active_admin'+id).val()
    $.ajax({
        type: "post",
        url: "investigate/insv_active_admin",
        data:
        {
            id_user : id,
            value: value,
        },
        success: function (res) {
            switch (res) {
                case '0':
                    toastr.warning("Không có dữ liệu mới")
                    break;
                case '1':
                    toastr.success("Cập nhật thành công")
                    break;
                case '2':
                    toastr.warning("Có lỗi xảy ra, vui lòng load lại Trang hoặc liên hệ Admin")
                break;
                case '3':
                    toastr.warning("Thầy/Cô không phải là CVHT của ngành, nên không được cập nhật")
                break;
                case '4':
                    toastr.warning("Thí sinh đã xác nhận nhập học tại Trường, không cần điều tra tình trạng nhập học, vui lòng load lại trang")
                break;
                default:
                    break;
            }
        }
    });

}

function insv_note_admin(id){
    var value = $('#insv_note_admin'+id).val()
    $.ajax({
        type: "post",
        url: "investigate/insv_note_admin",
        data:
        {
            id_user : id,
            value: value,
        },
        success: function (res) {
            switch (res) {
                case '0':
                    toastr.warning("Không có dữ liệu mới")
                    break;
                case '1':
                    toastr.success("Cập nhật thành công")
                    break;
                case '2':
                    toastr.warning("Có lỗi xảy ra, vui lòng load lại Trang hoặc liên hệ Admin")
                break;
                case '3':
                    toastr.warning("Thầy/Cô không phải là CVHT của ngành, nên không được cập nhật")
                break;
                case '4':
                    toastr.warning("Thí sinh đã xác nhận nhập học tại Trường, không cần điều tra tình trạng nhập học, vui lòng load lại trang")
                break;
                default:
                    break;
            }
        }
    });
}

function sum_arr(arr){
    var tong = 0;
    for(let i = 0; i<arr.length;i++){
        tong = tong + Number(arr[i])
    }
    return tong;
}

function insv_chart_admin(batch){
    if(batch == 2){


        $('#investigate_chart').empty();
        $('#investigate_table').empty();
        $('#investigate_chart').append('<canvas id="add_investigate_chart" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>');
        setTimeout(() => {
            $.ajax({
                type: "get",
                url: "investigate/insv_chart_admin/"+batch,
                success: function (res) {
                    var major = [], chitieu = [],  trungtuyen = [], online = [],offline = []
                    for(let i = 0;i<res.length;i++){
                        major[i] = res[i]['name_major']
                        chitieu[i] = res[i]['chitieu']
                        trungtuyen[i] = res[i]['trungtuyen']
                        online[i] = res[i]['online']
                        offline[i] = res[i]['offline']
                    }
                    var ctx = document.getElementById('add_investigate_chart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        data: {
                            labels: major,
                            datasets: [
                                {
                                    label: 'Chỉ tiêu',
                                    data: chitieu,
                                    backgroundColor: [
                                        'rgba(139, 0, 22,1)',
                                    ],
                                    borderColor: [
                                        'rgba(139, 0, 22,1)',
                                    ],
                                    borderWidth: 1,
                                    type: 'line',
                                    stack: 'Stack 0',
                                    datalabels:{
                                        anchor: 'center',
                                        align: 'left',
                                        color: 'black',
                                        font: {
                                            weight: 'bold',
                                            size: '13pt'
                                        }
                                    },
                                },

                                {
                                    label: 'Trúng tuyển',
                                    data: trungtuyen,
                                    backgroundColor: [
                                        'rgba(197, 0, 35,1)',
                                    ],
                                    borderColor: [
                                        'rgba(197, 0, 35,1)',
                                    ],
                                    borderWidth: 1,
                                    type: 'bar',
                                    stack: 'Stack 1',
                                    datalabels:{
                                        anchor: 'center',
                                        align: 'center',
                                        color: 'white',
                                        font: {
                                            weight: 'bold',
                                            size: '13pt'
                                        }
                                    },
                                },

                                {
                                    label: 'Xác nhận Online',
                                    data: online,
                                    backgroundColor: [
                                        'rgba(229, 70, 70,1)',
                                    ],
                                    borderColor: [
                                        'rgba(229, 70, 70,1)',
                                    ],
                                    borderWidth: 1,
                                    type: 'bar',
                                    stack: 'Stack 2',
                                    datalabels:{
                                        anchor: 'center',
                                        align: 'center',
                                        color: 'white',
                                        font: {
                                            weight: 'bold',
                                            size: '13pt'
                                        }
                                    },
                                },

                                {
                                    label: 'Xác nhận Offline',
                                    data: offline,
                                    backgroundColor: [
                                        'rgba(0, 0, 255,1)',
                                    ],
                                    borderColor: [
                                        'rgba(0, 0, 255,1)'
                                    ],
                                    borderWidth: 1,
                                    type: 'bar',
                                    stack: 'Stack 3',
                                    datalabels:{
                                        anchor: 'center',
                                        align: 'center',
                                        color: 'white',
                                        font: {
                                            weight: 'bold',
                                            size: '13pt'
                                        }
                                    },
                                },

                            ]

                        },
                        options: {
                            legend: {
                                labels: {
                                    fontColor: "white",
                                    fontSize: 18
                                }
                            },
                            responsive              : true,
                            maintainAspectRatio     : false,
                            datasetFill             : false,
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                  stacked: true,

                                }
                            }
                        },
                        plugins: [ChartDataLabels],
                    });


                    major.push("Tổng")
                    chitieu.push(sum_arr(chitieu));
                    trungtuyen.push(sum_arr(trungtuyen));
                    online.push(sum_arr(online));
                    offline.push(sum_arr(offline));
                    var html = ""
                    html += "<table>"
                        html += "<thead>"
                            html += "<th>STT</th>"
                            html += "<th>Ngành tuyển sinh</th>"
                            html += "<th>Chỉ tiêu</th>"
                            html += "<th>Trúng tuyển</th>"
                            html += "<th>Xác nhận online</th>"
                            html += "<th>Xác nhận Offline</th>"
                            html += "<th>Xác nhận Offline/Chỉ tiêu</th>"
                        html += "</thead>"
                        html += " <tbody>"
                        for(let i = 0;i<1+res.length;i++){
                            html += "<tr>"
                                var stt = i+1
                                html += "<td>"+stt+"</td>"
                                html += "<td>"+major[i]+"</td>"
                                html += "<td>"+chitieu[i]+"</td>"
                                html += "<td>"+trungtuyen[i]+"</td>"
                                html += "<td>"+online[i]+"</td>"
                                html += "<td>"+offline[i]+"</td>"
                                var tile = Math.round(offline[i]/chitieu[i]*1000)/10
                                html += "<td>"+tile+"</td>"
                            html += "</tr>"
                        }
                        html += "</tbody>"
                    html += "</table>"
                    $('#investigate_table').html(html)





                }
            })
        }, 100);

    }else{
        $('#investigate_chart').empty();
        $('#investigate_table').empty();
    }
}



