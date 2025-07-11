@extends('layouts.admin.body')

@section('title', 'Thống Kê')

@section('content')
<!-- Body -->
    <div class="col-md-10 main-content">
        <div class="row">
            <!-- Form Column -->
            <div class="col-md-12 form-container">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h3>Doanh thu</h3>
                                <h3>250.000.000đ</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h3>Đơn hàng</h3>
                                <h3>5.247</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h3>Khách hàng</h3>
                                <h3>1.250</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h3>Sản phẩm đã bán</h3>
                                <h3>8.750</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <h4>Doanh thu theo tháng</h4>                
                <canvas id="myChart" style="width:100%;"></canvas>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const xValues = ["Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"];
    const yValues = [50,50,35,210,60,75,250,210,160,170,200,250];

    if (document.getElementById("myChart")) {
        new Chart(document.getElementById("myChart"), {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,1.0)",
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: 0, max:300}}],
                }
            }
        });
    }
});
</script>
@endpush