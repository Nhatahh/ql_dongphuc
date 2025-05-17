@extends('layouts.app')

@section('title', 'Trang Cá Nhân')

@section('content')
<!-- Body -->
<div class="body container mt-2 bg-white">    
  <div class="body-bar row d-flex align-items-center">
    <div class="col-1 text-center py-3">
        <a href="{{ route('uniforms.store') }}" class=" text-decoration-none"><i class="back-icon fa-solid fa-chevron-left p-3 d-block"></i></a>
    </div>
    <div class="col-10 d-flex justify-content-center fw-bolder fs-1">
      TRANG CÁ NHÂN
    </div>
    <div class="col-1 d-flex justify-content-end">
      <a class="btn p-3" href="{{ route('orders.cart') }}"><div class="cart col-6"><i class="fa-regular fa-bell"></i></div></a>
    </div>
  </div>


  <div class="user-info d-flex flex-column align-items-center">
    @if ($userInfo)
      <img class="img-fluid mb-4 mt-4" src="{{ asset('images/avt/' . $userInfo->avt_url) }}" alt="">
      <table class="table table-bordered mx-auto" style="width: 600px;">
        <tbody>
          <tr>
              <th scope="row" style="width: 200px;">Mã sinh viên:</th>
              <td>{{ $userInfo->mssv }}</td>
          </tr>
          <tr>
              <th scope="row">Họ tên:</th>
              <td>{{ $userInfo->hoten }}</td>
          </tr>
          <tr>
              <th scope="row">Email:</th>
              <td>{{ $userInfo->email }}</td>
          </tr>
          <tr>
              <th scope="row">Số điện thoại:</th>
              <td>{{ $userInfo->sdt }}</td>
          </tr>
          <tr>
              <th scope="row">Địa chỉ:</th>
              <td>{{ $userInfo->diachi }}</td>
          </tr>
        </tbody>
      </table>
    @endif
  </div>

  <div class="container">
    <ul class="nav nav-pills mb-3 justify-content-center text-center flex-wrap" id="pills-tab" role="tablist">
      <li class="nav-item mx-4" role="presentation">
        <button class="nav-link active d-flex flex-column align-items-center" id="pills-order-tab" data-bs-toggle="pill" data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order" aria-selected="true">
          <i class="fa-solid fa-box-open mb-1"></i>
          <span>Đơn hàng</span>
        </button>
      </li>
      <li class="nav-item mx-4" role="presentation">
        <button class="nav-link d-flex flex-column align-items-center" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" type="button" role="tab" aria-controls="pills-history" aria-selected="false">
          <i class="fa-solid fa-clock-rotate-left mb-1"></i>
          <span>Lịch sử mua</span>
        </button>
      </li>
      <li class="nav-item mx-4" role="presentation">
        <button class="nav-link d-flex flex-column align-items-center" id="pills-rating-tab" data-bs-toggle="pill" data-bs-target="#pills-rating" type="button" role="tab" aria-controls="pills-rating" aria-selected="false">
          <i class="fa-regular fa-star mb-1"></i>
          <span>Đánh giá</span>
        </button>
      </li>
      <li class="nav-item mx-4" role="presentation">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
        <button class="nav-link d-flex flex-column align-items-center" type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right mb-1"></i>
          <span>Đăng xuất</span>
        </button>
      </li>
    </ul>

  
    <div class="tab-content mt-4 mb-4" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab">
        <!-- Nội dung Đơn hàng -->
        <div id="order-tab">
          <div class="cart-list container mt-4 p-2" style="max-width: 600px;">
            <div class="row g-3">
              @foreach ($orders as $order)
                <div class="col-12">
                  <div class="card shadow border border-dark rounded-4">
                    <div class="card-body d-flex flex-column flex-md-row gap-2 justify-content-evenly align-items-center">
                      <div class="mb-md-0">
                        <p class="fw-semibold fs-5 mb-1">🧾 <strong>Mã hóa đơn:</strong> HD{{ $order->hd_id }}</p>
                        <p class="mb-1 fs-5"><strong>📅 Ngày tạo:</strong> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                        <p class="text-danger mb-0 fs-5"><strong>💰 Tổng tiền:</strong> {{ number_format($order->tongtien, 0, ',', '.') }} ₫</p>
                      </div>
                      <button class="btn btn-outline-primary btn-sm mt-md-0 fw-bold fs-5 rounded-2 btn-detail-order"
                        data-bs-toggle="modal"
                        data-bs-target="#orderDetailModal"
                        data-hd-id="{{ $order->hd_id }}">
                        🔍 Xem chi tiết
                      </button>
                      <button class="btn btn-outline-danger btn-sm mt-md-0 fs-5 fw-bold rounded-2 btn-cancel-order"
                        data-hd-id="{{ $order->hd_id }}"                      
                        data-url-cancel-order="{{ route('orders.cancel') }}">                        
                        <i class="bi bi-cart-x-fill"></i> Hủy đơn hàng
                      </button>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" style="max-width: 600px;">
            <div class="modal-content shadow-lg rounded-4 border-0">
              <div class="modal-header bg-primary text-white">
                <p class="modal-title fs-3" id="orderDetailModalLabel">Chi tiết sản phẩm</p>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
              </div>
              <div class="modal-body">
                <div id="order-products-list" class="d-flex flex-column gap-3">
                  <!-- Load sản phẩm -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
        <!-- Nội dung Lịch sử mua -->
      </div>
      <div class="tab-pane fade" id="pills-rating" role="tabpanel" aria-labelledby="pills-rating-tab">
        <!-- Nội dung Đánh giá -->
      </div>
    </div>
  </div>  
</div>
@endsection

@push('scripts')
<script>
  

  
</script>
@endpush
