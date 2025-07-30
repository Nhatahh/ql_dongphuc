<style>
.password-input-container {
    position: relative;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 5px;
    transform: translateY(-50%);
    cursor: pointer;
}

.toggle-password i {
    font-size: 16px;
    color: #999;
    transition: color 0.3s ease; /* Hiệu ứng màu khi hover */
}
input[type="password"] {
    padding-right: 40px; /* Để cho phù hợp với biểu tượng mắt */
}

.toggle-password:hover i {
    color: #007bff; /* Màu khi hover */
}

.dropdown-divider{
   margin: 0px;
}

</style>
<nav style="border-bottom: 3px solid rgb(10 85 140);"
    class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin24/main" class="nav-link">Trang chủ</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://ctuet.edu.vn" class="nav-link">Liên hệ</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <div class="user-panel mt-1 d-flex" style="margin-right: 10px">
            <div class="info">
                <a href="#" class="d-block" id = "">{{ Auth::guard('loginadmin')->user()->name }}</a>
            </div>
        </div>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="padding:0px">
                <div class="user-panel" style="padding:2px">
                    <img class="img-circle" alt="User Image" src = "/images/start.jpg">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a id = '' onclick = "show_doimatkhau()" class="dropdown-item">
                    <i class="fas fa-key mr-2"></i>Đổi mật khẩu
                </a>
                <div class="dropdown-divider"></div>
                <a onclick = "userLogout_admin()"  class="dropdown-item">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Đăng xuất
                </a>
        </li>
        <!-- Messages Dropdown Menu -->

    </ul>
</nav>
<div class="modal" id="modal_doimatkhau">
    <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
        <div class="row">
            <div class="col-md-2 col-12">
            </div>
            <div class="col-md-8 col-12">
            <div class="card card-navy card-outline" style="width:70%; height:auto; padding: 2px; background-color:#fff; margin-top: 20%;margin-left: 20%;">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-11">
                                <span class="">Đổi mật khẩu</span>
                            </div>
                            <div class="col-md-1 col-lg-1 col-1">
                                <span class="float-right" style="margin-right: 10px"><i onclick="modal_cancel_doimatkhau()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <form id="editnsx">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Mật khẩu cũ</label>
                                        <div class="col-sm-9">
                                            <div class="password-input-container">
                                                <input style="height:28px"  type="password" name = "passwordreset_old" id = 'passwordreset_old' class="validate_changepass form-control">
                                                <div class="toggle-password">
                                                    <i class="fa-solid fa-lock hiddenpassword" id = 'hidden-passwordreset_old'></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 validate_resetpass" id ="error_passwordreset_old" style="font-size: 13px; color : red;text-align: right;"></div>
                                {{--  --}}
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="link" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Mật khẩu mới:</label>
                                        <div class="col-sm-9">
                                            <div class="password-input-container">
                                                <input  style="height:28px"  type="password" name = "passwordreset" id = 'passwordreset'  class="form-control validate_changepass">
                                                <div class="toggle-password">
                                                    <i class="fa-solid fa-lock hiddenpassword" id = 'hidden-passwordreset'></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 validate_resetpass" id ="error_passwordreset" style="font-size: 13px; color : red;text-align: right;"></div>

                                {{--  --}}

                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="link" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Nhập lại mật khẩu mới:</label>
                                        <div class="col-sm-9">
                                            <div class="password-input-container">
                                                <input style="height:28px" type="password" id="passwordreset_confirm" name="passwordreset_confirm" class="validate_changepass form-control">
                                                <div class="toggle-password">
                                                    <i class="fa-solid fa-lock hiddenpassword" id = 'hidden-passwordreset_confirm'></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 validate_resetpass" id ="error_passwordreset_confirm" style="font-size: 13px; color : red;text-align: right;"></div>
                                {{-- <div class="col-md-12 col-12"> --}}
                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                        <div class="row">
                                            <div class="col-md-8 col-12">
                                            </div>
                                            <div class="col-md-2 col-6">
                                                <button type="button" onclick="doimatkhau()" id="btt_update_chucnang" data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                            </div>
                                            {{-- <div class="col-md-2 col-6">
                                                <button type="button" onclick="modal_refresh_setting()" id='Refresh_update_button' data-id="" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                            </div> --}}
                                            <div class="col-md-2 col-6">
                                                <button type="button" id='destroyEditMenu' onclick="modal_cancel_doimatkhau()" class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-12">
            </div>
        </div>
    </div>
</div>
