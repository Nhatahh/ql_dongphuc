@extends('layouts.admin.body')

@section('title', 'Sản Phẩm')

@section('content')
<!-- Body -->
<div class="col-md-10 main-content">
    <div class="row">
        <!-- Danh sách sản phẩm -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-folder-fill me-2"></i> Danh sách sản phẩm
                    </h5>
                    <button class="btn btn-light btn-sm" id="btnShowAddSP">
                        <i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="productsTable" class="table table-hover align-middle table-bordered table-striped">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Danh mục</th>
                                    <th>Nhà sản xuất</th>
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
<!-- Modal thêm sản phẩm -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addSanphamForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sản phẩm mới</h5>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="tensp" class="form-control" id="tensp">
                        <div class="invalid-feedback" id="error-tensp"></div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="mota" class="form-control" id="mota"></textarea>
                        <div class="invalid-feedback" id="error-mota"></div>
                    </div>

                    <div class="form-group">
                        <label>Giá</label>
                        <input type="number" name="gia" class="form-control" id="gia">
                        <div class="invalid-feedback" id="error-gia"></div>
                    </div>

                    <div class="form-group">
                        <label for="danhmuc">Danh mục:</label>
                        <select id="dm_id" name="dm_id" class="form-control select2">
                            <option value="">--- Chọn danh mục ---</option>
                            @foreach ($danhmucs as $dm)
                                <option value="{{ $dm->dm_id }}">{{ $dm->ten }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="error-dm_id"></div>
                    </div>

                    <div class="form-group">
                        <label for="nhasanxuat">Nhà sản xuất:</label>
                        <select id="nsx_id" name="nsx_id" class="form-control select2">
                            <option value="">--- Chọn nhà sản xuất ---</option>
                            @foreach ($nhasanxuats as $nsx)
                                <option value="{{ $nsx->nsx_id }}">{{ $nsx->ten }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="error-nsx_id"></div>
                    </div>

                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="file" id="image_url" name="image_url" class="form-control" accept="image/*" >
                        <div class="invalid-feedback" id="error-image_url"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal sửa sản phẩm -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="editSanphamForm">
            <div class="modal-header">
            <h5 class="modal-title">Sửa sản phẩm</h5>
            </div>
            <div class="modal-body">
            <input type="hidden" id="edit_sp_id" name="sp_id">
            
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" id="edit_tensp" name="tensp" class="form-control">
                <div class="invalid-feedback" id="error-tensp"></div>
            </div>

            <div class="form-group">
                <label>Mô tả</label>
                <textarea id="edit_mota" name="mota" class="form-control"></textarea>
                <div class="invalid-feedback" id="error-mota"></div>
            </div>

            <div class="form-group">
                <label>Giá</label>
                <input type="number" id="edit_gia" name="gia" class="form-control">
                <div class="invalid-feedback" id="error-gia"></div>
            </div>

            <div class="form-group">
                <label>Danh mục</label>
                <select id="edit_dm_id" name="dm_id" class="form-control select2"></select>
                <div class="invalid-feedback" id="error-dm_id"></div>
            </div>

            <div class="form-group">
                <label>Nhà sản xuất</label>
                <select id="edit_nsx_id" name="nsx_id" class="form-control select2"></select>
                <div class="invalid-feedback" id="error-nsx_id"></div>
            </div>

            <div class="form-group">
                <label>Hình ảnh hiện tại:</label>
                <img id="current_image" src="" width="100">
                <input type="hidden" name="image_old" id="image_old">
                <input type="file" name="image_url" id="edit_image_url" class="form-control mt-2">
                <div class="invalid-feedback" id="error-image_url"></div>
            </div>
            </div>

            <div class="modal-footer">
            <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
        </div>
    </div>
</div>


@endsection

<script>
    const sanphamDataUrl = "{{ route('admin.sanpham.data') }}";
    $("#add_dm_id").select2({
        width: "100%",
    });
    $("#add_nsx_id").select2({
        width: "100%",
    });
</script>
@push('scripts')
    <script src="{{ asset('js/admin/sanpham.js') }}"></script>
@endpush