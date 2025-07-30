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

    chart_reg_sta()
})

//Load biểu dồ dawgnd ký
function chart_reg_sta(){
    $.ajax({
        type: "get",
        url: 'reg_sta/barChart_reg_sta',
        success: function (res) {
            var major = [],number = [],number2 = []
            for(let i = 0;i<res.length;i++){
                major[i] = res[i][1]
                number[i] = res[i][2]
                number2[i] = res[i][3]
            }
            var ctx = document.getElementById('barChart').getContext('2d');
            var myChart = new Chart(ctx, {
                data: {
                    labels: major,
                    datasets: [
                        {
                            label: 'Chỉ tiêu',
                            data: number2,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1,
                            type: 'bar'
                        },
                        {
                            label: 'Số lượng đăng ký',
                            data: number,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1,
                            type: 'bar',
                        },
                    ]
                },
                options: {
                    responsive              : true,
                    maintainAspectRatio     : false,
                    datasetFill             : false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
                plugins: [ChartDataLabels],
            });
        }
    });


}


//     //Load nhân viên đã phân công
//     load_search_ass()
//     // load_list_assstudent()
//     load_search()

//     $('#load_list_assuser tbody').on('click','tr',function(){
//         var id = $(this).children().find('.id_user_check_ass').attr('id-student');
//         $('#load_list_assuser tr').removeClass('select_background')
//         setTimeout(() => {
//             $('.check_user_assuser').attr('id-user-new',id)
//             $(this).addClass('select_background')
//         }, 0);
//     })


//     $('#search_check_ass').on('click',function(){
//         if($('#year_check_ass').val() == 0){
//             toastr.warning("Chọn năm tuyển sinh")
//         }else{
//             load_list_assstudent()
//         }

//     })

//     $('#clear_check_ass').on('click',function(){
//         $('#remove_load_list_assstudent').empty();
//         // $('#remove_load_list_reg').append('<table class="table table-hover text-nowrap"  id = "load_list_reg"></table>');
//         load_search()
//     })
// })

// function load_search(){
//     $.ajax({
//         url: "assuser/load_search",
//         type:'get',
//         // dataType: 'json',
//         success:function(data){
//             $('#year_check_ass').html('').select2({
//                 data: data.year,
//             });
//             $('#batch_check_ass').html('').select2({
//                 data: data.batch
//             });
//             $('#active_check_ass').html('').select2({
//                 data: [
//                     {id: 0, text: "Chọn trạng thái"},
//                     {id: 1, text: "Chưa phân công"},
//                     {id: 2, text: "Đã phân công"},
//                 ]
//             });
//             $('#block_check_ass').html('').select2({
//                 data: [
//                     {id: 0, text: "Chọn tình trạng"},
//                     {id: 1, text: "Chưa kiểm tra hồ sơ"},
//                     {id: 2, text: "Đã gửi phản hồi"},
//                     {id: 3, text: "Đã kiểm tra hồ sơ"},
//                     {id: 4, text: "Đã đăng ký lại"},
//                 ]
//             });
//             $('#user_check_ass').html('').select2({
//                 data: data.user
//             });

//             $('#pass_check_ass').html('').select2({
//                 data: [
//                     {id: 0, text: "Chọn tình trạng"},
//                     {id: 1, text: "Chưa duyệt"},
//                     {id: 2, text: "Đã duyệt"},
//                 ]
//             });

//         }
//     })
// }


// function add_ass_user_student(id_user,id_student,active,id_check){
//     $.ajax({
//         type: "post",
//         url: 'assuser/add_ass_user_student',
//         data: {
//             id_user:id_user,
//             id_student: id_student,
//             active: active,
//             id_check: id_check,
//         },
//     }).done(function(res){
//         // alert(11111111111)
//         // alert(res.sus)
//         if(res == 3){
//             toastr.warning("Hồ sơ đã kiểm tra và khóa, không được phân công lại")
//         }else{
//             if(res.sus == 1 || res.sus ==2){
//                 toastr.success("Đã cập nhật")
//                 $('.user_check_ass'+id_student).text(res.name)
//                 $('.user_assuser'+id_student).attr('id-user',res.id_user)
//                 $('.user_assuser'+id_student).attr('id-check',res.id_check)
//                 $('.update_at_ass'+id_student).text(res.update_at)
//                 $('.del_assuser_check'+id_student).attr('id-check',res.id_check)
//                 $('.check_ass_student'+id_student).css('color','black')
//                 $('.check_ass_student'+id_student).attr('id-active-user',0)
//                 $('.check_ass_student'+id_student).attr('id-check',res.id_check)
//             }else{
//                 toastr.warning("Có lỗi, vui lòng load lại, hoặc nhấn Ctrl F5")
//             }
//             if(res.sus == 1){
//                 $('.user_assuser'+id_student).css('color','#007bff')
//                 $('.user_assuser'+id_student).attr('active',1)
//             }
//             if(res.sus == 2){
//                 $('.user_assuser'+id_student).css('color','red')
//                 $('.user_assuser'+id_student).attr('active',0)
//             }
//         }
//     })
// }


//     //Load danh sách nhân viên
//     function load_search_ass(){
//         $('#remove_load_list_assuser').empty();
//         $('#remove_load_list_assuser').append('<table class="table table-hover text-nowrap"  id = "load_list_assuser"></table>');
//         var table = $('#load_list_assuser').DataTable( {
//             ajax: {
//                 type: "get",
//                 url: 'assuser/load_list_ass',
//             },

//             dom: 'frtip',
//             columns: [
//                 {
//                     title: "ID",
//                     data: 'id',
//                     render: function(data){
//                         return '<span class ="id_user_check_ass" id-student = '+data+'>'+data+'</span>'
//                     }
//                 },
//                 {
//                     title: "Họ và tên",
//                     data: 'name',
//                 },
//                 {
//                     title: "",
//                     data: 'id',
//                     render: function(data){
//                         return '<i id-active-user = "0" id-user="'+data+'" onclick = "ass_user('+data+')" class="fas fa-edit ass_user active_ass_check'+data+'"></i>'
//                     }
//                 },
//             ],
//             scrollY: 200,
//             "language": {
//                 "emptyTable": "Không có nhân viên",
//                 "info": " _START_ / _END_ trên _TOTAL_ nhân viên",
//                 "paginate": {
//                     "first":      "Trang đầu",
//                     "last":       "Trang cuối",
//                     "next":       "Trang sau",
//                     "previous":   "Trang trước"
//                 },
//                 "search":         "Tìm kiếm:",
//                 "loadingRecords": "Đang tìm kiếm ... ",
//                 "lengthMenu":     "Hiện thị _MENU_ nhân viên",
//                 "infoEmpty":      "",
//                 },
//             "retrieve": true,
//             "paging": false,
//             "lengthChange": false,
//             "searching": true,
//             "ordering": false,
//             "info": false,
//             "autoWidth": true,
//             "responsive": true,
//             "select": true,
//         })
//     }

//     function load_list_assstudent(){

//         var id_year = $('#year_check_ass').val()
//         var id_batch = $('#batch_check_ass').val()
//         var user = $('#user_check_ass').val();

//         var ass = $('#active_check_ass').val();
//         var check = $('#block_check_ass').val();
//         var pass = $('#pass_check_ass').val();


//         var day = $('#day_ess').val();
//         if(day == ""){
//             var day =  0
//         }else{
//             var day =  day
//         }

//         var day_reg = $('#day_reg_ess').val();
//         if(day_reg == ""){
//             var day_reg =  0
//         }else{
//             var day_reg =  day_reg
//         }

//         $('#remove_load_list_assstudent').empty();
//         $('#remove_load_list_assstudent').append('<table class="table table-hover text-nowrap"  id = "load_list_assstudent"></table>');

//         var table = $('#load_list_assstudent').DataTable( {
//             ajax: {
//                 type: "get",
//                 url: 'assuser/load_list_assstudent/'+id_year+'/'+id_batch+'/'+day+'/'+day_reg+'/'+user+'/'+ass+'/'+check+'/'+pass
//             },

//             // dom: 'frtip',
//             columns: [
//                 {
//                     title: '<i id-active = "0" onclick = "check_ass_stu_all()" class="fas fa-edit" id = "check_ass_stu_all"></i>',
//                     data: 'active',
//                     render: function(data){
//                         var data = data.split('-')
//                         return '<i onclick = "ass_student('+data[0]+')" id-active-user = "0" id-check = "'+data[3]+'" id-student = "'+data[0]+'" class="fas fa-edit active_ass_student check_ass_student'+data[0]+'"></i>'
//                     }
//                 },
//                 {
//                     title: "ID",
//                     data: 'id',

//                 },
//                 { title: "Họ và tên",   data: 'name_user'},
//                 // {title: "CMND",         data: 'id_card_users'},
//                 // {title: "Email",        data: 'email_users'},
//                 {title: "Điện thoại",   data: 'phone_users'},
//                 // {title: "Email",        data: 'email_users'},
//                 // {title: "Năm TS",       data: 'year_user'},

//                 {
//                     title: "Đợt TS",
//                     data: 'name_batch',
//                 },

//                 {
//                     title: "Ngày phân công",
//                     data: 'update_at',
//                     render: function(data){
//                         var data = data.split('-')
//                         return '<span class = "update_at_ass'+data[1]+'">'+data[0]+'</span>'
//                     },
//                 },

//                 {
//                     title: "Nhân viên",
//                     data: 'name',
//                     render: function(data){
//                         var data = data.split('-')
//                         return '<span class ="user_check_ass'+data[1]+'">'+data[0]+'</span>'
//                     }
//                 },

//                 {
//                     title: "Kiểm tra",
//                     data: 'block',
//                     render: function(data){
//                         var data = data.split('-')
//                         if(data[0] == 1){
//                             return '<small class="badge badge-warning check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-unlock"></i>&nbsp;Chưa khóa</small>'
//                         }else{
//                             if(data[0] == 2){
//                                 return '<small class="badge badge-success check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-undo"></i>&nbsp;Phản hồi</small>'
//                             }else{
//                                 if(data[0] == 3){
//                                     return '<small class="badge badge-primary check_user'+data[1]+'" active = '+data[0]+'><i class="fa fa-lock"></i>&nbsp;Đã khóa</small>'
//                                 }else{
//                                     if(data[0] == 4){
//                                         return '<small class="badge badge-secondary check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-lock"></i>&nbsp;Đã đăng ký lại</small>'
//                                     }else{
//                                         return '<small class="badge badge-warning check_user'+data[1]+'" active = '+data[0]+'"><i class="fa fa-unlock"></i>&nbsp;Chưa khóa</small>'
//                                     }
//                                 }
//                             }
//                         }
//                     }
//                 },
//                 {
//                     title: "Duyệt",
//                     data: 'active',
//                     render: function(data){
//                         var data = data.split('-')
//                         if(data[5] == 1){
//                             return '<span id = "check_send'+data[0]+'" send = '+data[5]+'><small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã duyệt</small></span>'
//                         }else{
//                             return '<span id = "check_send'+data[0]+'" send = '+data[5]+'><small class="badge badge-warning"><i class="fa fa-times"></i>&nbsp;Chưa duyệt</small></span>'
//                         }
//                     }
//                 },

//                 {
//                     title: "",
//                     data: 'active',
//                     render: function(data){
//                         var data = data.split('-')
//                         if(data[1] == 0){
//                             var style = 'red'
//                         }else{
//                             var style = '#007bff'
//                         }
//                         return '<i  onclick = "check_user_assuser('+data[0]+')" id-check = '+data[3]+' id-student = '+data[0]+' active = '+data[1]+' id-user = '+data[2]+' style = "color: '+style+'" class="fa fa-paper-plane check_user_assuser user_assuser'+data[0]+'"></i>'
//                     }
//                 },

//                 {
//                     title: "",
//                     data: 'active',
//                     render: function(data){
//                         var data = data.split('-')
//                         return '<i onclick = "del_assuser('+data[0]+')" id-student = '+data[0]+' id-check = '+data[3]+' style = "color: red" class="fas fa-trash del_assuser del_assuser_check'+data[0]+'"></i>'
//                     }
//                 },

//                 {
//                     title: '<i id-active = "0" onclick = "all_ass_pass()" class="fas fa-check all_ass_pass" active = "0"></i>',
//                     data: 'active',
//                     render: function(data){
//                         var data = data.split('-')
//                         if(data[5] == 1){
//                             var style = '#007bff'
//                             var active = 1;
//                         }else{
//                             var style = 'red'
//                             var active = 0;
//                         }
//                         return '<i  onclick = "send_user_assuser('+data[3]+','+data[2]+','+data[0]+')" id-check = '+data[3]+' id-check-block = '+data[5]+' id-student = '+data[0]+' active = '+active+' id-user = '+data[2]+' style = "color: '+style+'" class="fa fa-check send_user_assuser send_assuser'+data[3]+'"></i>'
//                     }
//                 },

//             ],
//             scrollY: 320,
//             "language": {
//                 "emptyTable": "Không có thí sinh",
//                 "info": " _START_ / _END_ trên _TOTAL_ thí sinh",
//                 "paginate": {
//                     "first":      "Trang đầu",
//                     "last":       "Trang cuối",
//                     "next":       "Trang sau",
//                     "previous":   "Trang trước"
//                 },
//                 "search":         "Tìm kiếm:",
//                 "loadingRecords": "Đang tìm kiếm ... ",
//                 "lengthMenu":     "Hiện thị _MENU_ thí sinh",
//                 "infoEmpty":      "",
//                 },
//             "retrieve": true,
//             "paging": false,
//             "lengthChange": false,
//             "searching": true,
//             "ordering": false,
//             "info": true,
//             "autoWidth": true,
//             "responsive": true,
//             "select": true,
//         })
//     }

//     function check_user_assuser(id){
//             var id_user = $('.user_assuser'+id).attr('id-user')
//             var id_student = $('.user_assuser'+id).attr('id-student')
//             var active = $('.user_assuser'+id).attr('active')
//             var id_check = $('.user_assuser'+id).attr('id-check')
//             var id_user_new = $('.user_assuser'+id).attr('id-user-new')
//             if(!id_user_new){
//                 toastr.warning("Chọn nhân viên phân công")
//             }else{
//                 if(id_user == id_user_new){
//                     var user =  $('.user_check_ass'+id_student).text()
//                     toastr.warning("Nhân viên "+user+" đã được phân công kiểm tra thí sinh này")
//                 }else{
//                     add_ass_user_student(id_user_new,id_student,active,id_check)
//                 }
//             }
//     }

//     function del_assuser(id_student){
//         var id_check = $('.del_assuser_check'+id_student).attr('id-check')
//         if(id_check == 0){
//             toastr.warning('Thí sinh chưa được phân công kiểm tra hồ sơ')
//         }else{
//             $.ajax({
//                 type: "post",
//                 url: 'assuser/del_assuser/'+id_check+'/'+id_student,
//             }).done(function(res){
//                 if(res == 1){
//                     toastr.success("Hủy phân công thành công")
//                     $('.update_at_ass'+id_student).text("")
//                     $('.user_assuser'+id_student).css('color','red')
//                     $('.user_assuser'+id_student).attr('active',0)
//                     $('.user_assuser'+id_student).attr('id-check',0)
//                     $('.del_assuser_check'+id).attr('id-check',0)
//                     $('.user_check_ass'+id_student).text("")
//                     $('.user_assuser'+id_student).removeAttr('id-user')
//                     $('.check_ass_student'+id_student).css('color','black')
//                     $('.check_ass_student'+id_student).attr('id-check',0)
//                 }else{
//                     if(res == 3){
//                         toastr.warning("Hồ sơ đã kiểm tra và khóa hoặc phản hồi cho thí sinh chỉnh sửa, không được xóa phân công")
//                     }else{
//                         toastr.warning("Có lõi xảy ra, vui lòng nhấn Crtl F5")
//                     }
//                 }
//             })
//         }
//     }
//     function ass_user(id){
//         if($('.active_ass_check'+id).attr('id-active-user') == 0){
//             $('.active_ass_check'+id).css('color','#007bff')
//             $('.active_ass_check'+id).attr('id-active-user',1)
//         }else{
//             $('.active_ass_check'+id).css('color','black')
//             $('.active_ass_check'+id).attr('id-active-user',0)
//         }
//     }

//     function ass_student(id){
//         if($('.user_assuser'+id).attr('id-check') != 0){
//             toastr.warning("Hồ sơ đã được phân công")
//         }else{
//             if($('.check_ass_student'+id).attr('id-active-user') == 0){
//                 $('.check_ass_student'+id).css('color','#007bff')
//                 $('.check_ass_student'+id).attr('id-active-user',1)
//             }else{
//                 $('.check_ass_student'+id).css('color','black')
//                 $('.check_ass_student'+id).attr('id-active-user',0)
//             }
//         }
//     }

//     function check_ass_stu_all(){
//         var active_ass_student = document.getElementsByClassName('active_ass_student')
//         if($('#check_ass_stu_all').attr('id-active') == 0){
//             for(let i =0;i<active_ass_student.length;i++){
//                 $('#check_ass_stu_all').css('color','#007bff')
//                 $('#check_ass_stu_all').attr('id-active',1)
//                 if($(active_ass_student[i]).attr('id-check') == 0){
//                     $(active_ass_student[i]).css('color','#007bff')
//                     $(active_ass_student[i]).attr('id-active-user',1)
//                 }
//             }
//         }else{
//             $('#check_ass_stu_all').css('color','black')
//             $('#check_ass_stu_all').attr('id-active',0)
//             for(let i =0;i<active_ass_student.length;i++){
//                 $(active_ass_student[i]).css('color','black')
//                 $(active_ass_student[i]).attr('id-active-user',0)
//             }

//         }

//     }

//     function check_ass_all(){
//         var active_ass_student = document.getElementsByClassName('active_ass_student')
//         if($('#check_ass_stu_all').attr('id-active') == 0){
//             var id_student = []
//             var j = 0;
//             for(let i =0;i<active_ass_student.length;i++){
//                 $('#check_ass_stu_all').css('color','#007bff')
//                 $('#check_ass_stu_all').attr('id-active',1)
//                 if($(active_ass_student[i]).attr('id-check') == 0){
//                     id_student[j] = $(active_ass_student[i]).attr('id-student')
//                     j++
//                     $(active_ass_student[i]).css('color','#007bff')
//                     $(active_ass_student[i]).css('id-active-user',1)
//                 }
//             }
//             alert(id_student)
//         }else{
//             $('#check_ass_stu_all').css('color','black')
//             for(let i =0;i<active_ass_student.length;i++){
//                 $(active_ass_student[i]).css('color','black')
//                 $(active_ass_student[i]).css('id-active-user',0)
//             }
//             $('#check_ass_stu_all').attr('id-active',0)
//         }

//     }

//     function choice_ass(){
//         var  active_ass = document.getElementsByClassName('active_ass')
//         for(let i = 0;i < active_ass.length; i++){
//             if($(active_ass[i]).prop('checked') == true){
//                 var id_ass = $(active_ass[i]).attr('id-data')
//                 break;
//             }
//         }
//         return id_ass;
//     }

//     function choice_user(){
//         var data_user = [], j = 0;
//         var ass_user = document.getElementsByClassName('ass_user')
//         for(let i = 0;i < ass_user.length; i++){
//             if($(ass_user[i]).attr('id-active-user') == 1){
//                 data_user[j] = $(ass_user[i]).attr('id-user')
//                 j++;
//             }
//         }
//         return data_user;
//     }

//     function choice_student(){
//         var data_student = [], j = 0;
//         var active_ass_student = document.getElementsByClassName('active_ass_student')
//         for(let i = 0;i < active_ass_student.length; i++){
//             if($(active_ass_student[i]).attr('id-active-user') == 1){
//                 data_student[j] = $(active_ass_student[i]).attr('id-student')
//                 j++;
//             }
//         }
//         return data_student;
//     }


//     function auto_ass(){
//         var ass = choice_ass();
//         switch (ass) {
//             case "1":
//                 var data_user = choice_user();
//                 var batch = $('#batch_check_ass').val();
//                 var year = $('#year_check_ass').val();
//                 if(batch == 0 || year == 0){
//                     toastr.warning("Chọn năm tuyển sinh và đợt tuyển sinh")
//                 }else{
//                     if(data_user.length > 0){
//                         $("#auto_ass").attr('disabled',true);
//                         $("#loadding_ass").show();
//                         $.ajax({
//                             type: "post",
//                             url: 'assuser/auto_ass',
//                             data:
//                             {
//                                 ass: ass,
//                                 data_user: data_user,
//                                 batch: batch,
//                             },
//                             success: function (res) {
//                                 setTimeout(() => {
//                                     $("#loadding_ass").hide();
//                                     $("#auto_ass").removeAttr('disabled')
//                                     if(res.sus == 1){
//                                         toastr.success("Phân công thành công")
//                                     }else{
//                                         if(res.fail == 2){
//                                             toastr.warning("Toàn bộ Thí sinh đã được phân công")
//                                         }else{
//                                             toastr.warning("Phân công thất bại, vui lòng nhấn Ctrl F5")
//                                         }
//                                     }
//                                     load_list_assstudent()
//                                 }, 5000);
//                             }
//                         });
//                     }else{
//                         toastr.warning("Chọn nhân viên để phân công")
//                     }
//                 }

//                 break;

//             case "2":
//                 var data_user = choice_user();
//                 var data_student = choice_student();
//                 if(data_student.length > 0 && data_user.length > 0){
//                     $("#auto_ass").attr('disabled',true)
//                     $("#loadding_ass").show();
//                     $.ajax({
//                         type: "post",
//                         url: 'assuser/auto_ass',
//                         data:
//                         {
//                             ass: ass,
//                             data_user: data_user,
//                             data_student: data_student,
//                         },
//                         success: function (res) {
//                             setTimeout(() => {
//                                 $("#loadding_ass").hide();
//                                 $("#auto_ass").removeAttr('disabled')
//                                 if(res.sus == 1){
//                                     toastr.success("Phân công thành công")
//                                 }else{
//                                     if(res.fail == 2){
//                                         toastr.warning("Toàn bộ Thí sinh đã được phân công")
//                                     }else{
//                                         toastr.warning("Phân công thất bại, vui lòng nhấn Ctrl F5")
//                                     }
//                                 }
//                                 load_list_assstudent()
//                             }, 5000);
//                         }
//                     });
//                 }else{
//                     toastr.warning("Chọn nhân viên và thí sinh để phân công")
//                 }
//                 break;

//             default:
//                 toastr.warning("Chọn cài đặt phân công")
//         }
//     }


// function  send_user_assuser(id,user,id_student){
//     if(id == 0){
//         toastr.warning('Hồ sơ chưa được nhân viên kiểm tra, không duyệt được')
//     }else{
//         var active = $('.send_assuser'+id).attr('active');
//         $('.send_assuser'+id).hide();
//         $.ajax({
//             type: "post",
//             url: 'assuser/send_user_assuser',
//             data:
//             {
//                id: id,
//                active: active,
//                user: user,
//                id_student: id_student,
//             },
//             success: function (res) {
//                 if(res.fail == 0){
//                     $('.send_assuser'+id).attr('active',res.mes)
//                     $('.send_assuser'+id).show();
//                     switch (res.mes) {
//                         case 1:
//                             toastr.success("Đã duyệt")
//                             $('#check_send'+id_student).html('<small class="badge badge-primary"><i class="fa fa-check"></i>&nbsp;Đã duyệt</small></span>')
//                             $('.send_assuser'+id).css('color','#007bff')
//                             $('#check_send'+id_student).attr('send','1')
//                             break;
//                         case 0:
//                             toastr.success("Đã hủy duyệt")
//                             $('#check_send'+id_student).html('<small class="badge badge-warning"><i class="fa fa-times"></i>&nbsp;Chưa duyệt</small></span>')
//                             $('.send_assuser'+id).css('color','red')
//                             $('#check_send'+id_student).attr('send','0')
//                             break;
//                         case 2:
//                             toastr.warning("Hồ sơ chưa được kiểm tra")
//                             break;
//                         case 3:
//                             toastr.warning("Hồ sơ đang chờ thí sinh phản hồi")
//                             break;
//                         default:
//                             toastr.warning('Hệ thống bị lỗi, vui lòng nhấn Ctrl F5')
//                     }
//                 }else{
//                     toastr.warning('Hệ thống bị lỗi, vui lòng nhấn Ctrl F5')

//                 }
//             }
//         })
//     }

// }

// function all_ass_pass(){
//     var send_user_assuser = document.getElementsByClassName('send_user_assuser')
//     if($('.all_ass_pass').attr('active') == 0){
//         $('.all_ass_pass').attr('active','1')
//         for(let i = 0; i<send_user_assuser.length; i++){
//             var id_student = $(send_user_assuser[i]).attr('id-student')
//             if($('.check_user'+id_student).attr('active') == 3 && $('#check_send'+id_student).attr('send') == 0){
//                 $(send_user_assuser[i]).attr('active','2')
//                 $(send_user_assuser[i]).css('color','#CCFF00')
//                 $('.all_ass_pass').css('color','#CCFF00')
//             }
//         }
//     }else{
//         $('.all_ass_pass').attr('active','0')
//         for(let i = 0; i<send_user_assuser.length; i++){
//             var id_student = $(send_user_assuser[i]).attr('id-student')
//             if($(send_user_assuser[i]).attr('active') == 2){
//                 $(send_user_assuser[i]).css('color','red')
//                 $(send_user_assuser[i]).attr('active','0')
//                 $('.all_ass_pass').css('color','black')
//             }
//         }
//     }
// }


// function ass_pass(){
//     var send_user_assuser = document.getElementsByClassName('send_user_assuser')
//     var j = 0,data = [];
//     for(let i = 0; i<send_user_assuser.length; i++){
//         if($(send_user_assuser[i]).attr('active')== 2){
//             var id_user = $(send_user_assuser[i]).attr('id-user')
//             var id_student = $(send_user_assuser[i]).attr('id-student')
//             var id_check = $(send_user_assuser[i]).attr('id-check')
//             data[j] = [id_check,id_user,id_student]
//             j++;
//         }
//     }

//     if(j == 0){
//         toastr.warning("Chưa chọn hồ sơ để duyệt")
//     }else{
//         $.ajax({
//             type: "post",
//             url: 'assuser/ass_pass',
//             data:
//             {
//                 data:data,
//             },
//             success: function (res) {
//                 if(res == 1){
//                     load_list_assstudent()
//                     toastr.success("Đã duyệt thành công")
//                 }else{
//                     toastr.success("Có lỗi xảy ra, vui lòng nhấn Ctrl F5")
//                 }

//             }
//         });
//     }
// }

