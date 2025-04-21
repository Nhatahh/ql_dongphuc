@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
    <!-- Body -->
    <div class="body container p-3 mt-2 bg-white">
        <!-- Search -->
        <div class="nav-search-pay row d-flex align-items-center">
            <div class="col-1 text-center py-3">
                <a href="{{ route('uniforms.store') }}" class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
            </div>
            <div class="col-8">
                <div class="search input-group">
                    <input type="text" class="form-control w-50" placeholder="Nhập từ khóa...">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <a class="btn p-3" href="{{ route('orders.cart') }}"><div class="cart col-6"><i class="fa-solid fa-cart-shopping"></i></div></a>
                <a class="btn p-3" href="{{ route('user.profile') }}"><div class="profile col-6"><i class="fa-solid fa-user"></i></div></a>
            </div>
        </div>

        <div class="">
            <div class="row mt-2 mt-md-5 g-0">
                <div class="cart-item border rounded p-2 mb-3 d-flex align-items-center">
                    <input type="checkbox" class="cart-item__checkbox form-check-input ms-2 me-4">
                    <img src="{{ asset('images/product1.jpg') }}" class="cart-item__img img-fluid rounded me-3">
                    <div class="cart-item__content flex-grow-1">
                        <p class="mb-1 fw-bold">Đồng phục sinh viên</p>
                        <p class="text-danger fw-bold mb-1">69,999đ</p>
                        <div class="input-group product-quantity">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, -1)">-</button>
                            <input type="number" class="form-control text-center form-control-sm" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, 1)">+</button>
                        </div>                   
                    </div>
                </div>
            </div>
        </div>

        <div class="pay-method row mt-5 g-0">
            <h3>Phương thức thanh toán</h3>
            <!-- Direct PAY -->
            <div class="direct-pay d-flex justify-content-between">
                <label for="saveDirectPay" class="form-label"><i class="fa-solid fa-money-check-dollar"></i> Thanh toán khi nhận hàng</label>         
                <input type="checkbox" class="form-check-input border-success" id="saveDirectPay">
            </div>
            <!-- MoMo PAY -->
            <div class="momo-pay">
                <button class="btnDesc btn btn-outline-dark p-2" type="button" data-bs-toggle="collapse" data-bs-target="#momo">
                    <i class="fa-solid fa-credit-card"></i> Thanh toán qua Momo
                </button>
                <div class="collapse mt-3" id="momo">
                    <div class="card card-body m-auto">
                        <div class="momo-card">
                            <div class="card-header momo-header py-3">
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-0">Thanh toán bằng MoMo</h4>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <form id="momoPaymentForm">
                                    <div class="mb-3">
                                        <label for="phoneNumber" class="form-label">Số điện thoại MoMo</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+84</span>
                                            <input type="tel" class="form-control" id="phoneNumber" placeholder="Nhập số điện thoại" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Số tiền (VND)</label>
                                        <input type="number" class="form-control" id="amount" placeholder="Nhập số tiền" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Nội dung thanh toán</label>
                                        <input type="text" class="form-control" id="message" placeholder="Nội dung chuyển tiền" required>
                                    </div>
                                    
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="saveInfo">
                                        <label class="form-check-label" for="saveInfo">Lưu thông tin thanh toán</label>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn momo-btn py-2">
                                            <i class="bi bi-wallet2 me-2"></i> Thanh toán ngay
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bank PAY -->
            <div class="bank-pay">
                <button class="btnDesc btn btn-outline-dark p-2" type="button" data-bs-toggle="collapse" data-bs-target="#bank">
                    <i class="fa-solid fa-qrcode"></i> Thanh toán qua ngân hàng
                </button>
                <div class="collapse mt-3" id="bank">
                    <div class="card card-body">
                        <div class="bank-card">
                            <div class="card-header bank-header py-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-bank fs-4 me-2"></i>
                                    <h4 class="mb-0">Thanh toán qua ngân hàng</h4>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <form id="bankPaymentForm">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bankName" class="form-label">Ngân hàng</label>
                                            <select class="form-select" id="bankName" required>
                                                <option value="" selected disabled>Chọn ngân hàng</option>
                                                <option value="VCB">Vietcombank</option>
                                                <option value="BIDV">BIDV</option>
                                                <option value="VIB">VIB</option>
                                                <option value="TCB">Techcombank</option>
                                                <option value="MB">MB Bank</option>
                                                <option value="ACB">ACB</option>
                                                <option value="VPB">VPBank</option>
                                                <option value="SCB">SCB</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="accountNumber" class="form-label">Số tài khoản</label>
                                            <input type="text" class="form-control" id="accountNumber" placeholder="Nhập số tài khoản" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="accountName" class="form-label">Tên chủ tài khoản</label>
                                        <input type="text" class="form-control" id="accountName" placeholder="Tên chủ tài khoản" readonly>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="amount" class="form-label">Số tiền (VND)</label>
                                            <input type="number" class="form-control" id="amount" placeholder="Nhập số tiền" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="feeType" class="form-label">Phí thanh toán</label>
                                            <select class="form-select" id="feeType">
                                                <option value="sender">Người gửi chịu phí</option>
                                                <option value="receiver">Người nhận chịu phí</option>
                                                <option value="shared">Chia đôi phí</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Nội dung thanh toán</label>
                                        <input type="text" class="form-control" id="message" placeholder="Nội dung chuyển tiền" required>
                                    </div>
                                    
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="saveInfo">
                                        <label class="form-check-label" for="saveInfo">Lưu thông tin thanh toán</label>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn bank-btn py-2">
                                            <i class="bi bi-arrow-right-circle me-2"></i> Xác nhận thanh toán
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer bg-white text-center py-3">
                                <p class="mb-0 text-muted">Giao dịch được bảo mật bởi hệ thống ngân hàng</p>
                                <div class="mt-2">
                                    <img src="" alt="Vietcombank" class="bank-logo me-2">
                                    <img src="https://www.bidv.com.vn/portalserver/content/staticContent/bidv/portal/images/logo.png" alt="BIDV" class="bank-logo me-2">
                                    <img src="https://www.vib.com.vn/images/logo.png" alt="VIB" class="bank-logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail-pay row mt-5 g-0">
            <h3>Chi tiết thanh toán</h3>
            <div class="pay-total d-flex justify-content-between">
                <span>Tổng thanh toán:</span>
                <span>150,000đ</span>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection

