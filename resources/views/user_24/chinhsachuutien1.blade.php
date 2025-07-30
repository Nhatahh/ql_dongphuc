<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>
    @include('user_24.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-8">
                    <nav class="navbar navbar-expand navbar-white navbar-light"  style="padding: 0rem 0rem;    border-bottom: 1px solid #dee2e6;">
                        @include('user_24.navbar')
                    </nav>
                    <!-- Main content -->
                    <section class="" style="margin: 0rem 0rem; ">
                        <div class="container-fluid">
                            <fieldset class="card card-body">
                                <legend>Hộ khẩu thường trú</legend>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_khttprovince_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Tỉnh/TP:</label>
                                            <div class="col-sm-8" >
                                                <select class="province form-control" id = "id_khttprovince_user" style="width: 100%;height:28px" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_khttprovince_user2" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Huyện/Quận:</label>
                                            <div class="col-sm-8">
                                                <select class="province2 form-control" id = "id_khttprovince_user2" style="width: 100%;height:28px" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_khttprovince_user3" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Xã/Phường:</label>
                                            <div class="col-sm-8">
                                                <select class="province3 form-control" id = "id_khttprovince_user3" style="width: 100%; height:28px" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px;">
                                            <label for="graduation_year_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Dưới Xã/Phường:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="" style="height:30px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                    </div>
                                    <div class="col-md-10 col-12">
                                        <div class="row">
                                            <div class="col-md-10 col-12">
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <button type="button" id = "add_infoUser" class="btn btn-block btn-primary btn-xs">Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="card card-body">
                                <legend>Trường Trung học phổ thông</legend>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <sub style = "color: rgb(23, 162, 184); margin-left: 0px;font-weight:bold">Lưu ý: Một học kì tương ứng 4.5 tháng. Một năm học tương ứng 9 tháng.</sub>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="col-form-label" style="padding: 0;font-weight: bold;margin-top: 5px;margin-left: 10px">Lớp 10:&nbsp;&nbsp;<i class="fa fa-plus add_school" id = "add_school_10" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="col-md-11">
                                        <div id ='school_10'>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="col-form-label" style="padding: 0;font-weight: bold;margin-top: 5px;margin-left: 10px">Lớp 11:&nbsp;&nbsp;<i class="fa fa-plus add_school" id = "add_school_11" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="col-md-11">
                                        <div id ='school_11'>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="col-form-label" style="padding: 0;font-weight: bold;margin-top: 5px;margin-left: 10px">Lớp 12:&nbsp;&nbsp;<i class="fa fa-plus add_school" id = "add_school_12" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="col-md-11">
                                        <div id ='school_12'>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-12">
                                    </div>
                                    <div class="col-md-10 col-12">
                                        <div class="row">
                                            <div class="col-md-10 col-12">Khu vực ưu tiên:
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <button type="button" id = "add_infoUser" class="btn btn-block btn-primary btn-xs">Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            {{-- Đối tượng ưu tiên --}}
                            <fieldset class="card card-body">
                                <legend>Đối tượng ưu tiên</legend>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="id_khttprovince_user" class="col-sm-2 col-form-label" style="padding-bottom: 0px ">Đối tượng ưu tiên:</label>
                                            <div class="col-sm-10" >
                                                <select class="province form-control" id = "id_khttprovince_user" style="width: 100%;height:28px" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12" style="margin-top: 3px">
                                        <div class="form-group row" style="margin-bottom: 3px">
                                            <label for="Priority_policy" class="col-sm-2 col-form-label" style="padding-bottom: 0px;">Hướng dẫn:</label>
                                            <div class="col-sm-10" >
                                                <textarea class="form-control" id = "note_Priority_policy" rows="6" style = "font-size: 0.9rem; background-color:inherit" disabled placeholder="Hướng dẫn chọn đối tượng chính sách ưu tiên theo quy định"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                    </div>
                                    <div class="col-md-10 col-12">
                                        <div class="row">
                                            <div class="col-md-10 col-12">
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <button type="button" id = "add_infoUser" class="btn btn-block btn-primary btn-xs">Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                    </section>
                </div>


                {{-- Hinh anh ben phai --}}
                <div class="col-12 col-md-4" >
                    @include('user_24.content_right')
                </div>
            </div>
        </div>
    @include('user_24.footer')
    <script src="/user_24/js/chinhsachuutien.js"></script>
</body>
</html>
