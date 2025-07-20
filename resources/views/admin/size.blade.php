@extends('layouts.admin.body')

@section('title', 'Size')

@section('content')
<!-- Body -->
<div class="col-md-10 main-content">
    <div class="row">
        <!-- Table Column -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-folder-fill me-2"></i> Danh sách size
                    </h5>
                    <button class="btn btn-light btn-sm">
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
    const SizeDataUrl = "{{ route('admin.getDataSize') }}";
</script>
@push('scripts')
    <script src="{{ asset('js/admin/size.js') }}"></script>
@endpush