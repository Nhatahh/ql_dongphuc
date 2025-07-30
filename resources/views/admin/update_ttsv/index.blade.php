</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTUT| Hệ thống quả lý hồ sơ</title>
    <link rel="stylesheet" href="/user/css/loading.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    {{-- <link rel="stylesheet" href="/template/admin/plugins/daterangepicker/daterangepicker.css"> --}}
    <link rel="stylesheet" href="/template/admin/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="/user/css/style.css">
    <link   rel="stylesheet"  href="/swiper/swiper.css" />
    <style>
        body{
            font-size: 14px;
        }
        th{
            font-size: 14px;
            text-align: center;
            vertical-align: middle;
        }
        table td{
            font-size: 14px;
            text-align: center;
        }
       
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-primary navbar-expand navbar-dark" style="margin-left:0px" >
        <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block" >
                <img src="\img\CTUT_logo_nen.png" alt="logo CTUT" class="img-circle" style="height:40px;margin-left:20px">
            </li>
            <li class="nav-item d-none d-sm-inline-block" style="margin-left:20px">
                <strong style="text-align: center" class="">
                    <div><strong>TRƯỜNG ĐẠI HỌC KỸ THUẬT - CÔNG  NGHỆ CẦN THƠ</div>
                    <div>HỆ THỐNG TRA CỨU HỒ SƠ TUYỂN SINH - NHẬP HỌC</div></strong>
                </strong>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="https://tuyensinh.ctuet.edu.vn/tuyen-sinh-dai-hoc-2023/huong-dan-nhap-hoc-2023-207.html" role="button">
                    <strong>Hướng dẫn nhập học</strong>
                </a>
            </li>
        </ul>
    </nav>


    {{-- <aside class="main-sidebar elevation-4">
    </aside> --}}


    <div class="content-wrapper" style="margin-left:0px"  >
        <div class="content-header" style="height: 2px">
        </div>

        <section class="content">

            <div class="card" style = "min-height:400px">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="card-header" style="padding:0px"> <span class=""  style="margin-left:10px"><strong>Tìm kiếm thí sinh </strong></span>      
                        </div>
                        <div class="card-body p-1">   
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="update_id_batch_search" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt tuyển sinh:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control ttsv_info" id="update_id_batch_search" name = 'update_id_batch_search' style="width: 100%;">

                                            </select>

                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 col-12">                                
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="update_name_user_search" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ và tên:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control ttsv_info" id="update_name_user_search" name = "update_name_user_search" style="height:28px"value="">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="update_id_card_user_search" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">CMND/CCCD:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control ttsv_info" id="update_id_card_user_search" name = "update_id_card_user_search" style="height:28px"  value="">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-1 col-12">
                                    
                                </div>                                       
                                <div class="col-md-11 col-12">
                                    <div class="card-header" style="padding:0px"></div> 
                                    <div class="card-body p-1"> 
                                        <div class="row">                                         
                                            <div class="col-12 col-md-6 col-md-6">
                                                <button id=""  id-data = "" class="btn btn-block btn-primary btn-xs " onclick="update_ttsv_img_search()"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;Xem file</button>
                                            </div> 
                                            <div class="col-12 col-md-6 col-md-6">
                                                <button id="update_ttsv_search"  id-data = "" class="btn btn-block btn-primary btn-xs " onclick=""><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                            </div> 
                                        </div> 
                                    </div>                            
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-12 col-md-9 col-lg-9">
                        <div class="card-header" style="padding:0px"> <span class=""  style="margin-left:10px"><strong>Thu hồ sơ thí sinh</strong></span>      
                        </div>
                        <div class="card-body p-1" style="border:1px solid rgba(0,0,0,.125);min-height:100px;margin-right:10px">   
                            <div class="row" id="ttsv_load_list_file">                            
                                                               
                            </div>         
                        </div>  
                        <div class="row">                                
                            <div class="col-12 col-md-8 col-lg-8" >
                               
                            </div>
                            <div class="col-12 col-md-2 col-lg-2" >
                                <button type="button"   id = "ttsv_file_clear"   onclick = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                            </div>                          
                            <div class="col-12 col-md-2 col-lg-2" >                              
                                <button type="button"   id = "ttsv_file_save"   onclick = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Lưu</button>
                                {{-- <button type="button"   id = "check_user_save_list_file"   onclick = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Lưu</button> --}}
                            </div>                        
                        </div>      
                    </div>                            
                </div>
                <div class="card" style = "min-height:600px;margin-top:10px;margin: 10px">
                    
                    <div class="card">
                        <div class="card-header" style="padding:0px">
                            <span class="" style="margin-left:10px"><strong>Thông tin nhập học</strong></span>
                        </div>
                        <div class="card-body p-1">
                            <form id ="ttsv_submit">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-md-12">                                   
                                        <div class="row">                                       
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_name_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ và tên:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info" id="ttsv_name_user" name = "ttsv_name_user" style="height:28px" disabled value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_birth_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày sinh<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control ttsv_info" id="ttsv_birth_user" name = "ttsv_birth_user" style="height:28px" placeholder="dd/mm/yyyy" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_sex_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Giới tính<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info" id="ttsv_sex_user" name = 'ttsv_sex_user' style="width: 100%;">

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_nation_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Dân tộc<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info" id="ttsv_id_nation_user" name = 'ttsv_id_nation_user'  style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_religion" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tôn giáo<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info" id="ttsv_id_religion"  name = 'ttsv_id_religion' style="width: 100%;">

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_nationality" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Quốc tịch<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info" id="ttsv_id_nationality" name = 'ttsv_id_nationality' style="width: 100%;">

                                                        </select>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_card_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">CMND/CCCD<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info" id="ttsv_id_card_users" name = "ttsv_id_card_users" disabled style="height:28px"  value="">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_date_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày cấp<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control ttsv_info" id="ttsv_date_card" name = "ttsv_date_card" style="height:28px"  value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_place_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nơi cấp<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info" id="ttsv_id_place_card" name = "ttsv_id_place_card"  style="width: 100%;">

                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_phone_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại<sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info" id="ttsv_phone_users" name = "ttsv_phone_users"  style="height:28px"  value="">
                                                    </div>                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_doan_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đoàn:</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control ttsv_info" id="ttsv_doan_sv" name = "ttsv_doan_sv" style="height:28px"  value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_dang_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đảng:</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control ttsv_info" id="ttsv_dang_sv" name = "ttsv_dang_sv" style="height:28px"  value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_place_user" class="col-sm-5 col-form-label" style="padding-bottom: 0px">Nơi sinh:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:normal">Tỉnh/TP</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control ttsv_info" id="ttsv_id_place_user" name = "ttsv_id_place_user" style="width: 100%;">


                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_noisinh_huyen" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"><span style="font-weight:normal">Huyện/Quận:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info" id="ttsv_noisinh_huyen" name = "ttsv_noisinh_huyen" style="width: 100%;">


                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_noisinh_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info" id="ttsv_noisinh_xa"  name = "ttsv_noisinh_xa" style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_noisinh_cccd" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><span style="font-weight:normal">Giấy khai sinh</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info" id="ttsv_noisinh_cccd"  name = "ttsv_noisinh_cccd"  style="height:28px" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_khttprovince_user" class="col-sm-5 col-form-label" style="padding-bottom: 0px">Thường trú:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:normal">Tỉnh/TP:</span></label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control ttsv_info search_hktt_change" name = "ttsv_id_khttprovince_user"  id="ttsv_id_khttprovince_user" style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_khttprovince2_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Quận/Huyện:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info search_hktt_change" id="ttsv_id_khttprovince2_user" name = "ttsv_id_khttprovince2_user" style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_id_khttprovince3_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info search_hktt_change" id="ttsv_id_khttprovince3_user"  name = "ttsv_id_khttprovince3_user" style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_dow_province3" class="col-sm-4 col-form-label"  style="padding-bottom: 0px "><span style="font-weight:normal">Dưới Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_hktt_change"  name = "ttsv_dow_province3" id="ttsv_dow_province3" style="height:28px" value="">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_quequan_tinh" class="col-sm-5 col-form-label" style="padding-bottom: 0px">Quê quán:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:normal">Tỉnh/TP:</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control ttsv_info search_quequan_change" id="ttsv_quequan_tinh" name = "ttsv_quequan_tinh"  style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_quequan_huyen" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Quận/Huyện:</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info search_quequan_change" id="ttsv_quequan_huyen"  name = "ttsv_quequan_huyen" style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_quequan_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px"><span style="font-weight:normal">Xã/Phường:</span><sup style = 'color:red'>*</sup>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control ttsv_info search_quequan_change" id="ttsv_quequan_xa" name = "ttsv_quequan_xa" style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group row" style="margin-bottom: 3px">
                                                    <label for="ttsv_down_quequan_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px "><span style="font-weight:normal">Dưới Xã/Phường:</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control ttsv_info search_quequan_change"   name = "ttsv_down_quequan_xa"  id="ttsv_down_quequan_xa" style="height:28px" value="">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                                    <span class="" style="margin-left:10px"></span>
                                                </div>
                                                <div class="card-body p-1">
                                                    <div class="row">
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_tencha_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ tên Cha:</label>
                                                                <div class="col-sm-8">
                                                                <input type="text" class="form-control ttsv_info search_cha" id="ttsv_tencha_sv" style="height:28px" name = "ttsv_tencha_sv" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_dienthoaicha_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ">Điện thoại:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control ttsv_info search_cha" id="ttsv_dienthoaicha_sv" name = "ttsv_dienthoaicha_sv" style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_nghenghiepcha_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ">Nghề nghiệp:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control ttsv_info search_cha" id="ttsv_nghenghiepcha_sv"  name = "ttsv_nghenghiepcha_sv"  style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_tenme_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ tên Mẹ:</label>
                                                                <div class="col-sm-8">
                                                                <input type="text" class="form-control ttsv_info search_me" id="ttsv_tenme_sv"   name = "ttsv_tenme_sv" style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_dienthoaime_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control ttsv_info search_me" id="ttsv_dienthoaime_sv"  name = "ttsv_dienthoaime_sv" style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_nghenghiepme_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Nghề nghiệp:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control ttsv_info search_me" id="ttsv_nghenghiepme_sv"  name = "ttsv_nghenghiepme_sv" style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_dodau_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Người Đỡ đầu:</label>
                                                                <div class="col-sm-8">
                                                                <input type="text" class="form-control ttsv_info search_dodau" id="ttsv_dodau_sv"  name = "ttsv_dodau_sv" style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_dienthoaidodau_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control ttsv_info search_dodau" id="ttsv_dienthoaidodau_sv"  name = "ttsv_dienthoaidodau_sv"  style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_nghenghiepdodau_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Nghề nghiệp:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control ttsv_info search_dodau" id="ttsv_nghenghiepdodau_sv"  name = "ttsv_nghenghiepdodau_sv" style="height:28px" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                                    <span class="" style="margin-left:10px"></span>
                                                </div>
                                                <div class="card-body p-1">
                                                    <div class="row">

                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_id_khuyettat" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Khuyết tật:</label>
                                                                <div class="col-sm-8">
                                                                    <select class="form-control ttsv_info" id="ttsv_id_khuyettat"  name = "ttsv_id_khuyettat"  style="width: 100%;">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_sothebhyt" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Số thẻ BHYT<sup style = 'color:red'>*</sup>:</label>
                                                                <div class="col-sm-8">
                                                                <input type="text" class="form-control ttsv_info" id="ttsv_sothebhyt"  name = "ttsv_sothebhyt" style="height:28px"  value="">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                <label for="ttsv_address_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Địa chỉ liên lạc<sup style = 'color:red'>*</sup>:</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control ttsv_info" id="ttsv_address_user" name = "ttsv_address_user" style="height:28px" value="">

                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                       
                                        </div>                                                                       
                                    </div>                                       
                                                    
                                </div>   
                                <input type ="text" id = "id_batch_temp" name = "id_batch_temp" >
                                <input type ="text" id = "cmnd_temp" name = "cmnd_temp" >                            
                            </form>  
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                        <span class="" style="margin-left:10px"></span>
                                    </div>
                                    <div class="card-body p-1">
                                        <div class="row">
                                            <div class="col-md-10 col-12">
                                              
                                            </div>                                                
                                            <div class="col-md-2 col-12">
                                                <button id=""  id-data = "" onclick="ttsv_save()" class="btn btn-block btn-primary btn-xs "><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Lưu thông tin</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>                                      
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>  
</div>
<div class = "modal" id="loadding_ttsv">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="30px" height="auto" >          
            {{-- <img src = "https://congmotcua.ctuet.edu.vn/img/Loading.gif" width="30px" height="auto" > --}}
            <span style="color:white"><strong>Đang  xử lý ..., Có thể mất vài phút!!!</strong></span> 
        </div>
    </div>
</div>


<div class = "modal" id="update_ttsv_img">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">       
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper" id = "update_ttsv_slide">
                
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <!-- If we need scrollbar -->
            {{-- <div class="swiper-scrollbar"></div> --}}
        </div>                            
    </div>
</div>

</body>

<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/admin/dist/js/adminlte.min.js"></script>
<script src="/template/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/template/admin/plugins/sparklines/sparkline.js"></script>
<script src="/template/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="/template/admin/plugins/moment/moment.min.js"></script>
{{-- <script src="/template/admin/plugins/daterangepicker/daterangepicker.js"></script> --}}
<script src="/template/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/template/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/template/admin/dist/js/pages/dashboard.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/admin/js/update_ttsv/control.js"></script>
{{-- <script src="/user/js/search/insv.js"></script> --}}
<script src="/template/admin/plugins/toastr/toastr.min.js"></script>
<script src="/swiper/swiper.js"></script>
<script>

    const swiper = new Swiper('.swiper', {
    zoom: true,
    zoom: {
        maxRatio: 3,
        minRatio: 1
      },
    rotate: 'true',
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },    

    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },  

    slidesPerView: 1,
    spaceBetween: 10,
    // freeMode: true
    });


</script>
</html>
