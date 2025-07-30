
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Tìm kiếm thí sinh</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="year_check" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Trạng thái:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control"  id="active_check" style="width: 100%;">
                                            {{-- <option value="0">Chọn Trạng thái hồ sơ</option>
                                            <option value="1">Đăng ký tài khoản</option>
                                            <option value="2">Lưu nguyện vọng</option> --}}
                                            <option value="3">Đăng ký xét tuyển</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="batch_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Đợt TS:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="batch_check" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_card_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >CMND/TCC:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='id_card_check' style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="phone_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Điện thoại:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='phone_check' style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px">ID thí sinh:</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id='id_user_check' style="height:28px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "clear_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <button type="button"  id = "search_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Trạng thái đăng ký</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">

                    </div>
                </div>

            </div>
        </div>

        <div class="ccol-12 col-md-9 col-lg-9">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách thí sinh</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_list_reg">
                        {{-- <table class="table table-hover text-nowrap"  id = "load_list_reg"> --}}
                            {{-- Hiện thị Users--}}
                        {{-- </table> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Modal Resize Ảnh học bạ lớp 10--}}

    <div class = "modal" id="modal_check">
        <div style="background-color: #f4f6f9;height: 100%;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-navy card-outline" id = 'right_check_user'>
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                <div class="row">
                                    <div class="col-md-1 col-lg-1 col-6">
                                        <label style="padding-bottom: 0px">ID:</label>
                                        <span id="id_user_check1"></span>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-6">
                                        <label style="padding-bottom: 0px ">Họ và tên:</label>
                                        <span id = "name_user_check1"></span>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-6">
                                        <label style="padding-bottom: 0px ">Email:</label>
                                        <span id="emailsc_user_check1"></span>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-6">
                                        <label style="padding-bottom: 0px ">Số điện thoại:</label>
                                        <span id="phonesc_user_check1"></span>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-6">
                                        <label style="padding-bottom: 0px ">CMND/TCC:</label>
                                        <span id="id_card_users_check1"></span>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-6">
                                        <a  class="float-right" id = 'close_check' style="margin-right: 10px"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                                <div class="row">
                                    <div class="col-12 col-md-8 col-lg-8">

                                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-info" aria-selected="true">Thông tin cá nhân</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-mark-tab" data-toggle="pill" href="#custom-content-below-mark" role="tab" aria-controls="custom-content-below-mark" aria-selected="true">Điểm</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-wish-tab" data-toggle="pill" href="#custom-content-below-wish" role="tab" aria-controls="custom-content-below-wish" aria-selected="false">Nguyện vọng</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-wish-file" data-toggle="pill" href="#custom-content-below-file" role="tab" aria-controls="custom-content-below-file" aria-selected="false">Hồ sơ</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-mail" role="tab" aria-controls="custom-content-below-mail" aria-selected="false">Mail</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-history-tab" data-toggle="pill" href="#custom-content-below-history" role="tab" aria-controls="custom-content-below-history" aria-selected="false">Lịch sử</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="custom-content-below-tabContent"  style="padding-top: 3px">
            {{-- Thông tin cá nhân --}}
                                            <div class="tab-pane fade active show" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
                                                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thông tin cá nhân</div>
                                                <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <div class="row">
                                                                <div class="col-md-2 col-12">
                                                                    <div style = "padding-top: 40px">
                                                                        <form id="form_userImg" enctype="multipart/form-data">
                                                                            <img class="profile-user-img img-fluid img-circle " src = '/storage/profile/start.png' alt="Ảnh cá nhân"  id="userimg_check">
                                                                        </form>
                                                                        <div style=" margin-right: 100px; margin-top: -16px;"><i class="fa fa-camera add_school"  style = "font-size: 12pt" id ='attr_userImage' aria-hidden="true"></i></div>
                                                                        <input type='file' id='open_userImg' name ='open_userImg' style = "display: none">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10 col-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="name_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Họ và tên:</label>
                                                                                <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="name_user_check" style="height:28px">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="birth_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Ngày sinh:</label>
                                                                                <div class="col-sm-8">
                                                                                <input type="date" class="form-control" id="birth_user_check" style="height:28px">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="id_place_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Nơi sinh:</label>
                                                                                <div class="col-sm-8" style="text-align: left">
                                                                                    <select class="form-control" id="id_place_user_check" style="width: 100%;">

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="id_card_users_check" class="col-sm-4 col-form-label"  style="padding-bottom: 0px;font-weight:normal" disabled>CMND/CCCD</label>
                                                                                <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id='id_card_users_check'  value = "" style="height:28px" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="email_users_check" class="col-sm-4 col-form-label"  style="padding-bottom: 0px;font-weight:normal"  >Email:</label>
                                                                                <div class="col-sm-8">
                                                                                <input type="email" class="form-control" id='email_users_check' style="height:28px" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="emailsc_user_check" class="col-sm-4 col-form-label"  style="padding-bottom: 0px;font-weight:normal"  >Email phụ:</label>
                                                                                <div class="col-sm-8">
                                                                                <input type="email" class="form-control" id='emailsc_user_check' style="height:28px">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="nation_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal" >Dân tộc:</label>
                                                                                <div class="col-sm-8" style="text-align: left">
                                                                                    <select class="form-control" id="nation_user_check" style="width: 100%;">

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="phone_users_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal" >Điện thoại:</label>
                                                                                <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id='phone_users_check' style="height:28px" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="phonesc_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal" >ĐT phụ:</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text" class="form-control" id='phonesc_user_check' style="height:28px">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="id_khttprovince_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal ">HKTT Tỉnh:</label>
                                                                                <div class="col-sm-8" style="text-align: left" >
                                                                                    <select class="" id = "id_khttprovince_user_check" style="width: 100%;">

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="id_khttprovince_user2_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal ">HKTT Huyện:</label>
                                                                                <div class="col-sm-8"  style="text-align: left">
                                                                                    <select class="" id = "id_khttprovince_user2_check" style="width: 100%;">

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="id_khttprovince_user3_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal ">HKTT Xã:</label>
                                                                                <div class="col-sm-8"  style="text-align: left">
                                                                                    <select class="province3" id = "id_khttprovince_user3_check" style="width: 100%;">

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12" style="margin-bottom: -18px">
                                                                            <div class="form-group row" style="margin-bottom: 3px;">
                                                                                <label for="sex_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Giới tính:</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="input-group  input-group-sm mb-3">
                                                                                        <div class="input-group-prepend"></div>
                                                                                        <div class="input-group-prepend">
                                                                                            <input class="" type="radio" id = 'male_user_check' name="radio1_check" style="margin-top: 2px">
                                                                                            <div class="" style="padding-top: 7px;">
                                                                                                <span class="" >&nbsp;&nbsp;&nbsp; Nam</span>
                                                                                            </div>
                                                                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        <div class="input-group-prepend">
                                                                                            <input class="" type="radio" id = 'female_user_check' name="radio1_check" style="margin-top: 2px">
                                                                                            <div class="" style="padding-top: 7px;">
                                                                                                <span class="" >&nbsp;&nbsp;&nbsp; Nữ</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px;">
                                                                                <label for="graduation_year_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Năm TN</label>
                                                                                <div class="col-sm-8">
                                                                                    <input disabled type="text" class="form-control" id="graduation_year_user_check" style="height:28px">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="address_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Địa chỉ:</label>
                                                                                <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="address_user_check" style="height:28px">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="add_infoUser_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px"></label>
                                                                                <div class="col-sm-8">
                                                                                    <button type="button" id = "add_info_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="row">
                                                            <div class="col-md-12 col-12">
                                                                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Khu vực ưu tiên</div>
                                                                <div class="card-body" style="padding-top: 5px;padding-bottom:5px" >
                                                                    <div class="row">
                                                                        <div class="col 12 col-md-12">
                                                                            <div id = "remove_load_list_school">
                                                                                <table class="table table-hover text-nowrap" style = "width:100%">
                                                                                    <thead>
                                                                                        <th style = "width: 10%">Lớp</th>
                                                                                        <th style = "width: 20%">Tỉnh THPT</th>
                                                                                        <th style = "width: 45%">Trường THPT</th>
                                                                                        <th style = "width: 10%">Thời gian</th>
                                                                                        <th style = "width: 15%">Khu vực</th>
                                                                                    </thead>
                                                                                    <tbody id = "load_list_school">
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col 12 col-md-12" style="text-align: left;margin-top:-12px;margin-bottom:3px">
                                                                            <span>Khu vực ưu tiêu theo Trường THPT: </span> <span style="font-weight:bold;color: #007bff" id = "area_check"> </span>
                                                                        </div>
                                                                        <div class="col-12 col-md-4">
                                                                        </div>
                                                                        <div class="col-12 col-md-2">
                                                                            <button type="button" id = "clear_school_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-trash" ></i>&nbsp;&nbsp;&nbsp;Xóa</button>
                                                                        </div>
                                                                        <div class="col-12 col-md-2">
                                                                            <button type="button" id = "reset_school_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom" ></i>&nbsp;&nbsp;&nbsp;Reset</button>
                                                                        </div>
                                                                        <div class="col-12 col-md-2">
                                                                            <button type="button" id = "add_school_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-plus" ></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                                                        </div>
                                                                        <div class="col-12 col-md-2">
                                                                            <button type="button" id = "save_school_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save" ></i>&nbsp;&nbsp;&nbsp;Lưu</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-12">
                                                                <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Đối tượng ưu tiên</div>
                                                                <div class="card-body" style="padding-top: 5px">
                                                                    <div class="row">
                                                                        <div class="col-md-5 col-12" style="text-align: left">
                                                                            <div class="form-group row" style="margin-bottom: 3px">
                                                                                <label for="plicy_check" class="col-sm-5 col-form-label" style="padding-bottom: 0px;font-weight:normal ">Đối tượng ưu tiên:</label>
                                                                                <div class="col-sm-7"  style="text-align: left">
                                                                                    <select class="" id = "plicy_check" style="width: 100%;">

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-7 col-12" style="text-align: left"></div>
                                                                        <div class="col-md-12 col-12" style="text-align: left">
                                                                            <span>Mô tả:</span><br>
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id = "info_plicy_check"></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-12" style="text-align: left">
                                                                            <span>Minh chứng cần kiểm tra: </span> <span id = "file_plicy_check"> </span>
                                                                        </div>
                                                                        <div class="col-12 col-md-8">
                                                                        </div>
                                                                        <div class="col-12 col-md-2">
                                                                            <button type="button" id = "reset_policy_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom" ></i>&nbsp;&nbsp;&nbsp;Reset</button>
                                                                        </div>
                                                                        <div class="col-12 col-md-2">
                                                                            <button type="button" id = "save_policy_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save" ></i>&nbsp;&nbsp;&nbsp;Lưu</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            {{-- Điểm  --}}
                                            <div class="tab-pane fade" id="custom-content-below-mark" role="tabpanel" aria-labelledby="custom-content-below-mark-tab">
                                                <div class="row">
                                                    <div class="col-12 col-md-12 col-lg-12">
                                                        <div id = "mark_check">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            {{--Nguyện vọng --}}
                                            <div class="tab-pane fade" id="custom-content-below-wish" role="tabpanel" aria-labelledby="custom-content-below-wish-tab">
                                                <div id = "wish_check">

                                                </div>
                                            </div>
            {{--Hồ sơ --}}
                                            <div class="tab-pane fade" id="custom-content-below-file" role="tabpanel" aria-labelledby="custom-content-below-file-tab">
                                                <div class="row">
                                                    <div class="col-12 col-md-5 col-lg-5" style="padding-top: 8px;">
                                                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Hồ sơ tuyển sinh</div>
                                                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px" >
                                                            <div class="row">
                                                                <div class="col-12 col-md-12 col-lg-12" id="check_user_load_list_file">

                                                                </div>
                                                                <div class="col-12 col-md-12 col-lg-12" >
                                                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px" >
                                                                        <div class="row">
                                                                            <div class="col-12 col-md-4 col-lg-4" >
                                                                                <button type="button"   id = "check_user_clear_list_file"   onclick = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 col-lg-4" >
                                                                                <button type="button"   id = "check_user_save_list_file"   onclick = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Lưu</button>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 col-lg-4" >
                                                                                <button type="button"   id = "check_user_phieu_list_file"   onclick = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;In phiếu</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thông tin nhập học</div>
                                                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px" >
                                                            <div class="row">
                                                                <div class="col-12 col-md-12 col-lg-12" id="check_user_load_list_file_maphieu">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-12 col-lg-12" style="padding-top: 8px;">
                                                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Lịch sử thu hồ sơ</div>
                                                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px" id = "remove_check_user_his_list_file">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            {{--Mail --}}
                                            <div class="tab-pane fade" id="custom-content-below-mail" role="tabpanel" aria-labelledby="custom-content-below-mail-tab">
                                                <div style="margin-top: 5px" >
                                                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Mail phản hồi</div>
                                                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                        <div class="row" style="margin-top: 3px">
                                                            <div class="col-12 col-md-12">
                                                                <textarea class="form-control" id = "faceback_content" rows="6" style = "font-size: 0.9rem; background-color:inherit"  placeholder="Nhập nội dung gửi mail cho thí sinh"></textarea>
                                                            </div>
                                                            <div class="col-12 col-md-10">
                                                            </div>
                                                            <div class="col-12 col-md-2">
                                                                <button type="button" style="width: 90%;margin-top: 3px" onclick = "faceback_check_user()" id = "faceback_check_user" class="btn btn-block btn-primary btn-xs"><i class="fa fa-envelope"></i>&nbsp;Gửi mail</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            {{--Lịch sử --}}
                                            <div class="tab-pane fade" id="custom-content-below-history" role="tabpanel" aria-labelledby="custom-content-below-history-tab">
                                                <div id = "remove_load_list_history">

                                                </div>
                                                {{-- <table class="table table-bordered table-hover"  id = "load_list_history" style="width:100%"></table> --}}
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="swiper">
                                            <!-- Additional required wrapper -->
                                            <div class="swiper-wrapper"></div>
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
                            </div>


                            <div class="card-footer" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                {{-- <div class="row">
                                    <div class="col-md-12 col-lg-12 col-16"> --}}
                                        {{-- Quý Thầy/Cô kiểm tra cận thận, đúng quy trình, đúng hướng dẫn. Nếu có vấn đề sai sót hoặc chưa rõ, vui lòng liên hệ thầy Phan Tú, 0372707453 --}}
                                    {{-- </div> --}}
                                    {{-- <div class="col-md-2 col-lg-2 col-6">
                                        <label style="padding-bottom: 0px ">Họ và tên:</label>
                                        <span>Nguyễn Phan Tú</span>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-6">
                                        <label style="padding-bottom: 0px ">Email:</label>
                                        <span>nptu@ctuet.edu.vn</span>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-6">
                                        <label style="padding-bottom: 0px ">Số điện thoại:</label>
                                        <span>0372707453</span>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-6">
                                        <label style="padding-bottom: 0px ">CMND/TCC:</label>
                                        <span>0372707123453</span>
                                    </div> --}}

                                {{-- </div> --}}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <input type='file' id='img_check' name ='img_check' style = "display: none">
    </div>

    <div class = "modal" id="modal_loadding_check_user">
        {{-- <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div> --}}
        <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height:100%;">
            <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
                <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto">
                {{-- <span style="color:white"><strong id = "loadding_go_virtual_mess"></strong></span> --}}
            </div>
        </div>
    </div>



</html>



{{-- <script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script> --}}
<script src="/admin/js/checkuser/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
{{-- <script src="/bxslider/dist/jquery.bxslider.min.js"></script> --}}
{{-- <script src="/zoom/jquery.zoom.js"></script> --}}

{{-- <script src="/owlcarousel/dist/owl.carousel.js"></script> --}}
{{-- <script src="//code.jquery.com/jquery-latest.min.js"></script> --}}
{{-- <script src="/unslider/dist/js/unslider-min.js"></script> --}}

{{-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> --}}
<script src="/swiper/swiper.js"></script>
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- Summernote -->


{{-- <script src="/template/admin/plugins/jszip/jszip.min.js"></script> --}}
{{-- <script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script> --}}
{{-- <script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

{{-- <script src="/croppie/croppie.js"></script> --}}

