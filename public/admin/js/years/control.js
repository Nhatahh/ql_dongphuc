$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    alert('Chưa hoàn thành, lấy trực tiếp từ cơ sở dữ liệu')
})

    // $('#file_council').on('change',function(){
    //     file_data = $(this).prop('files')[0]
        // // alert(file_data.type)

        // // alert($(this).val())


        // var extension = $(this).val().split('.').pop().toLowerCase();
        // // alert(extension)
        // alert($.inArray(extension, ['png', 'gif', 'jpeg', 'jpg']))

        // if ($.inArray(extension, ['pdf', 'doc', 'docx']) == -1){
        //     alert("Dung")
        // }else{
        //     // formData = new FormData($('#f_file_council'))
        //     var form_data = new FormData();
        //     form_data.append('file_council',file_data)
        //     $.ajax({
        //         type: "post",
        //         url: "/admin/years/store",
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         data:  form_data,
        //         dataType: "text",
        //         success: function (response) {
        //             alert(response)
        //         }
        //     });
    //     }
    // })





