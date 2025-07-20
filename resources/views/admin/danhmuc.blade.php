@extends('layouts.admin.body')

@section('title', 'Loại sản phẩm')

@section('content')
<!-- Body -->
<div class="col-md-10 main-content">
    <div class="row">
        <!-- Table Column -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-folder-fill me-2"></i> Danh sách loại sản phẩm
                    </h5>
                    <button class="btn btn-light btn-sm" id="btnShowAddDanhMuc">
                        <i class="bi bi-plus-circle me-1"></i> Thêm loại sản phẩm
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered table-striped" id="tableDanhMuc">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã loại sản phẩm</th>
                                    <th scope="col">Tên loại sản phẩm</th>
                                    <th scope="col">Hành động</th>
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
<!-- Modal Thêm Danh Mục -->
<div class="modal fade" id="modalAddDanhMuc" tabindex="-1" aria-labelledby="modalAddDanhMucLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formAddDanhMuc">
            <div class="modal-header">
            <h5 class="modal-title" id="modalAddDanhMucLabel">Thêm loại sản phẩm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="add_ten" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" name="ten" id="add_ten" required>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-success">Thêm mới</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- Modal Sửa Danh Mục -->
<div class="modal fade" id="modalEditDanhMuc" tabindex="-1" aria-labelledby="modalEditDanhMucLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formEditDanhMuc">
            <div class="modal-header">
            <h5 class="modal-title" id="modalEditDanhMucLabel">Chỉnh sửa danh mục</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="edit_dm_id" class="form-label">Mã danh mục</label>
                <input type="text" class="form-control" name="dm_id" id="edit_dm_id" readonly>
            </div>
            <div class="mb-3">
                <label for="edit_ten" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" name="ten" id="edit_ten" required>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
        </div>
    </div>
</div>


@endsection

<script>
    const DanhMucDataUrl = "{{ route('admin.getDataDanhMuc') }}";
</script>
@push('scripts')
    <script src="{{ asset('js/admin/danhmuc.js') }}"></script>
@endpush