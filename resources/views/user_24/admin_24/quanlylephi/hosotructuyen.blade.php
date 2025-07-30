<!doctype html>
<html class="no-js" lang="">
@include('user_24.admin_24.header')

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Thanh header_top (màu xanh) -->
    @include('user_24.admin_24.header_top')
    <!-- Thanh header_top (màu xanh) -->
    <!-- Menu điện thoại-->
    <div class="mobile-menu-area">
        @include('user_24.admin_24.mobie_menu')
    </div>
    <!-- Menu điện thoại -->
    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        @include('user_24.admin_24.menu')
    </div>
    <!-- Main Menu area End-->
    <!-- Thống kê cơ bản -->
    <!-- Content -->
    <div class="container">
        <div class="sale-statistic-inner notika-shadow mg-t-10" style="min-height:450px;" id ="">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label class="col-sm-3  col-md-4 lb_input-group">Năm tuyển sinh:</label>
                        <div class="col-sm-9  col-md-8">
                            <select onchange="loadhosolephi()" class="form-control sl_input-group" id="thanhtoan_namtuyensinh">
                                <option value = "-1">Chọn đợt tuyển sinh</option>
                                <option value = "1">Xét tuyển sớm ĐHCQ 2024</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                    <button onclick="exceldanhsachtructuyen()" style="height: 28px;width:100%" class="btn btn-default notika-btn-default waves-effect"><i class="notika-icon notika-next"></i>&nbsp;&nbsp;Excel</button>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
                    <div style=" box-shadow: 0 1px 8px rgba(0,0,0,.2);margin:10px;padding:5px">
                        <table class="table table-hover table-striped" id = "danhsachthanhtoan">

                        </table>
                    </div>
                </div>
                <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">

                </div>
                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                    Hóa đơn: <span id = "tonghoadon"></span>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                    Thí sinh: <span id = "tongthisinh"></span>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                    Tổng thu: <span id = "tongtien"></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Content -->








    <!-- Start Footer area-->
    <div class="footer-copyright-area">
        @include('user_24.admin_24.footer_bot')
    </div>
    <!-- End Footer area-->

    <!-- Start Footer-->
    @include('user_24.admin_24.footer')
    <!-- End Footer -->

</body>

</html>
<script src="/admin/admin_24/js/vendor/jquery-1.12.4.min.js"></script>
<script src="/admin/admin_24/plugins/select2/select2.js"></script>
<script src="/admin/admin_24/js/data-table/jquery.dataTables.min.js"></script>
<script src="/admin/admin_24/jsconfig/quanlylephi/hosotructuyen.js"></script>
{{-- <script src="/admin/admin_24/js/bootstrap-select/bootstrap-select.js"></script> --}}
