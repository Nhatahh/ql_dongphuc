@extends('layouts.app')

@section('title', 'Cửa Hàng')

@section('content')
    <!-- Body -->
    <div class="body container p-3">
        <!-- Search -->
        <div class="nav-search row d-flex align-items-center bg-white p-2">
            <div class="col-9">
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
        <!-- List Menu -->
        <ul class="menu-list row mt-3 gap-1 justify-content-around">
            <li class="menu-item btn col-2">Mới nhất</li>
            <li class="menu-item btn col-2">Phổ biến</li>
            <li class="menu-item btn col-2">Bán chạy</li>
            <li class="menu-item btn filter col-2" data-bs-toggle="collapse" data-bs-target="#filter-modal">Lọc</li>
                <!-- Modal filter -->
                <form action="" method="" id="filter-modal" class="collapse">
                    <div class="gender d-flex mt-2" style="font-size: 1.2rem;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                            <label class="form-check-label" for="male">Nam</label>
                        </div>
                        <div class="form-check" style="margin-left: 10px;">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="female">Nữ</label>
                        </div>
                    </div>
                    <select class="form-select mt-2">
                        <option selected>Loại</option>
                        <option value="">Áo thể dục</option>
                        <option value="">Quần thể dục</option>
                        <option value="">Áo sơ mi</option>
                        <option value="">Quần sơ mi</option>
                    </select>
                    <select class="form-select mt-2">
                        <option selected>Size</option>
                        <option value="">S</option>
                        <option value="">M</option>
                        <option value="">L</option>
                        <option value="">XL</option>
                    </select>   
                    <select class="form-select mt-2">
                        <option selected>Giá</option>
                        <option value="">Giảm dần</option>
                        <option value="">Tăng dần</option>
                    </select>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-danger w-50">OK</button>   
                    </div>
                </form>
        </ul>
        <!-- Product -->
        <div class="product-list">
            <div class="row">
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product3.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product2.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product1.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product1.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product2.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product3.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product1.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 mt-4">
                    <a href="{{ route('uniforms.show_detail') }}" class="text-decoration-none text-dark">
                        <div class="product-item card">
                            <img src="{{ asset('images/product2.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Đồng phục sinh viên</h5>
                              <p class="card-text">Trẻ trung, năng động và tràn đầy nằng lượng</p>
                              <div class="text-center">
                                <a href="{{ route('orders.cart') }}" class="order text-white btn btn-primary card-link mt-4"><i class="fa-solid fa-gift me-1"></i> Đặt hàng</a>
                              </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        const navLinks = document.querySelectorAll('.nav-footer .nav-item')
        navLinks.forEach((item, i) => {
            item.onclick = () => {
                localStorage.setItem('navLink', i)
            }
        })
        document.addEventListener("DOMContentLoaded", function () {
        const activeId = localStorage.getItem("activeLink");
        if (activeId) {
        document.querySelector(`.nav-footer .nav-item[data-id="${activeId}"]`)?.classList.add("active");
        }
    });
    </script>
@endsection