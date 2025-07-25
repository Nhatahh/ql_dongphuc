@extends('layouts.admin.body')

@section('title', 'Thống Kê')

@section('content')
<!-- Body -->
    <div class="col-md-10 main-content">
    <div class="row">

        {{-- KẾT QUẢ KINH DOANH --}}
        <div class="col-md-12 form-container">
            <div class="row text-center">
                <div class="col-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="text-muted">Tổng doanh thu</h5>
                            <h3 class="text-success">{{ number_format($tongDoanhThu) }} đ</h3>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="text-muted">Tổng đơn hàng</h5>
                            <h3 class="text-primary">{{ $tongDonHang }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="text-muted">Tổng đơn hủy</h5>
                            <h3 class="text-danger">{{ $tongDonHuy }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="text-muted">Sản phẩm đã bán</h5>
                            <h3 class="text-info">{{ $tongSanPhamDaBan }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- BIỂU ĐỒ DOANH THU --}}
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-bar-chart-fill me-2"></i> Doanh thu 
                        </h5>
                        <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-funnel-fill me-1"></i> Thống kê theo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center fw-semibold text-primary">
                            @if (request('from_date') && request('to_date'))
                                Biểu đồ doanh thu từ {{ \Carbon\Carbon::parse(request('from_date'))->format('d/m/Y') }}
                                đến {{ \Carbon\Carbon::parse(request('to_date'))->format('d/m/Y') }}
                            @elseif ($thang && $nam)
                                Biểu đồ doanh thu tháng {{ $thang }} năm {{ $nam }}
                            @elseif ($nam)
                                Biểu đồ doanh thu năm {{ $nam }}
                            @else
                                Biểu đồ doanh thu tổng hợp
                            @endif
                        </div>

                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL LỌC --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="GET" action="{{ route('admin.thongke.index') }}" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-funnel-fill me-2"></i> Bộ lọc thống kê
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-4">
                    <label for="year" class="form-label">Năm</label>
                    <select name="year" id="year" class="form-select">
                        <option value="">-- Tất cả --</option>
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="month" class="form-label">Tháng</label>
                    <select name="month" id="month" class="form-select">
                        <option value="">-- Tất cả --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                {{-- <div class="col-md-6">
                    <label for="from_date" class="form-label">Từ ngày</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-6">
                    <label for="to_date" class="form-label">Đến ngày</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-search"></i> Lọc dữ liệu
                </button>
                <a href="{{ route('admin.thongke.index') }}" class="btn btn-secondary">Xóa lọc</a>
            </div>
        </form>
    </div>
</div>



@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const xValues = @json($chartLabels);
    const yValues = @json($chartData);

    if (document.getElementById("myChart")) {
        new Chart(document.getElementById("myChart"), {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "Doanh thu (VNĐ)",
                    fill: false,
                    borderColor: "#007bff",
                    tension: 0.1,
                    data: yValues
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value.toLocaleString('vi-VN') + ' đ'
                        }
                    }
                }
            }       
        });
    }
});
</script>
@endpush
