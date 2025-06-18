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
      <a class="btn p-3 notificationBtn" href="" id="notificationBtn" data-url-notifications="{{ route('notifications') }}">
        <div class="cart col-6 notification position-relative w-100">
          <i class="fa-regular fa-bell"></i>
          <!-- <span id="notificationDot" class="position-absolute translate-middle p-1 bg-danger border border-light rounded-circle notificationDot"></span> -->
        </div>
      </a>
    </div>
    <!-- Modal thông báo -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thông báo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="notificationContent">
            <p>Đang tải...</p>
          </div>
        </div>
      </div>
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
    <ul class="nav nav-pills mb-3 justify-content-center text-center flex-wrap gap-3" id="pills-tab" role="tablist">
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
          <i class="fa-solid fa-ticket"></i>
          <span>Hỗ trợ</span>
        </button>
      </li>
      <li class="nav-item mx-4" role="presentation">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
        <button class="nav-link d-flex flex-column align-items-center" type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
          <span>Đăng xuất</span>
        </button>
      </li>
    </ul>

    <hr>
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
                        <p class="fw-semibold fs-5 mb-1"><strong>🧾 Mã hóa đơn:</strong> HD{{ $order->hd_id }}</p>
                        <p class="mb-1 fs-5"><strong>📅 Ngày tạo:</strong> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                        <p class="mb-1 fs-5"><strong>🚚 Trạng thái:</strong> {{ $order->trangthai }}</p>
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

        <!-- Modal đơn hàng -->
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
        <div class="container my-4">
          @foreach ($groupedHistory as $hd_id => $hoaDon)
            <div class="p-3 border rounded shadow-sm bg-white mb-4">
              {{-- Header hóa đơn --}}
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <strong>Mã hóa đơn: HD{{ $hd_id }}</strong>
                </div>
                <div>
                  <span class="text-success me-3">🚚 Giao hàng thành công</span>
                  <span class="text-danger fw-bold">{{ $hoaDon['trangthai'] }}</span>
                </div>
              </div>

              {{-- Danh sách sản phẩm --}}
              @foreach ($hoaDon['sanphams'] as $sp)
                <div class="d-flex border-top py-3">
                  <img src="{{ asset('images/' . $sp['hinhanh']) }}" alt="" width="60" class="me-3">
                  <div class="flex-grow-1">
                    <p class="mb-1 fw-bold">Tên sản phẩm: {{ $sp['tensp'] }}</p>
                    <p class="text-muted mb-1">Phân loại hàng: {{ $sp['danhmuc'] }}</p>
                    <p class="text-muted mb-1">x{{ $sp['soluong'] }}</p>
                  </div>
                  <div class="text-end text-danger fw-bold">
                    {{-- Giá từng sản phẩm không có ở đây, nếu có thì thêm --}}
                  </div>
                </div>
              @endforeach

              {{-- Tổng tiền và nút --}}
              <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                <div class="text-end w-100">
                  <span class="me-2">Thành tiền:</span>
                  <span class="fs-5 text-danger fw-bold">{{ number_format($hoaDon['tongtien'], 0, ',', '.') }} ₫</span>
                </div>
              </div>
              <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-danger me-2 btn-mualai " data-hdid="{{ $hd_id }}">Mua Lại</button>
                @if ($hoaDon['tt_id'] != 3)
                  <button class="btn btn-outline-secondary btn-review" data-bs-toggle="modal" data-bs-target="#reviewModal" data-hdid="{{ $hd_id }}">
                    Đánh giá
                  </button>
                @endif
              </div>
            </div>
          @endforeach
        </div>

        <!-- Modal Đánh giá -->
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true" >
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" style="max-width: 600px;">
            <form class="modal-content shadow-lg rounded-4 border-0" id="danhGiaForm" method="POST" action="{{ route('reviews.danhgia') }}" enctype="multipart/form-data">
              @csrf
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fs-3" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                
                <div class="mb-3">
                  <label for="rating" class="form-label">Chọn số sao</label>
                  <select id="rating" name="rating" class="form-select" >
                    <option value="" selected disabled>Chọn đánh giá</option>
                    <option value="5">5 - Xuất sắc</option>
                    <option value="4">4 - Tốt</option>
                    <option value="3">3 - Trung bình</option>
                    <option value="2">2 - Kém</option>
                    <option value="1">1 - Rất kém</option>
                  </select>
                  <span class="err_del" id="err_rating" style="color: red; font-size: 12px; background-color: #fff; display: block; margin-top: 2px;"></span>
                </div>
                <div class="mb-3">
                  <label for="image" class="form-label">Upload hình ảnh (tùy chọn)</label>
                  <input type="file" id="image" name="image" class="form-control" accept="image/*" >
                  <span class="err_del" id="err_image" style="color: red; font-size: 12px; background-color: #fff; display: block; margin-top: 2px;"></span>
                </div>
                <div class="mb-3">
                  <label for="comment" class="form-label">Bình luận</label>
                  <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Viết cảm nhận của bạn..."></textarea>
                  <span class="err_del" id="err_comment" style="color: red; font-size: 12px; background-color: #fff; display: block; margin-top: 2px;"></span>
                </div>

                <!-- Có thể thêm input ẩn để gửi id sản phẩm hoặc hóa đơn -->
                <input type="hidden" id="hd_id" name="order_id" value="{{ $hd_id ?? '' }}">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-rating" role="tabpanel" aria-labelledby="pills-rating-tab">
        <!-- Nội dung Hỗ trợ -->
        <!-- <div class="card text-dark bg-light container mt-4 p-5" style="max-width: 600px;"> -->
          <div class="accordion" id="accordionPanelsStayOpenExample">
            <!-- Form hỗ trợ -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button
                  class="accordion-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseOne"
                  aria-expanded="true"
                  aria-controls="panelsStayOpen-collapseOne"
                >
                  <h4 class="fw-bolder">Gửi yêu cầu hỗ trợ</h4>
                </button>
              </h2>
              <div
                id="panelsStayOpen-collapseOne"
                class="accordion-collapse collapse"
                aria-labelledby="panelsStayOpen-headingOne"
              >
                <div class="accordion-body">
                  <div class="card text-dark bg-light container p-5" style="max-width: 600px;">
                    <form action="" method="POST">
                      @csrf
                      <div class="mb-3">
                        <label for="subject" class="form-label">Chủ đề</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Nhập chủ đề hỗ trợ" required>
                      </div>

                      <div class="mb-3">
                        <label for="message" class="form-label">Nội dung</label>
                        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Mô tả chi tiết vấn đề bạn gặp phải" required></textarea>
                      </div>

                      <button type="submit" class="btn btn-primary w-100">📨 Gửi yêu cầu</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Bảo hành -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseTwo"
                  aria-expanded="false"
                  aria-controls="panelsStayOpen-collapseTwo"
                >
                  <h4 class="fw-bolder">Chính sách bảo hành</h4>
                </button>
              </h2>
              <div
                id="panelsStayOpen-collapseTwo"
                class="accordion-collapse collapse"
                aria-labelledby="panelsStayOpen-headingTwo"
              >
                <div class="accordion-body">
                  <h5>1. Đối tượng & thời gian áp dụng:</h5>
                  <p>
                    Đối với sản phẩm áo quần: Trong 14 ngày, từ ngày mua hàng theo
                    thời gian ghi trên hoá đơn với các trường hợp bung chỉ, bung
                    nút, kỹ thuật may, giãn cổ áo, quần,… và các trường hợp khác
                    mà NHATAHH có khả năng sửa chữa được. <br />
                    Đối với sản phẩm phụ kiện: Trong 30 ngày, từ ngày mua hàng
                    theo thời gian ghi trên hoá đơn với trường hợp bung đường chỉ,
                    bung quai đeo, hư khoá kéo và tất cả những lỗi kỹ thuật do nhà
                    sản xuất. <br />
                    Lưu ý: <br />
                    – Bạn sẽ được đổi sang sản phẩm mới 100%. <br />
                    – Hình in sản phẩm sẽ không bảo hành.
                  </p>
                  <h5>2. Hỗ trợ sau thời gian bảo hành:</h5>
                  <p>
                    – NHATAHH vẫn tiếp tục hỗ trợ bảo hành những lỗi đơn giản
                    trong vòng 30 ngày kể từ ngày bạn nhận hàng đã bảo hành gửi
                    trả. <br />
                    – Nếu sản phẩm của bạn có lỗi quá nặng do quá trình sử dụng
                    lâu, tụi mình sẽ tư vấn hướng sửa chữa kèm với mức phí tốt
                    nhất để bạn có thể dễ dàng quyết định.
                  </p>
                  <h5>3. Trường hợp không được bảo hành:</h5>
                  <p>
                    – Lỗi do sử dụng: Hình dạng sản phẩm bị thay đổi nhiều (dãn,
                    hư form) <br />
                    – Lỗi do bảo quản không đúng quy cách như: sử dụng chất tẩy
                    rửa mạnh để giặt và gây lem màu, phơi nắng quá lâu làm hư hại
                    sản phẩm… <br />
                    – Sản phẩm hư hỏng do tác động bên ngoài, biến dạng, rách
                    thủng, ẩm mốc, cháy hoặc do người sử dụng làm hỏng. <br />
                    – Sản phẩm đã qua sử dụng bị dơ bẩn. <br />
                    – Sản phẩm đã quá hạn bảo hành.
                  </p>
                </div>
              </div>
            </div>
            <!-- Đổi trả -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button
                  class="accordion-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseThree"
                  aria-expanded="true"
                  aria-controls="panelsStayOpen-collapseThree"
                >
                  <h4 class="fw-bolder">Chính sách đổi trả</h4>
                </button>
              </h2>
              <div
                id="panelsStayOpen-collapseThree"
                class="accordion-collapse collapse"
                aria-labelledby="panelsStayOpen-headingThree"
              >
                <div class="accordion-body">
                  <h5>
                    1. Điều kiện đổi hàng (áp dụng trên toàn hệ thống NHATAHH)
                  </h5>
                  <p>
                    – Áp dụng đổi hàng với tất cả các sản phẩm với điều kiện sản
                    phẩm phải còn nguyên nhãn mác, trong tình trạng chưa qua sử
                    dụng. <br />
                    – Áp dụng 01 lần đổi/ 01 đơn hàng. Sản phẩm đổi phải có giá
                    trị tương đương hoặc cao hơn sản phẩm được đổi. Vui lòng thanh
                    toán chi phí chênh lệch nếu có. <br />
                    – Trường hợp hoàn lại giá trị đơn hàng, tụi mình sẽ hoàn tiền
                    trong vòng 48h làm việc sau khi nhận được yêu cầu từ các bạn.
                    <br />
                    Lưu ý: <br />
                    – Với trường hợp sản phẩm bị cắt tag, trong vòng 1 ngày kể từ
                    khi nhận, bạn hãy gửi phản hồi về tụi mình để được giải quyết.
                    Sau 1 ngày chúng mình sẽ không giải quyết đơn đổi trả. <br />
                    – Bạn vui lòng gửi cho chúng mình clip đóng gói các mặt của
                    sản phẩm, không cắt ghép, chỉnh sửa đơn hàng đổi trả của bạn,
                    nhân viên tư vấn sẽ xác nhận và tiến hành lên đơn đổi trả cho
                    bạn.
                  </p>
                  <h5>2. Dịch vụ đổi hàng tận nơi</h5>
                  <p>
                    Với dịch vụ này, NHATAHH mong muốn mang lại sự tiện lợi và
                    những trải nghiệm tuyệt vời khi mua sắm: <br />
                    – Đổi hàng tận nơi, shipper sẽ đến tận nhà để đổi hàng cho
                    bạn. <br />
                    – Áp dụng 01 lần đổi/ 01 đơn hàng.
                  </p>
                  <h5>3. Chi phí vận chuyển</h5>
                  <p>
                    <b>a. Chi phí vận chuyển khi đổi hàng được NHATAHH hỗ trợ:</b>
                    <br />
                    – Size không phù hợp: Miễn phí 100% phí vận chuyển <br />
                    – Bạn mong muốn đối sản phẩm khác (không mắc lỗi sản xuất): Hỗ
                    trợ phí 1 chiều <br />
                    – Sản phẩm lỗi: Hỗ trợ phí 2 chiều <br />
                    <b>b. Chi phí vận chuyển không được NHATAHH hỗ trợ:</b>
                    <br />
                    – Với sản phẩm trong chương trình khuyến mãi, nếu bạn muốn đổi
                    sang sản phẩm khác phải tự chi trả chi phí vận chuyển.
                  </p>
                </div>
              </div>
            </div>
          </div>
        <!-- </div> -->
      </div>
    </div>
  </div>  
</div>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('.btn-review').forEach(button => {
    button.addEventListener('click', function () {
      document.getElementById('hd_id').value = this.dataset.hdid;
    });
  });
</script>
@endpush
