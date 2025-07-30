$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#go_batch').select2();
    $('#go_active').select2();
    // $('#email_go_setup').summernote({
    //     height: '400px'
    // })

    if($(document).width() > 992){
        $('#right_go_setup').css('min-height','760px')
        $('#left_go_setup').css('min-height','760px')
    }else{
        $('#right_go_setup').css('min-height','0x')
        $('#left_go_setup').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_go_setup').css('min-height','760px')
            $('#left_go_setup').css('min-height','760px')
        }else{
            $('#right_go_setup').css('min-height','0x')
            $('#left_go_setup').css('min-height','0px')
        }
    });


    if($(document).width() > 992){
        $('#right_go_setup').css('min-height','630px')
        $('#left_go_setup').css('min-height','630px')
    }else{
        $('#right_go_setup').css('min-height','0x')
        $('#left_go_setup').css('min-height','0px')
    }

    $(window).resize(function(){
        if($(document).width()>992){
            $('#right_go_setup').css('min-height','630px')
            $('#left_go_setup').css('min-height','630px')
        }else{
            $('#right_go_setup').css('min-height','0x')
            $('#left_go_setup').css('min-height','0px')
        }
    });

    load_search();
    $('#go_setup_batch').on('change',function(){
        load_go_setup($('#go_setup_batch').val())
        barChart_go_setup($('#go_setup_batch').val())
    })



})

$('#go_setup_save_email').on('click',function(){
    var html = $('.note-editable').summernote('code')
    // alert(html)
})


function load_search(){
    $.ajax({
        type: "get",
        url: "go/load_search",
        success: function (res) {
            $('#go_setup_batch').html('').select2({
                data: res.batch
            });
        }
    });
}

$('#go_setup_save').on('click',function(){
    load_go_setup($('#go_setup_batch').val())
})

function load_go_setup(id){
    $('#remove_load_go_setup').empty();
    $('#remove_load_go_setup').append('<table class="table table-hover text-nowrap" id = "load_go_setup"></table>');
    var table = $('#load_go_setup').DataTable( {
        ajax: {
            type: "get",
            url: 'go_setup/load_go_setup/'+id
        },

        // dom: 'frtip',
        columns: [

            {
                title: "STT",data: 'stt',
            },

            {
                title: "Phương thức",
                data: 'id_method'
            },
            {
                title: "Ngành xét tuyển",
                data: 'name_major',
            },
            {
                title: "Chỉ tiêu",
                data: 'min_major',
                render: function(data){
                    var data = data.split('-')
                    var html = '<input class = "min_major_setup min_major_setup'+data[0]+'" onchange = "min_major_setup('+data[0]+')" data-old = "'+data[1]+'" id-data ="'+data[0]+'" style = "width: 100%;height: 100%;text-align:center;border:none;background-color:inherit" value = "'+data[1]+'">'
                    return html;
                }
            },

            {
                title: "Ngưỡng ảo",
                data: 'max_go',
                render: function(data){
                    var data = data.split('-')
                    var html = '<input class = "max_go_setup max_go_setup'+data[0]+'" onchange = "max_go_setup('+data[0]+')" data-old = "'+data[1]+'" id-data ="'+data[0]+'" style = "width: 100%;height: 100%;text-align:center;border:none;background-color:inherit" value = "'+data[1]+'">'
                    return html;
                }
            },

            {
                title: "Tỉ lệ",
                data: 'tl',
                render: function(data){
                    var data = data.split('-')
                    var html = '<input class = "tl_go_setup tl_go_setup'+data[0]+'" onchange = "tl_go_setup('+data[0]+')" data-old = "'+data[1]+'" id-data ="'+data[0]+'" style = "width: 100%;height: 100%;text-align:center;border:none;background-color:inherit" value = "'+data[1]+'">'
                    return html;
                }
            },
        ],

        scrollY: 380,
        "language": {
            "emptyTable": "Không có ngành trong đợt tuyển sinh",
            "info": " _START_ /_TOTAL_ ngành",
            "paginate": {
                "first":      "Trang đầu",
                "last":       "Trang cuối",
                "next":       "Trang sau",
                "previous":   "Trang trước"
            },
            "search":         "Tìm kiếm:",
            "loadingRecords": "Đang tìm kiếm ... ",
            "lengthMenu":     "Hiện thị _MENU_ ngành",
            "infoEmpty":      "",
            "infoFiltered": "(trên _MAX_ ngành)"
            },
        "retrieve": true,
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "select": true,
    })

    $('#load_go_setup_wrapper').css('margin-top','5px')
    $('#load_go_setup_wrapper').css('margin-right','5px')
}



