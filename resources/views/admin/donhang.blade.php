@extends('layouts.admin.body')

@section('title', 'Đơn Hàng')

@section('content')
<div class="col-md-10 main-content">
    <h4 class="mb-3">Danh sách đơn hàng</h4>
    <div class="table-responsive">
        <table id="donhangTable" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal chi tiết hóa đơn -->
<div class="modal fade" id="modalChiTietHD" tabindex="-1" aria-labelledby="modalChiTietHDLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalChiTietHDLabel">Chi tiết đơn hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0" id="tableChiTietHD">
                        <thead class="table-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Nội dung sẽ được load bằng JS -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Tổng cộng:</th>
                                <th id="tongTienFooter" class="text-danger fw-bold">0đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    const donhangDataUrl = "{{ route('admin.donhang.data') }}";
    const donhangChiTietUrl = "{{ url('/admin/donhang/chitiet') }}";
</script>
@push('scripts')
<script src="{{ asset('js/admin/donhang.js') }}"></script>
@endpush
