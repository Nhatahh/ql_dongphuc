@extends('layouts.admin.body')

@section('title', 'Sản Phẩm')

@section('content')
<!-- Body -->
    <div class="col-md-10 main-content">
        <div class="row">
            <!-- Form Column -->
            <div class="col-md-3">
                <div class="form-container mb-4">
                    <form method="" enctype="multipart/form-data" action="">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Tên sản phẩm</label>
                            <input  type="text" class="form-control search" id="sanphamInput" style="height:28px;">
                            <span class="err_del" id="err_sanphamInput" style="color: red; font-size: small; font-weight: bold; background-color: #fff; display: block; margin-top: 2px;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Hình ảnh</label>
                            <input type="file" class="form-control" id="imgIP" name="image" accept="image/*" style="height:28px;">
                            <span class="err_del" id="err_imgIP" style="color: red; font-size: small; font-weight: bold; background-color: #fff; display: block; margin-top: 2px;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Mô tả</label>
                            <input  type="text" class="form-control search" id="motaInput" style="height:28px;">
                            <span class="err_del" id="err_motaInput" style="color: red; font-size: small; font-weight: bold; background-color: #fff; display: block; margin-top: 2px;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Giá</label>
                            <input  type="number" class="form-control search" id="giaInput" style="height:28px;">
                            <span class="err_del" id="err_giaInput" style="color: red; font-size: small; font-weight: bold; background-color: #fff; display: block; margin-top: 2px;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Tồn kho</label>
                            <input  type="number" class="form-control search" id="tonkhoInput" style="height:28px;">
                            <span class="err_del" id="err_tonkhoInput" style="color: red; font-size: small; font-weight: bold; background-color: #fff; display: block; margin-top: 2px;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Danh mục</label>
                            <select class="form-control" id="select2DM" onchange="" style="width: 100%;"></select>
                            <span class="err_del" id="err_select2DM" style="color: red; font-size: small; font-weight: bold; background-color: #fff; display: block; margin-top: 2px;"></span>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 col-6">
                                <button type="button" id="addSP" onclick="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-upload"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Column -->
            <div class="col-md-9">
                <div class="table-container">
                    <h5 class="mb-3">DANH SÁCH SẢN PHẨM</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" style="width: 100%" id="dsSanpham">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection