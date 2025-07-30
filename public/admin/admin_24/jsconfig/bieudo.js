$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    bieudonguyenvong()
    // alert(111111)


});

function bieudonguyenvong(){
    $.ajax({
        url: "/admin24/bieudonguyenvong",
        type:'get',
        success:function(res){
            var tenchuyennganh = [],slnv1=[],slnv2=[],slnv3=[]
            for(let i = 0;i<res.length;i++){
                tenchuyennganh[i] = res[i]['tenchuyennganh']
                slnv1[i] = res[i]['slnv1']
                slnv2[i] = res[i]['slnv2']
                slnv3[i] = res[i]['slnv3']
            }
            const ctx = document.getElementById('bieudonguyenvong');
            new Chart(ctx, {
                type: 'bar',
                data: {
                label: 'Số lượng nguyện vọng',
                labels: tenchuyennganh,
                datasets: [
                    {
                        label: 'Nguyện vọng 1',
                        data: slnv1,
                        backgroundColor: [
                            '#10c699'
                        ],
                        borderColor: [
                            'rgba(34,139,34,1)'
                        ],
                        borderWidth: 0,
                        type: 'bar',
                        stack: 'Stack 0',
                        datalabels:{
                            anchor: 'start',
                            color: 'black',
                            font: {
                                weight: 'bold',
                                size: '14pt'
                            }
                        },
                    },
                    {
                        label: 'Nguyện vọng 2',
                        data: slnv2,
                        backgroundColor: [
                            '#fdcdbf'
                        ],
                        borderColor: [
                            'rgba(34,139,34,1)'
                        ],
                        borderWidth: 0,
                        type: 'bar',
                        stack: 'Stack 1',
                        datalabels:{
                            anchor: 'start',
                            color: 'black',
                            font: {
                                weight: 'bold',
                                size: '14pt'
                            }
                        },
                    },
                    {
                        label: 'Nguyện vọng 3',
                        data: slnv3,
                        backgroundColor: [
                            '#ab8ce4'
                        ],
                        borderColor: [
                            'rgba(34,139,34,1)'
                        ],
                        borderWidth: 0,
                        type: 'bar',
                        stack: 'Stack 2',
                        datalabels:{
                            anchor: 'start',
                            color: 'black',
                            font: {
                                weight: 'bold',
                                size: '14pt'
                            }
                        },
                    }
                ]
                },
                options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
                }
            });

        }
    })
}


