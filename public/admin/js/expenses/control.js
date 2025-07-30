$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if($(document).width() > 992){
        $('#right_ex').css('min-height','670px')
        $('#left_ex').css('min-height','670px')
    }else{
        $('#right_ex').css('min-height','0x')
        $('#left_ex').css('min-height','0px')
    }




    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_ex').css('min-height','630px')
            $('#left_ex').css('min-height','630px')
        }else{
            $('#right_ex').css('min-height','0x')
            $('#left_ex').css('min-height','0px')

        }
    });

    $('#id_expenses_ad').on('change',function(){
        $('#total_price').val('')
        $('#form_check').prop('checked',false)
        var myRe = /^[+-]?((\d+(\.\d*)?)|(\.\d+))$/;
        var id = $('#id_expenses_ad').val();
        if(id == ""){
            $('#price_ex').text('')
            $('#price2_ex').text('')
            $('#name_user_ex').text("")
            $('#birth_user_ex').text("")
            $('#phonesc_user_ex').text("")
            $('#phone_user_ex').text("")
            $('#email_user_ex').text("")
            $('#id_user_ex').text("")
            $('#view_img_expenses_ad').attr('src',"#")
            $('#userimg_check_ex').attr('src',"#")
            load_expenses_wish_ajax(0)
        }else{
            if(myRe.test(id) ==false){
                toastr.warning("Vui lòng nhập thông tin tìm kiếm")
                $('#price_ex').text('')
                $('#price2_ex').text('')
                $('#name_user_ex').text("")
                $('#birth_user_ex').text("")
                $('#phonesc_user_ex').text("")
                $('#phone_user_ex').text("")
                $('#email_user_ex').text("")
                $('#id_user_ex').text("")
                $('#view_img_expenses_ad').attr('src',"#")
                $('#userimg_check_ex').attr('src',"#")
            }else{
                $.ajax({
                    url: "/admin/expenses_admin/search/"+id,
                    type:'get',
                    dataType: 'json',
                    success:function(data){
                        if(data.active_info == 0){
                            toastr.warning("Không tìm thấy thí sinh")
                            $('#price_ex').text('')
                            $('#price2_ex').text('')
                            $('#name_user_ex').text("")
                            $('#birth_user_ex').text("")
                            $('#phonesc_user_ex').text("")
                            $('#phone_user_ex').text("")
                            $('#email_user_ex').text("")
                            $('#id_user_ex').text("")
                            $('#userimg_check').attr('src',"")
                            $('#view_img_expenses_ad').attr('src',"#")
                            $('#userimg_check_ex').attr('src',"#")
                            userimg_check_ex
                            load_expenses_wish_ajax(id)
                        }else{
                            load_price(id)
                            $('#name_user_ex').text(data.info[0].name_user)
                            $('#birth_user_ex').text(data.info[0].birth_user)
                            $('#phonesc_user_ex').text(data.info[0].phonesc_user)
                            $('#phone_user_ex').text(data.info[0].phone_users)
                            $('#email_user_ex').text(data.info[0].email_users)
                            $('#id_user_ex').text(data.info[0].id_card_users)
                            $('#userimg_check_ex').attr('src',data.info[0].link_img_user)
                            $('#view_img_expenses_ad').attr('src',data.img)
                            load_expenses_wish_ajax(id)
                        }
                    }
                })
            }
        }

    })

    $('#save_ex_ad').on('click',function(){
        var form_check;
        if($('#form_check').prop('checked') == true){
            form_check = 2
        }else{
            form_check = 1
        }
        var wish_ex = document.getElementsByClassName('wish_ex')
        var dem = 0;
        for(let i = 0;i<wish_ex.length;i++){
            if($(wish_ex[i]).prop('checked') == true){
                dem++
            }
        }
        var wish = []
        var j = 0;
        var wishs = document.getElementsByClassName('wish_check')
        for (let i = 0; i < wishs.length; i++) {
            // if($(wishs[i]).prop('checked') == true){
                wish[j] = $(wishs[i]).attr('id-data')
                j++
            // }
        }
        var id_user = $('#id_expenses_ad').val()
        if(id_user == ''){
            toastr.warning('Chưa nhập ID thí sinh')
        }else{
            if(dem == j && dem != 0  ){
                toastr.warning("Đã thu lệ phí của tất cả nguyện vọng thí sinh xác nhận")
            }else{
                if($('#total_price').val() <=0 || $('#total_price').val() == "" ){
                    toastr.warning('Chưa nhập số tiền')
                }else{
                    if(dem >0){
                        var check = confirm("Đã thu lệ phí của thí sinh có ID = "+id_user+". Nếu tiếp tục thì lệ phí sẽ được cộng dồn và cộng cho nguyện vọng tiếp theo! Cận thận kiểm tra lại kỹ trước khi chọn OK")
                        if (check == true){
                            if(wishs.length >0){
                                // if(wish.length > 0){
                                    $.ajax({
                                        type: "post",
                                        url: "/admin/expenses_admin/charge",
                                        data:
                                        {
                                            data: wish,
                                            price: Number($('#total_price').val()),
                                            id_user: id_user,
                                            form_check:   form_check,
                                        },
                                        // dataType: "dataType",
                                        success: function (res) {
                                            $('#total_price').val('')
                                            if(res.number == 'fail'){
                                                toastr.warning("Thu lệ phí thất bại, vui lòng liên hệ admin hệ thống")
                                            }else{
                                                toastr.success("Thu lệ phí thành công")
                                            }
                                            load_expenses_wish_ajax(id_user)
                                            load_price(id_user)
                                        }
                                    });
                                // }else{
                                //     toastr.warning('Thí sinh chưa xác nhận đóng lệ phí')
                                // }
                            }else{
                                toastr.warning('Không tìm thấy thí sinh có ID = '+id_user)
                            }
                        }
                    }else{
                        if(wishs.length >0){
                            // if(wish.length > 0){
                                $.ajax({
                                    type: "post",
                                    url: "/admin/expenses_admin/charge",
                                    data:
                                    {
                                        data: wish,
                                        price: Number($('#total_price').val()),
                                        id_user: id_user,
                                        form_check:   form_check,
                                    },
                                    // dataType: "dataType",
                                    success: function (res) {
                                        $('#total_price').val('')
                                        if(res.number == -1){
                                            toastr.warning("Thu lệ phí thất bại, vui lòng liên hệ admin hệ thống")
                                        }else{
                                            toastr.success("Thu lệ phí thành công")
                                        }
                                        load_expenses_wish_ajax(id_user)
                                        load_price(id_user)
                                    }
                                });
                            // }else{
                            //     toastr.warning('Thí sinh chưa xác nhận đóng lệ phí')
                            // }
                        }else{
                            toastr.warning('Không tìm thấy thí sinh có ID = '+id_user)
                        }
                    }
                }
            }
        }
    })

    //Gửi mail faceback
    $('#faceback_ex_ad').on('click',function(){
        if( $('#id_expenses_ad').val() == ""  || $('#content_user_ex').val() == ""){
            toastr.warning("Vui lòng tìm kiếm thí sinh và nhập thông tin cần gửi cho thí sinh")
        }else{
            $('#modal_loadding_ex').show();
            $.ajax({
                url: "/admin/expenses_admin/expenses_back",
                type:'post',
                data:{
                    id_user: $('#id_expenses_ad').val(),
                    name_user_ex: $('#name_user_ex').text(),
                    email_user_ex: $('#email_user_ex').text(),
                    content_user_ex: $('#content_user_ex').val()
                },
                success:function(data){
                    $('#modal_loadding_ex').hide();
                    if(data == 1){
                        toastr.success("Đã gửi thành công")
                    }else{
                        toastr.warning("Gửi không thành công, liên hệ admin")
                    }
                }
            })

        }
    })


});


//Thu phí
function charge(id){

    alert(id)
}



//Load nguyện vọng
function load_price(id){
    $.ajax({
        url: "/admin/expenses_admin/load_price/"+id,
        type:'get',
        dataType: 'json',
        success:function(data){
            $('#price_ex').text(data.price)
            $('#price2_ex').text(data.price2)
        }
    })
}

function load_expenses_wish_ajax(id){
    $('#remove_ex_wish').empty();
    $('#remove_ex_wish').append('<table class="table table-hover"  id = "load_expenses_wish_ad"></table>');
    var table =  $('#load_expenses_wish_ad').DataTable({
    ajax: '/admin/expenses_admin/wish/'+id,
    columns: [
        {title: "Thứ tự",               data: 'number'},
        {title: "Mã ngành",             data: 'id_major'},
        {title: "Ngành xét tuyển",      data: 'name_major'},
        {title: "Phương thức",          data: 'method'},
        {
            title: "Xác nhận",
            data: 'wish_expenses',
            render: function(data){
                var a = data.split('-');
                a[0] == 1 ? checked = "checked" : checked = "";
                return '<input class ="wish_check" id-data = "'+a[1]+'" '+checked+' disabled  type="checkbox">'
            },
        },
        {title: "Thời điểm đăng ký",    data: 'time'},

        {
            title: "Thu",
            data: 'block_ex',
            render: function(data){
                data == 1 ? checked = "checked" : checked = "";
                return '<input class ="wish_ex" '+checked+' disabled type="checkbox">'
            },
        },
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
            className: 'dt-body-left'
        },
        {
            targets: 3,
            className: 'dt-body-center'
        },
        {
            targets: 4,
            className: 'dt-body-center'
        },
        {
            targets: 5,
            className: 'dt-body-center'
        },
        {
            targets: 6,
            className: 'dt-body-center',
        },

    ],
    "language": {
        "emptyTable": "Không tìm thấy nguyện vọng",
        "loadingRecords": "Đang tìm kiếm ... ",
    },
    "retrieve": true,
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    "responsive": true,
    });


    // table.ajax.url('/admin/expenses_admin/wish/'+id).load()
  }







