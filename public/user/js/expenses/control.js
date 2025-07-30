$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
if($(document).width() > 992){
    $('#right_ex').css('min-height','630px')
    $('#left_ex').css('min-height','630px')
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

//Khởi đầu

load_expenses_wish()

load_expenses_img()

load_price()

$("#save_expenses").on('click',function(){
    save_expenses()
})

image_crop = $('#resizer-file_ex').croppie({
    enableExif: true,
    viewport: {
      width:400,
      height:550,
      type:'square' //circle
    },
    boundary:{
      width:420,
      height:570
    }
});


 //Open cắt hình
$('#img_expenses').on('click',function(){
    $('#open_img_expenses').click();
})

$('#open_img_expenses').on('change', function(){
    var type = this.files[0].type
    if(type == 'image/png' || type == 'image/pjpeg' || type == 'image/jpeg' || type == 'image/png'){
        var reader = new FileReader();
        reader.onload = function (event) {
            image_crop.croppie('bind', {
            url: event.target.result
            })
        }
        reader.readAsDataURL(this.files[0]);
    $('#modal1').show('slow');
    }else{
        toastr.warning("Vui lòng chọn file ảnh")
    }
});

//Add Img
$('#crop_ex').click(function(event){
    image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function(response){
        $.ajax({
        url: "/expenses/crop_ex",
        type:'POST',
        data: {
            img: response,
        },
        success:function(data){
            if(data.ins == 1){
                $('#modal1').hide('slow');
                $('#view_img_expenses').attr('src',data.src)
                toastr.success('Cập nhật thành công')
            }else{
                toastr.warning('Có lỗi xảy ra, vui lòng liên hệ hotline: 02923898167')
                $('#modal1').hide('slow');
            }
        }
        })
    });
})

//Tắt Crop ảnh
$('#crop_close_ex').on('click',function(){
    $('#modal1').hide('slow');
})
})//End Ready

function height(){
    if($('#right_ex').height() > $('#left_ex').height()){
        $('#left_ex').height($('#right_ex').height())
    }else{
        $('#right_ex').height($('#left_ex').height())
    }
}

function load_expenses_img(){
    $.ajax({
        url: "/expenses/load_expenses_img",
        type:'get',
        success:function(data){
            $('#view_img_expenses').attr('src',data)
        }
    })
}


//Load ngành

function load_expenses_wish(){
    $.ajax({
        type: "get",
        url: "/expenses/load_expenses_wish",
        success: function (response) {
            if(response == "check_false"){
                $('#check_reg_expenses').text('Thí sinh chưa đăng ký nguyện vọng xét tuyển, Vui lòng vào màn hình Nguyện vọng xét tuyển chọn "Đăng ký xét tuyển"')
            }else{
                $('#check_reg_expenses').text('')
                load_expenses_wish_ajax();
            }
        }
    })
}


function load_expenses_wish_ajax(){
    var table =  $('#load_expenses_wish').DataTable({
    ajax: "/expenses/load_expenses_wish",
    columns: [
        {title: "Thứ tự",               data: 'number'},
        {title: "Mã ngành",         data: 'id_major'},
        {title: "Ngành xét tuyển",  data: 'name_major'},
        {title: "Phương thức",  data: 'name_method'},
        {title: "Thời điểm đăng ký",        data: 'time'},
        {
            title: "Lệ phí",
            data: 'wish_expenses',
            render: function(data){
                var a = data.split('-');
                a[0] == 1 ? checked = "checked" : checked = "";
                return '<input class ="choice_expenses" id-data = "'+a[1]+'" '+checked+' type="checkbox">'
            },
        },
        {
            title: "Tình trạng",
            data: 'block_ex',
            render: function(data){
                if(data == 1){
                    return '<span style = "color: #007bff">Đã thanh toán</span>'
                }else{
                    return ''
                }
            },
        },
    ],
    "retrieve": true,
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    "responsive": true,
    });
    table.ajax.reload()
  }


function save_expenses(){
    var expenses = document.getElementsByClassName('choice_expenses');
    var save = []
    j=0;
    for(let i = 0;i<expenses.length;i++){
        if($(expenses[i]).prop('checked') == true){
        save[j] = [1,$(expenses[i]).attr('id-data')]
        j++;
        }
    }
    if(save.length > 0){
        $.ajax({
        type: "get",
        url: "/expenses/save_expenses_wish",
        data: {
            data: save
        },
        success: function (response) {
            if(response >0 ){
                toastr.success("Cập nhật thành công")
                load_expenses_wish();
                load_price()
            }else{
                toastr.warning(response)
                load_price()
                load_expenses_wish();
            }
        }
        });
    }else{
        toastr.warning("Vui lòng chọn ngành để đóng phí")
    }
}

function load_price(){
    $.ajax({
        type: "get",
        url: "/expenses/load_price",
        success: function (response) {
            $('#price').text(response.price)
            $('#info_price').text(response.info_price)
        }
    })
}

