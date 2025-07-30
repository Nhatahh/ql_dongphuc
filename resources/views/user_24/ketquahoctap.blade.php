<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CTUT | Kết quả học tập</title>
  @include('user_24.head')

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
       {{-- {{$mons}} --}}
        <div class="row">
            <div class="col-12 col-xl-8 col-md-12">
                <fieldset class="card card-body">
                    <legend>Điểm Học bạ/Bảng điểm THPT</legend>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card-body table-responsive p-0">Lớp 10
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Môn</th>
                                            <th>Học kì 1</th>
                                            <th>Học kì 2</th>
                                            <th>Cả năm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $mons as $value )
                                            @if ($value ->id_type_subject == 1)
                                                <tr>
                                                    <td><input disabled style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="{{$value->name_subject}}"></td>
                                                    @if (empty($value->mark_result10hk1))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_1_{{$value->id}}"  @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "10" hocki = "1" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_1_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "10" hocki = "1" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result10hk1}}"></td>
                                                    @endif

                                                    @if (empty($value->mark_result10hk2))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_2_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "10" hocki = "2" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_2_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "10" hocki = "2" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result10hk2}}"></td>

                                                    @endif

                                                    @if (empty($value->mark_result10cn))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_CN_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "10" hocki = "CN" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_CN_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "10" hocki = "CN" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result10cn}}"></td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card-body table-responsive p-0">Lớp 11
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Môn</th>
                                            <th>Học kì 1</th>
                                            <th>Học kì 2</th>
                                            <th>Cả năm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $mons as $value )
                                            @if ($value ->id_type_subject == 1)
                                                <tr>
                                                    <td><input disabled style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->name_subject}}"></td>
                                                    @if (empty($value->mark_result11hk1))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_11_1_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "11" hocki = "1" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_11_1_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "11" hocki = "1" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result11hk1}}"></td>
                                                    @endif
                                                    @if (empty($value->mark_result11hk2))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_11_2_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "11" hocki = "2" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_11_2_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "11" hocki = "2" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result11hk2}}"></td>
                                                    @endif
                                                    @if (empty($value->mark_result11cn))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_11_CN_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "11" hocki = "CN" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_11_CN_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "11" hocki = "CN" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result11cn}}"></td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card-body table-responsive p-0">Lớp 12
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Môn</th>
                                            <th>Học kì 1</th>
                                            <th>Học kì 2</th>
                                            <th>Cả năm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $mons as $value )
                                            @if ($value ->id_type_subject == 1)
                                                <tr>
                                                    <td><input disabled style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->name_subject}}"></td>
                                                    @if (empty($value->mark_result12hk1))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_12_1_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "12" hocki = "1" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_12_1_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "12" hocki = "1" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result12hk1}}"></td>
                                                    @endif
                                                    @if (empty($value->mark_result12hk2))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_12_2_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "12" hocki = "2" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_12_2_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "12" hocki = "2" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result12hk2}}"></td>
                                                    @endif
                                                    @if (empty($value->mark_result12cn))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_12_CN_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "12" hocki = "CN" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_12_CN_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif class="ketquahoctap" lop = "12" hocki = "CN" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:110%;width:110%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_result12cn}}"></td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card card-body">
                    <legend>Điểm thi Tốt nghiệp THPT Quốc gia</legend>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Môn</th>
                                            <th>Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $mons as $value )
                                            @if ($value ->id_type_subject == 1)
                                                <tr>
                                                    <td><input disabled style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="{{$value->name_subject}}"></td>
                                                    @if (empty($value->mark_resultTN))
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_1_{{$value->id}}"  @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "TN" hocki = "PT" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="0"></td>
                                                    @else
                                                        <td><input id="ketquahoctap{{Auth::guard('loginbygoogles')->id()}}_10_1_{{$value->id}}" @if($checkkhoadangky == 1)  disabled @endif id-tohop = "tohop{{$value->id}}" class="ketquahoctap" lop = "TN" hocki = "PT" id_user = {{Auth::guard('loginbygoogles')->id()}} mon = "{{$value->id}}" style="hight:100%;width:100%;text-align:center;border:none;background-color:transparent" value="{{$value->mark_resultTN}}"></td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
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
<script src="/user_24/js/ketquahoctap.js"></script>
</body>
</html>
