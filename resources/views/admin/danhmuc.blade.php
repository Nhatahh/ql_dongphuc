@extends('layouts.admin.body')

@section('title', 'Danh Mục')

@section('content')
<!-- Body -->
    <div class="col-md-10 main-content">
        <div class="row">
            <!-- Form Column -->
            <div class="col-md-3">
                <div class="form-container mb-4">
                    <form id="danhmucForm" action="{{ route('admin.themDM') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="productName" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" id="dmInput" name="dmInput">
                            <span class="err_del" id="err_dmInput" style="color: red; font-size: small; font-weight: bold; background-color: #fff; display: block; margin-top: 2px;"></span>
                        </div>
                        <button type="submit" class="btn btn-danger add-btn">Thêm</button>
                    </form>
                </div>
            </div>

            <!-- Table Column -->
            <div class="col-md-9">
                <div class="table-container">
                    <h5 class="mb-3">DANH SÁCH DANH MỤC</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" style="width: 100%" id="dsDM">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection