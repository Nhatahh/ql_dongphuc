@extends('layouts.admin.body')

@section('title', 'Tài Khoản')

@section('content')
<div class="col-md-10 main-content">
    <div class="row">
        <!-- Admin -->
        <div class="col-4">
            <div class="card shadow-sm border-0 mb-4" style="min-height: 600px;">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-fill-gear"></i> Danh sách Admin</h5>
                    <button class="btn btn-light btn-sm" id="btnShowAddAdmin">
                        <i class="bi bi-plus-circle me-1"></i> Thêm tài khoản Admin
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="adminsTable" class="table table-hover align-middle table-bordered table-striped">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- Dữ liệu sẽ được load bằng JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal thêm Admin -->
        <div class="modal fade" id="addAdminModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="addAdminForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Thêm Tài Khoản Admin</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control" />
                                <div id="error-username" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control"/>
                                <div id="error-password" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Users -->        
        <div class="col-8">
            <div class="card shadow-sm border-0 mb-4" style="min-height: 600px;">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Danh sách người dùng</h5>
                    <button class="btn btn-light btn-sm" id="btnShowAddUser">
                        <i class="bi bi-plus-circle me-1"></i> ###
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-hover align-middle table-bordered table-striped">
                            <thead class="table-light">
                                <tr class="text-center">
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
                            <tbody class="text-center">
                                <!-- Dữ liệu sẽ được load bằng JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/taikhoan.js') }}"></script>
@endpush
