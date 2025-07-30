<section class="content control-sidebar-slide-open">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card card-navy card-outline" style=" min-height: 630px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách Thành phố/Tỉnh</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_list_province">
                        <table class="table table-bordered table-striped" style = "width: 100%" id = "list_province"></table>

                    </div>

                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card card-navy card-outline" style=" min-height: 630px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách Quận/Huyện</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <table class="table table-bordered table-hover table-striped" style = "width: 100%" id = "list_province2"></table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 col-lg-4">
                <div class="card card-navy card-outline" style=" min-height: 630px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách Phường/Xã</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        <table class="table table-bordered table-hover table-striped" style = "width: 100%" id = "list_province3"></table>
                    </div>
                </div>
            </div>

        </div>

        {{-- <div class = "modal" id = "formactiveRoles_User">
            <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
                <div class="row">
                    <div class="col-md-4 col-12">
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="card card-navy card-outline" style="width:auto; height:auto;0 solid rgba(0,0,0,.125); padding: 2px;background-color:#fff; margin-top: 10%">
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                <div class="row">
                                    <div class="col-md-11 col-lg-11 col-11">
                                        <span  class="" id = "User_Roles"></span>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-1">
                                        <span  class="float-right" style="margin-right: 10px"><i onclick="close_key_user()" id = 'close_key_user' class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                                <form id="editFormRoles_User">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div style="margin-top: 3px" id = "remove_loadUser_Menus_Roles">

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class = "modal" id = "formactiveUser">
            <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
                <div class="row">
                    <div class="col-md-4 col-12">
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="card card-navy card-outline" style="width:auto; height:auto;0 solid rgba(0,0,0,.125); padding: 2px;background-color:#fff; margin-top: 10%">
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                <div class="row">
                                    <div class="col-md-11 col-lg-11 col-11">
                                        <span>Cập nhật người dùng</span>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-1">
                                        <span  class="float-right" style="margin-right: 10px"><i onclick="close_update_user()" id = 'close_update_user' class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                                <form id="editFormUser">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_name_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Người dùng:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name = "e_name_user" id = 'e_name_user' value="{{old('e_name_user')}}" class="validate_user form-control" style="height:28px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <sup>
                                                <p class="error" id="v_e_name_user" ></p>
                                            </sup>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_email_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Email:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name = "e_email_user" id = 'e_email_user' value="{{old('e_email_user')}}" class="validate_user form-control" style="height:28px;">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <sup>
                                                    <p class="error" id="v_e_email_user" ></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_password_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mật khẩu:</label>
                                                <div class="col-sm-8">
                                                    <input type="password" name = "e_password_user" id = 'e_password_user' value="{{old('e_password_user')}}" class="form-control validate_user" style="height:28px;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id = "v_e_password_user" class="error"></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_phone_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Điện thoại:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name = "e_phone_user" id = 'e_phone_user' value="{{old('phone_user')}}" class="form-control validate_user" style="height:28px;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id = "v_e_phone_user" class="error"></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_num_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Thứ tự:</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name = "e_num_user" id = 'e_num_user' value="{{old('e_num_user')}}" class="form-control validate_user" style="height:28px;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id = "v_e_num_user" class="error"></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_active_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Trạng thái:</label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" id="e_active_user" name="e_active_user" checked="" class="validate_user">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                <div class="row">
                                                    <div class="col-md-4 col-4">
                                                        <button type="button" id ='editUser' class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                                    </div>
                                                    <div class="col-md-4 col-4">
                                                        <button type="button" id ='clearEditUser'   class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                    </div>
                                                    <div class="col-md-4 col-4">
                                                        <button type="button" id ='destroyEditUser'   class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
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
        </div> --}}
    </div>
    </section>
    <script src="/admin/js/province/control.js"></script>
    <script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/template/admin/plugins/jszip/jszip.min.js"></script>
    <script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

