@extends('layouts.admin.body')

@section('title', 'Bán Hàng')

@section('content')
<!-- Body -->
    <div class="col-md-10 main-content">
        <div class="row">
            <!-- Form Column -->
            <div class="col-md-4">
                <div class="form-container mb-4">
                    <form>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" id="productName">
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="productName">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="price">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Ngày đặt</label>
                            <input type="date" class="form-control" id="price">
                        </div>
                        <button type="submit" class="btn btn-danger add-btn">Thêm</button>
                    </form>
                </div>
            </div>

            <!-- Table Column -->
            <div class="col-md-8">
                <div class="table-container">
                    <h5 class="mb-3">DANH SÁCH ĐƠN HÀNG</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên tài khoản</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Võ Kiều My</td>
                                    <td>Áo thun</td>
                                    <td>3</td>
                                    <td>300.000đ</td>
                                    <td><span class="con-hang">Đang giao</span></td>
                                    <td class="btn-con">
                                        <a href="#" class="btn btn-primary">Sửa</a>
                                        <a href="#" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Võ Kiều My</td>
                                    <td>Áo thun</td>
                                    <td>3</td>
                                    <td>300.000đ</td>
                                    <td><span class="con-hang">Đang giao</span></td>
                                    <td class="btn-con">
                                        <a href="#" class="btn btn-primary">Sửa</a>
                                        <a href="#" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Võ Kiều My</td>
                                    <td>Áo thun</td>
                                    <td>3</td>
                                    <td>300.000đ</td>
                                    <td><span class="con-hang">Đang giao</span></td>
                                    <td class="btn-con">
                                        <a href="#" class="btn btn-primary">Sửa</a>
                                        <a href="#" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Võ Kiều My</td>
                                    <td>Áo thun</td>
                                    <td>3</td>
                                    <td>300.000đ</td>
                                    <td><span class="con-hang">Đang giao</span></td>
                                    <td class="btn-con">
                                        <a href="#" class="btn btn-primary">Sửa</a>
                                        <a href="#" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Võ Kiều My</td>
                                    <td>Áo thun</td>
                                    <td>3</td>
                                    <td>300.000đ</td>
                                    <td><span class="con-hang">Đang giao</span></td>
                                    <td class="btn-con">
                                        <a href="#" class="btn btn-primary">Sửa</a>
                                        <a href="#" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection