<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <!-- @include('user_24.admin_24.preloader')  --> --}}
        <!-- /.preloader -->

        <!-- Navbar -->
        @include('user_24.admin24.include.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('user_24.admin24.include.sidebar')
        <!-- /.sidebar -->
        {{-- @yield('sidebar1') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1302.12px;">
            @include('user_24.admin24.include.contentheader')
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card" style="min-height: 590px">

                                {{ $res }}
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="ttsv_nghenghiepcha_sv" class="col-sm-3 col-form-label"
                                            style="padding-bottom: 0px ">Ho ten:</label>
                                        <div class="col-sm-9">
                                            <input type="text" onchange="loadthongtincanhan()" class="form-control ttsv_info search_cha"
                                                id="loadthongtincanhan" name="ttsv_nghenghiepcha_sv"
                                                style="height:28px" value="">
                                        </div>
                                    </div>


                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="ttsv_nghenghiepcha_sv" class="col-sm-4 col-form-label"
                                            style="padding-bottom: 0px ">Ho ten:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control ttsv_info search_cha"
                                                id="hoten" name="ttsv_nghenghiepcha_sv"
                                                style="height:28px" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <select id="abc" style="width: 100%">
                                        @foreach ($res as $row)
                                            <option value="{{ $row->id }}">{{ $row->text }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="custom-control">
                                        <input style="height: 13px" @if ($res[0]->check == 1)
                                            checked
                                        @else

                                        @endif
                                            class="file_hs_ts file_hs_ts3" type="checkbox" old_data="1" id-data="3"
                                            id="3" value="">

                                            <label style="font-weight:normal"
                                            for="3" class="">&nbsp;&nbsp;Học bạ Trung học phổ thông
                                            (6HK)</label>
                                        </div>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('user_24.admin24.include.footer')
    </div>
</body>

</html>
<script src="/admin/admin24/js/hosotructuyen.js"></script>
<script>

    $('#abc').select2();

    function loadthongtincanhan(){

        var id_taikhoan = $('#loadthongtincanhan').val()
        $.ajax({
            url: "hosonhaphoc/loadttcn/"+id_taikhoan,
            type:'get',

            success:function(res){
                if(res.length > 0){
                    $('#hoten').val(res[0].text)
                }else{
                    $('#hoten').val('')
                }

            }
        })
    }




</script>
