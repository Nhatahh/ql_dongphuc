@extends('layouts.admin.body')

@section('title', 'Danh sách Đơn Hàng')

@section('content')
<!-- Body -->
<div id="donhang-table"
    data-url="{{ route('/') }}"
    data-trangthai-url="{{ route('/') }}" hidden>
</div>
<div class="col-md-10 main-content">
    <div class="table-container">
        <h5 class="mb-3">DANH SÁCH ĐƠN HÀNG</h5>
        <div class="table-responsive">
            <div id="donhang-table" data-url="{{ route('admin.donhang.danhsach') }}">
                <table class="table table-bordered table-hover table-striped" style="width: 100%" id="dsDonhang"></table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Chi Tiết Đơn Hàng -->
<div class="modal fade" id="chiTietDonHangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="color: white;">
                <h5 class="modal-title fs-3" id="exampleModalLabel">Chi tiết đơn hàng</h5>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div id="chiTietSanPham">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
