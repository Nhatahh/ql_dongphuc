@extends('layouts.admin.body')

@section('title', 'Tài Khoản')

@section('content')
<div class="col-md-10 main-content">
    <!-- Admin -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Danh sách Admin</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="adminsTable" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Users -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách người dùng</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>MSSV</th>
                            <th>Email</th>
                            <th>SDT</th>
                            <th>Họ tên</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/taikhoan-datatables.js') }}"></script>
@endpush
