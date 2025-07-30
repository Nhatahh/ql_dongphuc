<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CTUT | Đăng ký xét tuyển</title>
  @include('user_24.head')

    <style>

    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Navbar -->
@include('user_24.navbar')
  <!-- /.navbar -->



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px;background-color:#f4f6f9 ">
    <!-- Content Header (Page header) -->
    <div class="content-header" style="padding: 10px 0.5rem">
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        {{-- {{$ten_nganh}} --}}
        <div class="row">
            <div class="col-12 col-xl-8 col-md-12">
                <div class="container-fluid card card-body" style="padding-left:0px;padding-right:0px">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div style="min-height: 600px;padding-bottom: 0px" class="direct-chat-messages">
                                <div class="row">
                                    @foreach ($ten_nganh as $nganh )
                                        @if (count($nganh->allchuyennganh) > 1)
                                            <div class="col-12 col-xl-12 col-md-12">
                                                <fieldset class="card card-body tennganh" >
                                                    <legend class="tennganhdangky">Ngành {{$nganh->name_major}}</legend>
                                                    <div class="explore-rating-price"> <span class="explore-price-box">PT: 200</span><span class="explore-price-box">TH: {{$nganh->tohopxettuyen}}</span><span class="explore-price-box">Điểm: {{$nganh->diemxettuyen}}</span></div>
                                                    <div class="explore-rating-price "> <span class="explore-price-box">Chỉ tiêu: {{$nganh->chitieu}}</span></div>
                                                    <div class="explore-rating-price thamkhao">
                                                        @foreach ($nganh->all_diemthamkhao as $diemthamkhao )
                                                            <span class="explore-price-box">Điểm {{$diemthamkhao['nam']}}: {{$diemthamkhao['diemthamkhao']}}</span>
                                                        @endforeach
                                                    </div>
                                                    @foreach ($nganh->allchuyennganh as $chuyennganh )
                                                        <fieldset class="card card-body tennganh nganh_chuyennganh">
                                                            <div class="row">
                                                                <div class="col-12 col-md-4">
                                                                    <div class="tennganhdangky">Chuyên ngành {{$chuyennganh['tenchuyennganh']}}</div>
                                                                    {{-- @if ($chuyennganh['moi'] == 1)
                                                                        <div class="explore-rating new">Chuyên ngành mới</div>
                                                                    @endif --}}
                                                                    <div class="explore-open-close-part">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="_9m0o30 shopee-input-quantity">
                                                                                    <button class="button_dangkynganh">Nguyện vọng:</button>
                                                                                    @if($nganh->diemtohop <= 18 )
                                                                                        <button disabled class="suQW3X decrease"> - </button>
                                                                                        <input disabled class="suQW3X u00pLG nguyenvong " diemtohop = "{{$nganh->diemtohop}}" diemuutien = "{{$nganh->uutien}}" nganh = "{{$chuyennganh['id_chuyennganh']}}" diem = "{{$nganh->diemxettuyen}}" tohop = "{{$nganh->idtohop}}" type="text" value="{{$chuyennganh['thutu']}}">
                                                                                        <button disabled class="suQW3X increase">+</button>
                                                                                    @else
                                                                                        <button  class="suQW3X decrease"> - </button>
                                                                                        <input disabled class="suQW3X u00pLG nguyenvong " diemtohop = "{{$nganh->diemtohop}}" diemuutien = "{{$nganh->uutien}}" nganh = "{{$chuyennganh['id_chuyennganh']}}" diem = "{{$nganh->diemxettuyen}}" tohop = "{{$nganh->idtohop}}" type="text" value="{{$chuyennganh['thutu']}}">
                                                                                        <button  class="suQW3X increase">+</button>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-8 ">
                                                                    <p class = "motanganh">{{$chuyennganh['gioithieu']}}</p>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    @endforeach
                                                </fieldset>
                                            </div>
                                        @else
                                            <div class="col-12 col-xl-12 col-md-12">
                                                <fieldset class="card card-body tennganh" >
                                                    <legend class="tennganhdangky">Ngành {{$nganh->name_major}}</legend>
                                                    @foreach ($nganh->allchuyennganh as $chuyennganh )
                                                        <div class="row">
                                                            <div class="col-12 col-md-4">
                                                                <div class="explore-rating-price"><span class="explore-price-box">PT: 200</span> <span class="explore-price-box">TH: {{$nganh->tohopxettuyen}}</span><span class="explore-price-box">Điểm: {{$nganh->diemxettuyen}}</span></div>
                                                                <div class="explore-rating-price "> <span class="explore-price-box">Chỉ tiêu: {{$nganh->chitieu}}</span></div>
                                                                <div class="explore-rating-price thamkhao">
                                                                    @foreach ($nganh->all_diemthamkhao as $diemthamkhao )
                                                                        <span class="explore-price-box">Điểm {{$diemthamkhao['nam']}}: {{$diemthamkhao['diemthamkhao']}}</span>
                                                                    @endforeach
                                                                </div>
                                                                <div class="explore-open-close-part">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="_9m0o30 shopee-input-quantity">
                                                                                <button class="button_dangkynganh">Nguyện vọng:</button>
                                                                                @if($nganh->diemtohop <= 18 )
                                                                                    <button disabled class="suQW3X decrease"> - </button>
                                                                                    <input disabled class="suQW3X u00pLG nguyenvong " diemtohop = "{{$nganh->diemtohop}}" diemuutien = "{{$nganh->uutien}}" nganh = "{{$chuyennganh['id_chuyennganh']}}" diem = "{{$nganh->diemxettuyen}}" tohop = "{{$nganh->idtohop}}" type="text" value="{{$chuyennganh['thutu']}}">
                                                                                    <button disabled class="suQW3X increase">+</button>
                                                                                @else
                                                                                    <button  class="suQW3X decrease"> - </button>
                                                                                    <input disabled class="suQW3X u00pLG nguyenvong " diemtohop = "{{$nganh->diemtohop}}" diemuutien = "{{$nganh->uutien}}" nganh = "{{$chuyennganh['id_chuyennganh']}}" diem = "{{$nganh->diemxettuyen}}" tohop = "{{$nganh->idtohop}}" type="text" value="{{$chuyennganh['thutu']}}">
                                                                                    <button  class="suQW3X increase">+</button>
                                                                                @endif


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-8">
                                                                <p class = "motanganh">{{$chuyennganh['gioithieu']}}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </fieldset>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="row" style="padding-top:10px;margin: 0px 5px">
                                <div class="col-md-6 col-12" style="margin-bottom:3px">
                                    <span style="font-weight:bold;color:#2e3192">Thí sinh chọn <strong style="color:red">"Lưu"</strong>. Khi đã quyết định, cân nhắc xét tuyển thì chọn <strong style="color:red">"Đăng ký"</strong></span>
                                </div>
                                {{-- <div class="col-md-8 col-12">
                                </div> --}}
                                <div class="col-md-2 col-6" style="margin-bottom:3px">
                                    @if($trangthai == 1)
                                        <button type="button" disabled id="luunguyenvong" id_user = "{{Auth::guard('loginbygoogles')->id()}}" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Lưu</button>
                                    @else
                                        <button type="button" id="luunguyenvong" id_user = "{{Auth::guard('loginbygoogles')->id()}}" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Lưu</button>
                                    @endif
                                </div>
                                <div class="col-md-2 col-6" style="margin-bottom:3px">
                                    @if($trangthai == 1)
                                        <button type="button" disabled id="dangkyxettuyen" id_user = "{{Auth::guard('loginbygoogles')->id()}}"  class="btn btn-block btn-primary btn-xs"><i class="fa fa-registered"></i>&nbsp;&nbsp;Đăng ký</button>
                                    @else
                                        <button type="button"  id="dangkyxettuyen" id_user = "{{Auth::guard('loginbygoogles')->id()}}"  class="btn btn-block btn-primary btn-xs"><i class="fa fa-registered"></i>&nbsp;&nbsp;Đăng ký</button>
                                    @endif
                                </div>
                                <div class="col-md-2 col-6" style="margin-bottom:3px">
                                    @if($trangthai == 1)
                                        <button type="button" id="yeucaucapnhat" id_user = "{{Auth::guard('loginbygoogles')->id()}}"  class="btn btn-block btn-primary btn-xs"><i class="fa fa-registered"></i>&nbsp;&nbsp;Yêu cầu cập nhật</button>
                                    @else
                                        <button type="button" disabled  id="yeucaucapnhat" id_user = "{{Auth::guard('loginbygoogles')->id()}}"  class="btn btn-block btn-primary btn-xs"><i class="fa fa-registered"></i>&nbsp;&nbsp;Yêu cầu cập nhật</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<script src="/user_24/js/dangkyxettuyen.js"></script>
</body>
</html>
