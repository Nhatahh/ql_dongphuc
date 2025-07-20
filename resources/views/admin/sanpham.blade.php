@extends('layouts.admin.body')

@section('title', 'Sản Phẩm')

@section('content')
<div class="col-md-10 main-content">
    <div class="row g-4">
        <!-- Form nhập sản phẩm -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-2">
                    <h6 class="mb-0">Thêm sản phẩm</h6>
                </div>
                <div class="card-body">
                    <form id="formSanpham" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="sanphamInput" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="sanphamInput">
                            <span class="text-danger small" id="err_sanphamInput"></span>
                        </div>

                        <div class="mb-3">
                            <label for="imgIP" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="imgIP" name="image" accept="image/*">
                            <span class="text-danger small" id="err_imgIP"></span>
                        </div>

                        <div class="mb-3">
                            <label for="motaInput" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="motaInput" rows="2"></textarea>
                            <span class="text-danger small" id="err_motaInput"></span>
                        </div>

                        <div class="mb-3">
                            <label for="giaInput" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="giaInput">
                            <span class="text-danger small" id="err_giaInput"></span>
                        </div>

                        <div class="mb-3">
                            <label for="tonkhoInput" class="form-label">Tồn kho</label>
                            <input type="number" class="form-control" id="tonkhoInput">
                            <span class="text-danger small" id="err_tonkhoInput"></span>
                        </div>

                        <div class="mb-3">
                            <label for="select2DM" class="form-label">Danh mục</label>
                            <select class="form-select" id="select2DM" style="width: 100%;"></select>
                            <span class="text-danger small" id="err_select2DM"></span>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="button" id="addSP" class="btn btn-success">
                                <i class="fas fa-upload"></i> Thêm sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white py-2">
                    <h6 class="mb-0">Danh sách sản phẩm</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="productsTable" class="table table-striped table-hover table-bordered w-100">
                            <thead class="table-light">
                                <tr>
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
                            <!-- tbody sẽ được DataTable render -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    const sanphamDataUrl = "{{ route('admin.sanpham.data') }}";
</script>
@push('scripts')
<script src="{{ asset('js/admin/sanpham.js') }}"></script>
@endpush