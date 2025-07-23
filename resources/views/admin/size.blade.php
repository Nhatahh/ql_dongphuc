@extends('layouts.admin.body')

@section('title', 'Size')

@section('content')
<!-- Body -->
<div class="col-md-10 main-content">
    <div class="row">
        <!-- Table Column -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4" style="min-height: 600px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-folder-fill me-2"></i> Danh sách size
                    </h5>
                    <button class="btn btn-light btn-sm" id="btnShowAddSize">
                        <i class="bi bi-plus-circle me-1"></i> Thêm size
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered table-striped" id="tableSize">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã size</th>
                                    <th scope="col">Tên size</th>
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
<!-- Modal Thêm Size -->
<div class="modal fade" id="modalAddSize" tabindex="-1" aria-labelledby="modalAddSizeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formAddSize">
            <div class="modal-header">
            <h5 class="modal-title" id="modalAddSizeLabel">Thêm size</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="add_ten" class="form-label">Tên size</label>
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
<!-- Modal Sửa size -->
<div class="modal fade" id="modalEditSize" tabindex="-1" aria-labelledby="modalEditSizeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formEditSize">
            <div class="modal-header">
            <h5 class="modal-title" id="modalEditSizeLabel">Chỉnh sửa size</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="edit_size_id" class="form-label">Mã size</label>
                <input type="text" class="form-control" name="size_id" id="edit_size_id" readonly>
            </div>
            <div class="mb-3">
                <label for="edit_ten" class="form-label">Tên size</label>
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
    const SizeDataUrl = "{{ route('admin.getDataSize') }}";
</script>
@push('scripts')
    <script src="{{ asset('js/admin/size.js') }}"></script>
@endpush