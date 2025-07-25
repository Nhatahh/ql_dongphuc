@extends('layouts.admin.body')

@section('title', 'Sản Phẩm')

@section('content')

<!-- Body -->
<div class="col-md-10 main-content">
    <div class="row">
        <!-- Danh sách kho -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-folder-fill me-2"></i> Danh sách kho
                    </h5>
                    <button class="btn btn-light btn-sm" id="btnShowAddSP">
                        <i class="bi bi-plus-circle me-1"></i> Thêm kho
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tonkhoTable" class="table table-hover align-middle table-bordered table-striped">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>Kho ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Size S</th>
                                    <th>Size M</th>
                                    <th>Size L</th>
                                    <th>Size XL</th>
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

<script>
    const khoDataUrl = "{{ route('admin.kho.data') }}";

</script>

@push('scripts')
    <script src="{{ asset('js/admin/kho.js') }}"></script>
@endpush