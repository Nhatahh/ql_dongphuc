</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTUT| Tra cứu kết quả</title>
    <link rel="stylesheet" href="/user/css/loading.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/template/admin/plugins/daterangepicker/daterangepicker.css">
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
                    <div>HỆ THỐNG TRA CỨU KẾT QUẢ XÉT TUYỂN ĐAI HỌC CHÍNH QUY</div></strong>
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


    <div class="content-wrapper" style="margin-left:0px" >
        <div class="content-header" style="height: 2px">
        </div>

        <section class="content">
            <div class="card">
                <div class="card-header" style="padding:0px">
                    <span class="" style="margin-left:10px"><strong>Kết quả xét tuyển</strong></span>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-1">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>TT NV</th>
                                <th>Ngành xét tuyển</th>
                                <th>Phương thức</th>
                                <th>Khu vực</th>
                                <th>Đối tượng</th>
                                <th>Tổ hợp</th>
                                <th>Điểm tổ hợp</th>
                                <th>Điểm ưu tiên</th>
                                <th>Điểm xét tuyển</th>
                                <th>Kết quả</th>
                                <th>TT sớm</th>
                                <th>Nhập học</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ( $wish as $value )
                                <tr>
                                    <td>{{$value->number_bo}}</td>
                                    <td style="vertical-align: middle;">{{$value->name_major}}</td>
                                    <td style="vertical-align: middle;">{{$value->id_method}}</td>
                                    <td style="vertical-align: middle;">{{$value->id_priority_area}}</td>
                                    <td style="vertical-align: middle;">{{$value->name_policy_user}}</td>
                                    <td style="vertical-align: middle;">{{$value->name_group}}</td>
                                    <td style="vertical-align: middle;">{{$value->group_mark}}</td>
                                    <td style="vertical-align: middle;">{{$value->priority_mark}}</td>
                                    <td style="vertical-align: middle;">{{$value->mark}}</td>
                                    @if ($value->tt === 'Đỗ')
                                        <td style="vertical-align: middle;"><span class="badge bg-primary">Trúng tuyển</span></td>
                                    @else
                                        <td style="vertical-align: middle;"><span class="badge bg-warning">Không đạt</span></td>
                                    @endif
                                    @if ($value->tts === 'x')
                                        <td style="vertical-align: middle;">X</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if ($value->pass_bo === 1)
                                    <td style="vertical-align: middle;">
                                        <input type="button"  style="height:20px; padding:0px;margin:0;font-weight:bold" id-data = "{{$title}}" id = "search_check"   onclick = "search_check({{$value->id_search}})" class="btn btn-block btn-primary btn-xs" value="{{$value->check_end}}">
                                    </td>
                                    @else
                                        <td></td>
                                    @endif

                                </tr>
                            @endforeach
                            {{-- @for ($i = 0; $i<count($wish); $i++)
                                <tr>
                                    <td>{{$wish[$i]->number_bo}}</td> --}}
                                    {{-- <td>{{$wish[$i]->id}}</td> --}}
                                    {{-- <td style="vertical-align: middle;">{{$wish[$i]->name_major}}</td>
                                    <td style="vertical-align: middle;">{{$wish[$i]->id_method}}</td>
                                    <td style="vertical-align: middle;">{{$wish[$i]->id_priority_area}}</td>
                                    <td style="vertical-align: middle;">{{$wish[$i]->name_policy_user}}</td>
                                    <td style="vertical-align: middle;">{{$wish[$i]->name_group}}</td>
                                    <td style="vertical-align: middle;">{{$wish[$i]->group_mark}}</td>
                                    <td style="vertical-align: middle;">{{$wish[$i]->priority_mark}}</td>
                                    <td style="vertical-align: middle;">{{$wish[$i]->mark}}</td>
                                    @if ($wish[$i]->tt === 'Đỗ')
                                        <td style="vertical-align: middle;"><span class="badge bg-primary">Trúng tuyển</span></td>
                                    @else
                                        <td style="vertical-align: middle;"><span class="badge bg-warning">Không đạt</span></td>
                                    @endif
                                    @if ($wish[$i]->tts === 'x')
                                        <td style="vertical-align: middle;">X</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if ($wish[$i]->pass_bo === 1)
                                        <td style="vertical-align: middle;">
                                            <input type="button"  style="height:20px; padding:0px;margin:0;font-weight:bold" id-data = "{{$title}}" id = "search_check"   onclick = "search_check({{$wish[$i]->id_search}})" class="btn btn-block btn-primary btn-xs" value="{{$wish[$i]->check_end}}">
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                            @endfor --}}


                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
                </div>

              </div>
              @if ($pass == 1)
              <form id ="search_submit">
                <div class="card">
                    <div class="card-header" style="padding:0px">
                        <span class="" style="margin-left:10px"><strong>Thông tin nhập học</strong></span>
                    </div>
                    <div class="card-body p-1">
                        <div class="row">
                            <div class="col-12 col-md-8 col-md-8">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_name_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ và tên:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="search_name_user" name = "name_user" style="height:28px" disabled value="{{$info[0]->name_user}}">
                                            </div>
                                            <sub class="validate">
                                                <p class = "search_validate error" id = "v_name_user" ></p>
                                            </sub>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_birth_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày sinh<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="search_birth_user" name = "birth_user" style="height:28px" value="{{$info[0]->birth_user}}">
                                                <sub class="validate">
                                                    <p class = "search_validate error" id = "v_birth_user" ></p>
                                                </sub>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Giới tính<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="search_sex_user" name = 'sex_user' style="width: 100%;" {{$info[0]->sex_user}}>
                                                    @if ($info[0]->sex_user == 0)
                                                        <option value="0" selected = "selected">Nam</option>
                                                        <option value="1">Nữ</option>
                                                    @else
                                                        <option value="0" >Nam</option>
                                                        <option value="1" selected = "selected">Nữ</option>
                                                    @endif
                                                </select>
                                                <sub class="validate">
                                                    <p class = "search_validate error" id = "v_id_sex_user" ></p>
                                                </sub>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_dantoc" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Dân tộc<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="search_dantoc" name = 'id_nation_user'  style="width: 100%;">
                                                    @for ($i = 0; $i<count($nation); $i++)
                                                        <option value = "{{$nation[$i]->id}}" {{$nation[$i]->selected}}>{{$nation[$i]->name_nation}}</option>
                                                    @endfor
                                                </select>
                                                <sub class="validate">
                                                    <p class = "search_validate error" id = "v_id_nation_user" ></p>
                                                </sub>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tôn giáo<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="search_tongiao"  name = 'id_religion' style="width: 100%;">
                                                    @for ($i = 0; $i<count($religion); $i++)
                                                        <option value = "{{$religion[$i]->id}}" {{$religion[$i]->selected}}>{{$religion[$i]->tentongiao}}</option>
                                                    @endfor
                                                </select>
                                                <sub class="validate">
                                                    <p class = "search_validate error" id = "v_id_religion" ></p>
                                                </sub>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_quoctich" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Quốc tịch<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="search_quoctich" name = 'id_nationality' style="width: 100%;">
                                                    @for ($i = 0; $i<count($nationality); $i++)
                                                        <option value = "{{$nationality[$i]->id}}" {{$nationality[$i]->selected}}>{{$nationality[$i]->name_nationality}}</option>
                                                    @endfor
                                                </select>
                                                <sub class="validate">
                                                    <p class = "search_validate error" id = "v_id_nationality" ></p>
                                                </sub>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_id_card_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">CMND/CCCD<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="search_id_card_user" name = "id_card_user_new" disabled style="height:28px"  value="{{$info[0]->id_card_users}}">
                                            </div>
                                            <sub class="validate">
                                                <p class = "search_validate error" id = "v_id_card_user_new" ></p>
                                            </sub>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_date_card" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày cấp<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="search_date_card" name = "date_card" style="height:28px"  value="{{$info[0]->date_card}}">
                                            </div>
                                            <sub class="validate">
                                                <p class = "search_validate error" id = "v_date_card" ></p>
                                            </sub>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nơi cấp<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="search_noicapcmnd" name = "id_place_card"  style="width: 100%;">
                                                    @for ($i = 0; $i<count($province_place_card); $i++)
                                                        <option value = "{{$province_place_card[$i]->id}}" {{$province_place_card[$i]->selected}}>{{$province_place_card[$i]->name_province}}</option>
                                                    @endfor
                                                </select>
                                                <sub class="validate">
                                                    <p class = "search_validate error" id = "v_id_place_card" ></p>
                                                </sub>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_phone_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại<sup style = 'color:red'>*</sup>:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="search_phone_users" name = "phone_users"  style="height:28px"  value="{{$info[0]->phone_users}}">
                                            </div>
                                            <sub class="validate">
                                                <p class = "search_validate error" id = "v_phone_users" ></p>
                                            </sub>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_doan_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đoàn:</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="search_doan_sv" name = "doan_sv" style="height:28px"  value="{{$info[0]->doan_sv}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="search_dang_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Ngày vào Đảng:</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="search_dang_sv" name = "dang_sv" style="height:28px"  value="{{$info[0]->dang_sv}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                            <span class="" style="margin-left:10px"></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="name_user" class="col-sm-12 col-form-label" style="padding-bottom: 0px ">Nơi sinh (ghi đúng theo CMND/CCCD):</label>
                                                        {{-- <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="name_user" style="height:28px">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_noisinh_tinh" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tỉnh/TP<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="search_noisinh_tinh" name = "id_place_user" style="width: 100%;">
                                                                <option value="0">Chọn Tỉnh/Thành phố</option>
                                                                @for ($i = 0; $i<count($province_noisinh_tinh); $i++)
                                                                    <option value = "{{$province_noisinh_tinh[$i]->id}}" {{$province_noisinh_tinh[$i]->selected}}>{{$province_noisinh_tinh[$i]->name_province}}</option>
                                                                @endfor
                                                            </select>
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_id_place_user" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_noisinh_huyen" class="col-sm-4 col-form-label"  style="padding-bottom: 0px">Huyện/Quận:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="search_noisinh_huyen" name = "noisinh_huyen" style="width: 100%;">
                                                                <option value="0">Chọn Huyện/Quận</option>
                                                                @for ($i = 0; $i<count($province_noisinh_huyen); $i++)
                                                                    <option value = "{{$province_noisinh_huyen[$i]->id}}" {{$province_noisinh_huyen[$i]->selected}}>{{$province_noisinh_huyen[$i]->name_province2}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_noisinh_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Xã/Phường:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="search_noisinh_xa"  name = "noisinh_xa" style="width: 100%;">
                                                                <option value="0">Chọn Xã/Phường</option>
                                                                @for ($i = 0; $i<count($province_noisinh_xa); $i++)
                                                                    <option value = "{{$province_noisinh_xa[$i]->id}}" {{$province_noisinh_xa[$i]->selected}}>{{$province_noisinh_xa[$i]->name_province3}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">

                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_noisinh_cccd" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Nơi sinh theo Giấy khai sinh<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="search_noisinh_cccd"  name = "noisinh_cccd"  style="height:28px" value="{{$info[0]->noisinh_cccd}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                            <span class="" style="margin-left:10px"></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px ">Địa chỉ thường trú (ghi đúng theo CMND/CCCD):</label>
                                                        {{-- <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="name_user" style="height:28px">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_hktttinh" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tỉnh/TP:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control search_hktt_change" name = "id_khttprovince_user"  id="search_hktttinh" style="width: 100%;">
                                                                @for ($i = 0; $i<count($province_httttinh); $i++)
                                                                    <option value = "{{$province_httttinh[$i]->id}}" {{$province_httttinh[$i]->selected}}>{{$province_httttinh[$i]->name_province}}</option>
                                                                @endfor
                                                            </select>
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_id_khttprovince_user" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Huyện/Quận:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control search_hktt_change" id="search_hktthuyen" name = "id_khttprovince2_user" style="width: 100%;">
                                                                @for ($i = 0; $i<count($province_httthuyen); $i++)
                                                                    <option value = "{{$province_httthuyen[$i]->id}}" {{$province_httthuyen[$i]->selected}}>{{$province_httthuyen[$i]->name_province2}}</option>
                                                                @endfor
                                                            </select>
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_id_khttprovince2_user" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_hkttxa" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Xã/Phường:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control search_hktt_change" id="search_hkttxa"  name = "id_khttprovince3_user" style="width: 100%;">
                                                                @for ($i = 0; $i<count($province_htttxa); $i++)
                                                                    <option value = "{{$province_htttxa[$i]->id}}" {{$province_htttxa[$i]->selected}}>{{$province_htttxa[$i]->name_province3}}</option>
                                                                @endfor
                                                            </select>
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_id_khttprovince3_user" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_down_province3" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ">Dưới Xã/Phường</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_hktt_change"  name = "down_province3" id="search_down_province3" style="height:28px" value="{{$info[0]->down_province3}}">

                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_down_province3" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Nơi thường trú theo CMND/CCCD:&nbsp;&nbsp;<span id="hktt_cccd" style="font-weight: normal;color:#007bff">{{$info[0]->down_province3.", ".$info[0]->name_province3.", ".$info[0]->name_province2.", ".$info[0]->name_province}}</span></label>
                                                        <div class="col-sm-0">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                            <span class="" style="margin-left:10px"></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px ">Quê quán (ghi đúng theo CMND/CCCD):</label>
                                                        {{-- <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="name_user" style="height:28px">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_quequan_tinh" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Tỉnh/TP<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control search_quequan_change" id="search_quequan_tinh" name = "quequan_tinh"  style="width: 100%;">
                                                                @for ($i = 0; $i<count($province_quequan_tinh); $i++)
                                                                    <option value = "{{$province_quequan_tinh[$i]->id}}" {{$province_quequan_tinh[$i]->selected}}>{{$province_quequan_tinh[$i]->name_province}}</option>
                                                                @endfor
                                                            </select>
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_quequan_tinh" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_quequan_huyen" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Huyện/Quận<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control search_quequan_change" id="search_quequan_huyen"  name = "quequan_huyen" style="width: 100%;">
                                                                <option value="0">Chọn Quận/Huyện</option>
                                                                @for ($i = 0; $i<count($province_quequan_huyen); $i++)
                                                                    <option value = "{{$province_quequan_huyen[$i]->id}}" {{$province_quequan_huyen[$i]->selected}}>{{$province_quequan_huyen[$i]->name_province2}}</option>
                                                                @endfor
                                                            </select>
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_quequan_huyen" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_quequan_xa" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Xã/Phường<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control search_quequan_change" id="search_quequan_xa" name = "quequan_xa" style="width: 100%;">
                                                                <option value="0">Chọn Xã/Phường</option>
                                                                @for ($i = 0; $i<count($province_quequan_xa); $i++)
                                                                    <option value = "{{$province_quequan_xa[$i]->id}}" {{$province_quequan_xa[$i]->selected}}>{{$province_quequan_xa[$i]->name_province3}}</option>
                                                                @endfor
                                                            </select>
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_quequan_xa" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_down_province3" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Dưới Xã/Phường</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_quequan_change"   name = "dow_quequan_xa"  id="search_down_quequan_xa" style="height:28px" value="{{$info[0]->dow_quequan_xa}}">
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_dow_quequan_xa" ></p>
                                                            </sub>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px">Quê quán theo CMND/CCCD:&nbsp;&nbsp;<span id = "quequan_cccd" style="font-weight: normal;color:#007bff">{{$info[0]->dow_quequan_xa.", ".$info[0]->name_province_quequan_xa.", ".$info[0]->name_province_quequan_huyen.", ".$info[0]->name_province_quequan_tinh}}</span></label>
                                                        <div class="col-sm-0">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                            <span class="" style="margin-left:10px"></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_tencha_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ tên Cha:</label>
                                                        <div class="col-sm-8">
                                                        <input type="text" class="form-control search_cha" id="search_tencha_sv" style="height:28px" name = "tencha_sv" value="{{$info[0]->tencha_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_dienthoaicha_sv" class="col-sm-4 col-form-label"   style="padding-bottom: 0px ">Điện thoại:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_cha" id="search_dienthoaicha_sv" name = "dienthoaicha_sv" style="height:28px" value="{{$info[0]->dienthoaicha_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_nghenghiepcha_sv" class="col-sm-4 col-form-label"  style="padding-bottom: 0px ">Nghề nghiệp:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_cha" id="search_nghenghiepcha_sv"  name = "nghenghiepcha_sv"  style="height:28px" value="{{$info[0]->nghenghiepcha_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_tenme_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ tên Mẹ:</label>
                                                        <div class="col-sm-8">
                                                        <input type="text" class="form-control search_me" id="search_tenme_sv"   name = "tenme_sv" style="height:28px" value="{{$info[0]->tenme_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_dienthoaime_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_me" id="search_dienthoaime_sv"  name = "dienthoaime_sv" style="height:28px" value="{{$info[0]->dienthoaime_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_nghenghiepme_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Nghề nghiệp:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_me" id="search_nghenghiepme_sv"  name = "nghenghiepme_sv" style="height:28px" value="{{$info[0]->nghenghiepme_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_tenme_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Người Đỡ đầu:</label>
                                                        <div class="col-sm-8">
                                                        <input type="text" class="form-control search_dodau" id="search_tenme_sv"  name = "dodau_sv" style="height:28px" value="{{$info[0]->dodau_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_dienthoaidodau_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_dodau" id="search_dienthoaidodau_sv"  name = "dienthoaidodau_sv"  style="height:28px" value="{{$info[0]->dienthoaidodau_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_nghenghiepdodau_sv" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Nghề nghiệp:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control search_dodau" id="search_nghenghiepdodau_sv"  name = "nghenghiepdodau_sv" style="height:28px" value="{{$info[0]->nghenghiepdodau_sv}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                            <span class="" style="margin-left:10px"></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                {{-- <div class="col-md-4 col-12"> --}}
                                                    {{-- <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_chinhsach" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chính sách:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="search_chinhsach"  name = "id_chinhsach" style="width: 100%;">
                                                                <option value = '0'>Chọn Đối tượng chính sách</option>
                                                                @for ($i = 0; $i<count($chinhsach); $i++)
                                                                    <option value = "{{$chinhsach[$i]->id}}" {{$chinhsach[$i]->selected}}>{{$chinhsach[$i]->name_chinhsach}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                {{-- </div> --}}
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_khuyettat" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Khuyết tật:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="search_khuyettat"  name = "id_khuyettat"  style="width: 100%;">
                                                                <option value = '0'>Chọn Loại khuyết tật</option>
                                                                @for ($i = 0; $i<count($khuyettat); $i++)
                                                                    <option value = "{{$khuyettat[$i]->id}}" {{$khuyettat[$i]->selected}}>{{$khuyettat[$i]->name_khuyettat}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_bhyt" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Số thẻ BHYT<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="search_bhyt"  name = "sothebhyt" style="height:28px"  value="{{$info[0]->sothebhyt}}">
                                                        <sub class="validate">
                                                            <p class = "search_validate error" id = "v_sothebhyt" ></p>
                                                        </sub>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="name_user" class="col-sm-2 col-form-label" style="padding-bottom: 0px ">Địa chỉ liên lạc<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="search_address_user" name = "address_user" style="height:28px" value="{{$info[0]->address_user}}">

                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_address_user" ></p>
                                                            </sub>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="search_date_dukien" class="col-sm-6 col-form-label" style="padding-bottom: 0px ">Ngày dự kiến đến trường làm thủ tục nhập học<sup style = 'color:red'>*</sup>:</label>
                                                        <div class="col-sm-6">
                                                            <input type="date" class="form-control" id="search_date_dukien" name = "date_dukien" style="height:28px"  value="{{$info[0]->date_dukien}}">
                                                            <sub class="validate">
                                                                <p class = "search_validate error" id = "v_date_dukien" ></p>
                                                            </sub>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                            <span class="" style="margin-left:10px"></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-md-10 col-12">
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <input id="search_save" type="button"   id-data = "{{$check_save_ìnfo}}" onclick="search_save1()" class="btn btn-block btn-primary btn-xs" value="Lưu thông tin">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="margin-top: -7px;padding-top: 0px;">
                                            <span class="" style="margin-left:10px"></span>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group row" style="margin-bottom: 3px">
                                                        <label for="" class="col-sm-12 col-form-label" style="padding-bottom: 0px ">Tải hồ sơ nhập học:</label>
                                                        {{-- <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="name_user" style="height:28px">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_cmnd()" id = "op_search_form_upload_cmnd">CMND/CCCD mặt trước<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_cmnd"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_cmnd2()" id = "op_search_form_upload_cmnd2">CMND/CCCD mặt sau<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_cmnd2"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_kqthi()" id = "op_search_form_upload_kqthi">Giấy CN Kết quả thi: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_kqthi"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_tn()" id = "op_search_form_upload_tn">Giấy CN Tốt nghiệp tạm thời: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_tn"></p>
                                                    </sub>
                                                </div>

                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_9()" id = "op_search_form_upload_9">Trang đầu học bạ<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_9"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_10()" id = "op_search_form_upload_10">Học bạ lớp 10<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_10"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_11()" id = "op_search_form_upload_11">Học bạ lớp 11<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_11"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_12()" id = "op_search_form_upload_12">Học bạ lớp 12<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_12"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_gks()" id = "op_search_form_upload_gks">Giấy khai sinh<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_gks"></p>
                                                    </sub>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <span onclick="op_search_form_upload_btn()" id = "op_search_form_upload_btn">Bằng tốt nghiệp THPT: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_btn"></p>
                                                    </sub>
                                                </div>
                                                {{-- <div class="col-md-3 col-6">
                                                    <span onclick="op_search_form_upload_cmnd()" id = "op_search_form_upload_cmnd">CMND/CCCD mặt sau<sup style = 'color:red'>*</sup>: &nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" aria-hidden="true" style="color:#007bff"></i></span>
                                                    <sub class="validate">
                                                        <p class = "search_validate error" id = "v_search_upload_cmnd"></p>
                                                    </sub>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-md-4">
                                <div class="swiper">
                                    <!-- Additional required wrapper -->
                                    <div class="swiper-wrapper" id = "swiper_search">

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
                            <div class="col-md-12 col-12" style="height:150px">
                        </div>
                    </div>

                </div>
            </form>
              @else
              <div class="card">
                <div class="card-header" style="padding:0px">
                    {{-- <span class="" style="margin-left:10px"><strong>Thông tin nhập học</strong></span> --}}
                </div>
                <div class="card-body p-1">
                    <div class="row">
                        <div class="col-12 col-md-12 col-md-12">
                            <div class="card-header" style="padding:0px">
                                {{-- <span class="" style="margin-left:10px"><strong>Thông tin nhập học</strong></span> --}}
                            </div>
                            <div class="card-body p-1">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-md-12">
                                        <span>Thí sinh không đạt tại đợt xét tuyển này! thí sinh có nhu cầu đăng ký xét tuyển đợt bổ sung thì vui lòng điền số điện thoại. Nhà trường sẽ liên hệ hướng dẫn thí sinh đăng ký đợt bổ sung khi còn chỉ tiêu.
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="dt_bosung" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Điện thoại:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="dt_bosung"  name = "dt_bosung"  style="height:28px" val = "">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-2 col-12">
                                        <input  style="button" id="search_bosung" onclick="search_bosung()" class="btn btn-block btn-primary btn-xs" value="Lưu thông tin">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              @endif

        </section>
    </div>
    <form id = "search_upload_kqthi_submit">
        <input type="file" name="search_upload_kqthi" id="search_upload_kqthi"/>
    </form>
    <form id = "search_upload_cmnd_submit">
        <input type="file" name="search_upload_cmnd" id="search_upload_cmnd"/>
    </form>
    <form id = "search_upload_cmnd2_submit">
        <input type="file" name="search_upload_cmnd2" id="search_upload_cmnd2"/>
    </form>
    <form id = "search_upload_tn_submit">
        <input type="file" name="search_upload_tn" id="search_upload_tn"/>
    </form>

    <form id = "search_upload_9_submit">
        <input type="file" name="search_upload_9" id="search_upload_9"/>
    </form>
    <form id = "search_upload_10_submit">
        <input type="file" name="search_upload_10" id="search_upload_10"/>
    </form>
    <form id = "search_upload_11_submit">
        <input type="file" name="search_upload_11" id="search_upload_11"/>
    </form>
    <form id = "search_upload_12_submit">
        <input type="file" name="search_upload_12" id="search_upload_12"/>
    </form>
    <form id = "search_upload_gks_submit">
        <input type="file" name="search_upload_gks" id="search_upload_gks"/>
    </form>
    <form id = "search_upload_btn_submit">
        <input type="file" name="search_upload_btn" id="search_upload_btn"/>
    </form>
    <footer class="main-footer navbar-primary" style="margin-left:0px">
        <div class="row">
            <div class="col-md-10 col-12 col-lg-10">
                <div class="row">
                    <div class="col-md-8 col-12 col-lg-8" >
                        <div><i class="fa fa-graduation-cap"></i>&nbsp;&nbsp;&nbsp;Trường Đại học Kỹ thuật - Công nghệ Cần Thơ</div>
                    </div>
                    <div class="col-md-4 col-12 col-lg-4" >
                        <div><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Email: tuvantuyensinh.ctuet.edu.vn</div>
                    </div>
                    <div class="col-md-8 col-12 col-lg-8">
                        <div><i class="fa fa-street-view"></i>&nbsp;&nbsp;&nbsp;256, Nguyễn Văn Cừ, Phường An Hòa, Quận Ninh Kiều, Thành phố Cần Thơ</div>
                    </div>
                    <div class="col-md-4 col-12 col-lg-4">
                        <div><i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;Điện thoại: 02923898167</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-12 col-lg-2">
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.1 Beta
                </div>
            </div>
        </div>

    </footer>

</div>
<div class = "modal" id="loadding_search">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            {{-- <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="30px" height="auto" > --}}
            <img src = "https://congmotcua.ctuet.edu.vn/img/Loading.gif" width="30px" height="auto" >
            <span style="color:white"><strong>Đang  xử lý ..., Có thể mất vài phút!!!</strong></span>
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
<script src="/template/admin/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/template/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/template/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/template/admin/dist/js/pages/dashboard.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>
<script src="/user/js/search/control.js"></script>
<script src="/user/js/search/insv.js"></script>
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

    // on: {
    // slideChangeTransitionEnd: function () {
    //     console.log('clicked!')
    //     this.zoom.in();
    //     }
    // },

    // Optional parameters
    slidesPerView: 1,
    // direction: 'vertical',
    // loop: true,

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    // scrollbar: {
    //   el: '.swiper-scrollbar',
    // },

    slidesPerView: 1,
    });


</script>
</html>
