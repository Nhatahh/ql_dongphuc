<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CTUT | Thông tin cá nhân</title>
  @include('user_24.head')

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">


@include('user_24.navbar')
  <div class="content-wrapper" style="margin-left:0px;background-color:#f4f6f9 ">
    <div class="content-header" style="padding: 10px 0.5rem">
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xl-8 col-md-12">
                {{-- <fieldset class="card card-body">
                    <legend>Quản lý hình ảnh</legend>
                    <div role="button" onclick="upload_img({{Auth::guard('loginbygoogles')->id()}})">Upload/Xem hình ảnh:&nbsp;&nbsp;<i style="color: #007aff" class="fa-solid fa-camera-rotate"></i></div>
                </fieldset> --}}
                <fieldset  class="card card-body">
                    <legend>Thông tin cơ bản</legend>
                    <div class="row">
                        <div class="col-md-2" style="padding-top:3%">
                            <div class="row">
                                <div class="col-md-12" style="text-align:center">
                                    <img class="profile-user-img img-fluid img-circle" src = "{{Auth::guard('loginbygoogles')->user()->img_gg}}" alt="Ảnh cá nhân"  id="anhdaidien">
                                </div>
                                <div class="col-md-12" style="text-align:center">
                                    <span class="id_hsts">ID:</span><span class="id_hsts" id = "mahsxt">{{$mahsxt}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="hoten" class="col-sm-4 col-form-label" style="padding-bottom: 0px; font-weight: normal;">Họ và tên:</label>
                                        <div class="col-sm-8">
                                                <input type="text" class="form-control thongtincanhan" id="hoten" value = "{{$hoten}}" style="height:30px">
                                            <sup>
                                                <p class="float-right validate" id = "v_hoten"></p>
                                            </sup>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="birth_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ngày sinh:</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control thongtincanhan" placeholder="01/01/2004" id="ngaysinh" value = "{{$ngaysinh}}" style="height:30px">
                                            <sup>
                                                <p class="float-right validate" id = "v_ngaysinh"></p>
                                            </sup>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="noisinh" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nơi sinh Tỉnh:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control thongtincanhan" type_custom = "select_custom" id="noisinh" style="width: 100%;height:28px">
                                                <option value="0" >Chọn Tỉnh/Thành phố</option>
                                                @foreach ( $noisinhs as $noisinh )
                                                    <option value="{{$noisinh->id}}" {{$noisinh->selected}}>{{$noisinh->text}}</option>
                                                @endforeach
                                            </select>
                                            <sup>
                                                <p class="float-right validate" id = "v_noisinh"></p>
                                            </sup>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_card_users" class="col-sm-4 col-form-label"  style="padding-bottom: 0px">CMND/CCCD:</label>
                                        <div class="col-sm-8">
                                            <input type="text" disabled class="form-control thongtincanhan" id='cccd' id="cccd" value = "{{$cccd}}" style="height:30px">
                                            <sup>
                                                <p class="float-right validate" id = "v_cccd"></p>
                                            </sup>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="email_users" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"  >Email:</label>
                                        <div class="col-sm-8">
                                        <input type="email" class="form-control" id='email' style="height:30px" value="{{$user->email}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="email_phu" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"  >Email 2:</label>
                                        <div class="col-sm-8">
                                        <input type="email" class="form-control thongtincanhan" id='email_phu' style="height:30px" value="{{$email_phu}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="phone_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Số điện thoại:</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control thongtincanhan" id='dienthoai' value = "{{$dienthoai}}" style="height:30px">
                                            <sup>
                                                <p class="float-right validate" id = "v_dienthoai"></p>
                                            </sup>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="phonesc_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Số ĐT phụ huynh:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control thongtincanhan" id='dienthoai_phu' value = "{{$dienthoai_phu}}" style="height:30px">
                                            <sup>
                                                <p class="float-right validate" id = "v_dienthoai_phu"></p>
                                            </sup>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12" style="margin-bottom: -18px">
                                    <div class="form-group row" style="margin-bottom: 3px;">
                                        <label for="sex_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Giới tính:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group  input-group-sm mb-3">
                                                <div class="input-group-prepend"></div>
                                                <div class="input-group-prepend">
                                                        @if ($gioitinh == 0)
                                                            <input class="" type="radio" id = 'gioitinhnam' name="radio1"  style="margin-top: 2px">
                                                        @else
                                                            <input class="" type="radio" id = 'gioitinhnam' name="radio1" checked style="margin-top: 2px">
                                                        @endif
                                                    <div class="" style="padding-top: 7px;">
                                                        <span class="" >&nbsp;&nbsp;&nbsp; Nam</span>
                                                    </div>
                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="input-group-prepend">
                                                    @if ($gioitinh == 0)
                                                        <input class="" type="radio" id = 'gioitinhnu' name="radio1" checked  style="margin-top: 2px">
                                                    @else
                                                        <input class="" type="radio" id = 'gioitinhnu' name="radio1"   style="margin-top: 2px">
                                                    @endif
                                                    <div class="" style="padding-top: 7px;">
                                                        <span class="" >&nbsp;&nbsp;&nbsp; Nữ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="address_user" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Địa chỉ:</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control thongtincanhan"  style="height:30px" id="diachi" value="{{$diachi}}">
                                        <sup>
                                            <p class="float-right validate" id = "v_diachi"></p>
                                        </sup>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-12">
                        </div>
                        <div class="col-md-2 col-12">
                            <button type="button" id = "luuthongtincanhan" onclick="luuthongtincanhan({{Auth::guard('loginbygoogles')->id()}})" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Lưu</button>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card card-body">
                    <legend>Trường Trung học phổ thông</legend>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label class="col-sm-12 col-form-label" style="padding-bottom: 0px"><strong>Lớp 10:</strong></label>
                                <div class="col-sm-0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="tinhthpt10" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Tỉnh:</label>
                                <div class="col-sm-9">
                                    <select class="form-control tinh" id_user = "{{Auth::guard('loginbygoogles')->id()}}" id_lop = "10" checktinh = "1" type_custom = "select_custom" id="tinhthpt10" style="width: 100%;height:28px">
                                        <option value="0" >Chọn Tỉnh/Thành phố</option>
                                        @foreach ( $tinhlop10s as $tinhlop10 )
                                            <option value="{{$tinhlop10->id}}" {{$tinhlop10->selected}}>{{$tinhlop10->text}}</option>
                                        @endforeach
                                    </select>
                                    <sup>
                                        <p class="float-right validate" id = "v_tinhthpt10"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="truongthpt10" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Trường THPT: <sup id="khuvuc10">{{$truonglop10_load['khuvuc10']}}</sup></label>
                                <div class="col-sm-9">
                                    <select @if($checkkhoadangky == 1)  disabled @endif class="form-control truongthpt" id_user = "{{Auth::guard('loginbygoogles')->id()}}" id_lop = "10" checktinh = "0"  type_custom = "select_custom" id="truongthpt10" style="width: 100%;height:28px">
                                        <option value="0" >Chọn Trường THPT</option>
                                        @if($truonglop10_load['truongthpt10s'] != "")
                                            @foreach ( $truonglop10_load['truongthpt10s'] as $truongthpt10 )
                                                <option value="{{$truongthpt10->id}}" {{$truongthpt10->selected}}>{{$truongthpt10->text}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <sup>
                                        <p class="float-right validate" id = "v_truongthpt10"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label class="col-sm-12 col-form-label" style="padding-bottom: 0px"><strong>Lớp 11:</strong></label>
                                <div class="col-sm-0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="tinhthpt11" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Tỉnh:</label>
                                <div class="col-sm-9">
                                    <select class="form-control tinh" id_user = "{{Auth::guard('loginbygoogles')->id()}}" id_lop = "11" checktinh = "1" type_custom = "select_custom" id="tinhthpt11" style="width: 100%;height:28px">
                                        <option value="0" >Chọn Tỉnh/Thành phố</option>
                                        @foreach ( $tinhlop11s as $tinhlop11 )
                                            <option value="{{$tinhlop11->id}}" {{$tinhlop11->selected}}>{{$tinhlop11->text}}</option>
                                        @endforeach
                                    </select>
                                    <sup>
                                        <p class="float-right validate" id = "v_tinhthpt11"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="truongthpt11" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Trường THPT:<sup id="khuvuc11">{{$truonglop11_load['khuvuc11']}}</sup></label>
                                <div class="col-sm-9">
                                    <select @if($checkkhoadangky == 1)  disabled @endif class="form-control truongthpt" id_user = "{{Auth::guard('loginbygoogles')->id()}}" id_lop = "11" checktinh = "0"  type_custom = "select_custom" id="truongthpt11" style="width: 100%;height:28px">
                                        <option value="0" >Chọn Trường THPT</option>
                                        @if($truonglop11_load['truongthpt11s']  != "")
                                            @foreach ( $truonglop11_load['truongthpt11s']  as $truongthpt11 )
                                                <option value="{{$truongthpt11->id}}" {{$truongthpt11->selected}}>{{$truongthpt11->text}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <sup>
                                        <p class="float-right validate" id = "v_truongthpt11"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label class="col-sm-12 col-form-label" style="padding-bottom: 0px"><strong>Lớp 12:</strong></label>
                                <div class="col-sm-0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="tinhthpt11" class="col-sm-3 col-form-label" style="padding-bottom: 0px;">Tỉnh:</label>
                                <div class="col-sm-9">
                                    <select class="form-control tinh" id_user = "{{Auth::guard('loginbygoogles')->id()}}" id_lop = "12" checktinh = "1" type_custom = "select_custom" id="tinhthpt12" style="width: 100%;height:28px">
                                        <option value="0" >Chọn Tỉnh/Thành phố</option>
                                        @foreach ( $tinhlop12s as $tinhlop12)
                                            <option value="{{$tinhlop12->id}}" {{$tinhlop12->selected}}>{{$tinhlop12->text}}</option>
                                        @endforeach
                                    </select>
                                    <sup>
                                        <p class="float-right validate" id = "v_tinhthpt12"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="truongthpt11" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Trường THPT:<sup id="khuvuc12">{{$truonglop12_load['khuvuc12']}}</sup></label>
                                <div class="col-sm-9">
                                    <select @if($checkkhoadangky == 1)  disabled @endif class="form-control truongthpt" id_user = "{{Auth::guard('loginbygoogles')->id()}}" id_lop = "12" checktinh = "0"  type_custom = "select_custom" id="truongthpt12" style="width: 100%;height:28px">
                                        <option value="0" >Chọn Trường THPT</option>
                                        @if($truonglop12_load['truongthpt12s']  != "")
                                            @foreach ( $truonglop12_load['truongthpt12s']   as $truongthpt12 )
                                                <option value="{{$truongthpt12->id}}" {{$truongthpt12->selected}}>{{$truongthpt12->text}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <sup>
                                        <p class="float-right validate" id = "v_truongthpt12"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_card_users" class="col-sm-5 col-form-label"  style="padding-bottom: 0px"><strong>Năm tốt nghiệp:</strong></label>
                                <div class="col-sm-7">
                                    <input @if($checkkhoadangky == 1)  disabled @endif type="text"  id_user = "{{Auth::guard('loginbygoogles')->id()}}" class="form-control" id="namtotnghiep" value = "{{$namtotnghiep}}" style="height:28px">
                                    <sup>
                                        <p class="float-right validate" id = "v_namtotnghiep"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="id_card_users" class="col-sm-12 col-form-label"  style="padding-bottom: 0px"><strong>Ưu tiên theo Trường THPT:</strong>&nbsp;<strong id ="uutientheothpt" style="color: #007aff">{{$khuvucuutien}}</strong></label>
                                <div class="col-sm-0">

                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="card card-body">
                    <legend>Đối tượng ưu tiên</legend>
                    <span>- Thí sinh vui lòng tham khảo đối tượng ưu tiên chính sách <a href="https://drive.google.com/file/d/14buDAn3yM0pIZjlD38FmoLcEKjLuyDLt/view" target="_blank">tại đây</a></span>
                    <span>- Thí sinh thuộc diện ưu tiên phải upload minh chứng đối tượng ưu tiên tại mục "Quản lý hình ảnh &nbsp;<i onclick="upload_img({{Auth::guard('loginbygoogles')->id()}})" style="color: #007aff" class="fa-solid fa-camera-rotate"></i>"</span>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group row" style="margin-bottom: 3px">
                                <label for="doituonguutien" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đối tượng ưu tiên:</label>
                                <div class="col-sm-8">
                                    <select @if($checkkhoadangky == 1)  disabled @endif class="form-control" id_user = "{{Auth::guard('loginbygoogles')->id()}}" type_custom = "" id="doituonguutien" style="width: 100%;height:28px">
                                        <option value="0" >Chọn Đối tượng ưu tiên</option>
                                        @foreach ( $doituonguutien as $uutien )
                                            <option value="{{$uutien->id}}" {{$uutien->selected}}>{{$uutien->text}}</option>
                                        @endforeach
                                    </select>
                                    <sup>
                                        <p class="float-right validate" id = "v_doituonguutien"></p>
                                    </sup>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-12 col-md-12 col-xl-4 content_right">
                @include('user_24.content_right')
            </div>
        </div>
      </div>
    </section>
  </div>
  @include('user_24.navbarfooter')
  @include('user_24.modalevent')
  @include('user_24.info_popup')
</div>














<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
@include('user_24.footer')


<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/swiper/swiper.js"></script>
<script src="/user_24/js/thongtincanhan.js"></script>
</body>
</html>
