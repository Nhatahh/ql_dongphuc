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
            @if ($user->isNotEmpty())
                <img class="img-fluid mb-4 mt-4" src="{{ asset('images/avt/' . $user->first()->avt_url) }}" alt="">
                <table class="table table-bordered mx-auto" style="width: 600px;">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 200px;">Mã sinh viên:</th>
                            <td>{{ $user->first()->mssv }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Họ tên:</th>
                            <td>{{ $user->first()->hoten }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email:</th>
                            <td>{{ $user->first()->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Số điện thoại:</th>
                            <td>{{ $user->first()->sdt }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Địa chỉ:</th>
                            <td>{{ $user->first()->diachi }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>

        <ul class="tabs d-flex justify-content-center mt-5 text-center">
        <li class="tab--active">
            <a href="#order-tab" class="d-flex flex-column align-items-center text-decoration-none text-dark">
            <i class="icon-active fa-solid fa-box-open"></i>
            <span>Đơn hàng</span>
            </a>
        </li>
        <li>
          <a
            href="#purchase-history-tab"
            class="d-flex flex-column align-items-center text-decoration-none text-dark"
          >
            <i class="icon-active fa-solid fa-clock-rotate-left"></i>
            <span>Lịch sử mua</span>
          </a>
        </li>
        <li>
          <a
            href="#rating-tab"
            class="d-flex flex-column align-items-center text-decoration-none text-dark"
          >
            <i class="icon-active fa-regular fa-star"></i>
            <span>Đánh giá</span>
          </a>
        </li>
        <li>
          <a
            href="{{ route('user.sign_in') }}"
            class="d-flex flex-column align-items-center text-decoration-none text-dark"
          >
            <i class="icon-active bi bi-box-arrow-right"></i>
            <span>Đăng xuất</span>
          </a>
        </li>
      </ul>


      <hr>


      <!-- Order Tab -->
      <div id="order-tab">
        <div class="cart-list col-12 mt-4 p-4" style="max-height: 75vh">
          <div class="row mt-5">
            @foreach ($user as $u)
            <div
              class="cart-item border rounded p-2 mb-3 d-flex align-items-center"
            >
              <input
                type="checkbox"
                class="cart-item__checkbox form-check-input ms-2 me-4"
              />
              <img src="{{ asset('images/' . $u->image_url) }}"
                class="cart-item__img img-fluid rounded me-3"
              />
              <div class="cart-item__content flex-grow-1">
                <p class="mb-1 fw-bold">{{ $u->tensp }}</p>
                <p class="text-danger fw-bold mb-1">{{ $u->gia }}</p>
              </div>
              <button class="btn btn-danger">Hủy hàng</button>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Purchase History Tab -->
      <div id="purchase-history-tab">
        <div class="cart-list col-12 mt-4 p-4" style="max-height: 75vh">
          <div class="row mt-5">
          @foreach ($user as $u)
            <div
              class="cart-item border rounded p-2 mb-3 d-flex align-items-center"
            >
              <input
                type="checkbox"
                class="cart-item__checkbox form-check-input ms-2 me-4"
              />
              <img
                src="{{ asset('images/' . $u->image_url) }}"
                class="cart-item__img img-fluid rounded me-3"
              />
              <div class="cart-item__content flex-grow-1">
                <p class="mb-1 fw-bold">Đồng phục sinh viên</p>
                <p class="text-danger fw-bold mb-1">69,999đ</p>
                <div class="input-group" style="max-width: 60px">
                  <button
                    class="btn btn-outline-secondary btn-sm"
                    type="button"
                    onclick="changeQuantity(this, -1)"
                  >
                    -
                  </button>
                  <input
                    type="number"
                    class="form-control text-center form-control-sm"
                    value="1"
                    min="1"
                  />
                  <button
                    class="btn btn-outline-secondary btn-sm"
                    type="button"
                    onclick="changeQuantity(this, 1)"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>
          @endforeach
          </div>
        </div>
      </div>
@endsection

@push('scripts')
    <script>
        // new profileTab('.tabs')
    </script>
@endpush