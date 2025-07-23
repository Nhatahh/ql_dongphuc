@extends('layouts.admin.body')

@section('title', 'Nhà sản xuất')

@section('content')
<!-- Body -->
<div class="col-md-10 main-content">
    <div class="row">
        <!-- Table Column -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4" style="min-height: 600px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-folder-fill me-2"></i> Danh sách nhà sản xuất
                    </h5>
                    <button class="btn btn-light btn-sm" id="btnShowAddNSX">
                        <i class="bi bi-plus-circle me-1"></i> Thêm nhà sản xuất
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered table-striped" id="tableNhaSanXuat">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã nhà sản xuất</th>
                                    <th scope="col">Tên nhà sản xuất</th>
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
<!-- Modal Thêm NSX -->
<div class="modal fade" id="modalAddNSX" tabindex="-1" aria-labelledby="modalAddNSXLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formAddNSX">
            <div class="modal-header">
            <h5 class="modal-title" id="modalAddNSXLabel">Thêm nhà sản xuất</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="add_ten" class="form-label">Tên nhà sản xuất</label>
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
<!-- Modal Sửa nhà sản xuất -->
<div class="modal fade" id="modalEditNSX" tabindex="-1" aria-labelledby="modalEditNSXLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formEditNSX">
            <div class="modal-header">
            <h5 class="modal-title" id="modalEditNSXLabel">Chỉnh sửa nhà sản xuất</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="edit_nsx_id" class="form-label">Mã nhà sản xuất</label>
                <input type="text" class="form-control" name="nsx_id" id="edit_nsx_id" readonly>
            </div>
            <div class="mb-3">
                <label for="edit_ten" class="form-label">Tên nhà sản xuất</label>
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
    const NSXDataUrl = "{{ route('admin.getDataNSX') }}";
</script>
@push('scripts')
    <script src="{{ asset('js/admin/nhasanxuat.js') }}"></script>
@endpush