function go_setup_save(){
    var id = $('#go_setup_batch').val()
    var min_major_setup = document.getElementsByClassName('min_major_setup')
    var max_go_setup = document.getElementsByClassName('max_go_setup')
    var data = [],data_old=[];
    if(id == 0){
        toastr.warning("Chọn đợt tuyển sinh")
    }else{
        if(min_major_setup.length == max_go_setup.length && max_go_setup.length >0){
            var count = 0;
            for(let i = 0; i<min_major_setup.length; i++){
                if($(min_major_setup[i]).val() != $(min_major_setup[i]).attr('data-old') || $(max_go_setup[i]).val() != $(max_go_setup[i]).attr('data-old')){
                    count++;
                    break;
                }
            }
            if(count > 0){
                for(let i = 0; i<min_major_setup.length; i++){
                    data[i] = [$(min_major_setup[i]).attr('id-data'),$(min_major_setup[i]).val(),$(max_go_setup[i]).attr('id-data'),$(max_go_setup[i]).val()]
                }
                $.ajax({
                    type: "get",
                    url: "go_setup/go_setup_save",
                    data: {
                        data: data
                    },
                    success: function (res) {
                        if(res == 1){
                            toastr.success("Cài đặt thành công")
                        }else{
                            toastr.warning("Cài đặt thất bại, vui lòng load lại trang")
                        }
                    }
                });
            }else{
                toastr.warning("Không có dữ liệu mới")
            }
        }else{
            toastr.warning("Chưa có ngành của đợt tuyển sinh đã chọn")
        }
    }

}


function tl_go_setup(id){
    var val = Math.floor(($('.min_major_setup'+id).val() * $('.tl_go_setup'+id).val())/100)
    $('.max_go_setup'+id).val(val)
    go_setup_save()
    barChart_go_setup($('#go_setup_batch').val())
}

function max_go_setup(id){
    var val =($('.max_go_setup'+id).val() / $('.min_major_setup'+id).val())*100
    var rounded = Math.round(val * 100) / 100;
    $('.tl_go_setup'+id).val(rounded)
    go_setup_save()
    setTimeout(() => {
        barChart_go_setup($('#go_setup_batch').val())
    }, 2000);

}

function min_major_setup(id){
    max_go_setup(id)
}


function barChart_go_setup(id){
    $('#add_barChart_go_setup').empty();
    $('#add_barChart_go_setup').append('<canvas id="barChart_go_setup" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>');
    setTimeout(() => {
        $.ajax({
            type: "get",
            url: 'go_setup/barChart_go_setup/'+id,
            success: function (res) {
                var major = [],min_major = []
                for(let i = 0;i<res.length;i++){
                    major[i] = res[i][1]
                    min_major[i] = res[i][2]
                    // max_go[i] = res[i][3]
                }
                var ctx = document.getElementById('barChart_go_setup').getContext('2d');
                var myChart = new Chart(ctx, {
                    data: {
                        labels: major,
                        datasets: [
                            {
                                label: 'Tỉ lệ ảo',
                                data: min_major,
                                backgroundColor: [
                                    'rgba(34,139,34,0.9)'
                                ],
                                borderColor: [
                                    'rgba(34,139,34,1)'
                                ],
                                borderWidth: 1,
                                type: 'bar',
                                stack: 'Stack 0',
                                datalabels:{
                                    anchor: 'center',
                                    color: 'white',
                                    font: {
                                        weight: 'bold',
                                        size: '14pt'
                                    }
                                },
                            },
                            // {
                            //     label: 'Ngưỡng ảo',
                            //     data: max_go,
                            //     backgroundColor: [
                            //         'RGBA( 225, 0, 0, 0.9 )'
                            //     ],
                            //     borderColor: [
                            //         'RGBA( 225, 0, 0, 1 )'
                            //     ],
                            //     borderWidth: 1,
                            //     type: 'line',
                            //     stack: 'Stack 1',
                            //     datalabels:{
                            //         anchor: 'start',
                            //         color: 'black',
                            //         font: {
                            //             weight: 'bold',
                            //             size: '14pt'
                            //         }
                            //     },
                            // },
                        ]

                    },
                    options: {
                        responsive              : true,
                        maintainAspectRatio     : false,
                        datasetFill             : false,
                        // scales: {
                        //     y: {
                        //         beginAtZero: true
                        //     }
                        // }


                        scales: {
                            x: {
                              stacked: true,
                            },
                            y: {
                              stacked: true
                            }
                        }


                    },
                    plugins: [ChartDataLabels],
                });
            }
        });
    },1);



}


function sumArray(arr){
    let sum = 0;
        for(let i = 0; i<arr.length; i++){
            sum = Number($(arr[i]).text().trim()) + sum;
        }
    return sum;
}






