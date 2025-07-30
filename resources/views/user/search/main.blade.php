
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card card-navy card-outline" style = "min-height:600px">
                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thông tin cá nhân <a style="font-weight:normal;color:#007bff">(Upload ảnh đại diện là ảnh chân dung cá nhân)</a>
                </div>
                <div class="card-body" style="padding-top: 5px">
                    <div class="row">
                        <div class="col-md-1" style="margin-top: 10px;text-align:center">
                            <form id="form_userImg" enctype="multipart/form-data">
                                <img class="profile-user-img img-fluid img-circle" src = '/storage/profile/start.png' alt="Ảnh cá nhân"  id="userImg">
                            </form>
                            <div style=" margin-right: 100px; margin-top: -16px;"><i class="fa fa-camera add_school"  style = "font-size: 12pt" id ='attr_userImage' aria-hidden="true"></i></div>
                            <input type='file' id='open_userImg' name ='open_userImg' style = "display: none">
                        </div>
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="name_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Họ và tên:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name_user" style="height:30px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="birth_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Ngày sinh:</label>
                                        <div class="col-sm-8">
                                        <input type="date" class="form-control" placeholder="01/01/2004" id="birth_user" style="height:30px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_place_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Nơi sinh Tỉnh:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="id_place_user" style="width: 100%;">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_card_users" class="col-sm-4 col-form-label"  style="padding-bottom: 0px">CMND/CCCD&nbsp;<i class="fa fa-paperclip attr info_attr" id = "id_card_users_attr" id-data = "1" data = "0" type_img = "0" onclick="id_card_users_img(1,0)" style = "color: red" aria-hidden="true"></i></label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id='id_card_users'  value = "" disabled style="height:30px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="email_users" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"  >Email:</label>
                                        <div class="col-sm-8">
                                        <input type="email" class="form-control" id='email_users' style="height:30px" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="emailsc_user" class="col-sm-4 col-form-label"  style="padding-bottom: 0px"  >Email phụ:</label>
                                        <div class="col-sm-8">
                                        <input type="email" class="form-control" id='emailsc_user' style="height:30px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="nation_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Dân tộc:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="nation_user" style="width: 100%;">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="phone_users" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Số điện thoại:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id='phone_users' style="height:30px" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="phonesc_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Số ĐT phụ huynh:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id='phonesc_user' style="height:30px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_khttprovince_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">HKTT Tỉnh:</label>
                                        <div class="col-sm-8" >
                                            <select class="province" id = "id_khttprovince_user" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_khttprovince_user2" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">HKTT Huyện:</label>
                                        <div class="col-sm-8">
                                            <select class="province2" id = "id_khttprovince_user2" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="id_khttprovince_user3" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">HKTT Xã/Phường:</label>
                                        <div class="col-sm-8">
                                            <select class="province3" id = "id_khttprovince_user3" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12" style="margin-bottom: -18px">
                                    <div class="form-group row" style="margin-bottom: 3px;">
                                        <label for="sex_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Giới tính:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group  input-group-sm mb-3">
                                                <div class="input-group-prepend"></div>
                                                <div class="input-group-prepend">
                                                    <input class="" type="radio" id = 'male_user' name="radio1" style="margin-top: 2px">
                                                    <div class="" style="padding-top: 7px;">
                                                        <span class="" >&nbsp;&nbsp;&nbsp; Nam</span>
                                                    </div>
                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="input-group-prepend">
                                                    <input class="" type="radio" id = 'female_user' name="radio1" style="margin-top: 2px">
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
                                        <label for="graduation_year_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Năm TN:&nbsp;<i class="fa fa-paperclip attr info_attr" id = "graduation_year_user_attr" id-data = "1" data = "0" type_img = "4"  onclick="graduation_year_user_img(1,4)" style = "color: red"aria-hidden="true"></i></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="graduation_year_user" style="height:30px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="address_user" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Địa chỉ:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="address_user" style="height:30px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group row" style="margin-bottom: 3px">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label" style="padding-bottom: 0px"></label>
                                        <div class="col-sm-5">
                                            <button type="button" id = "add_infoUser" class="btn btn-block btn-primary btn-xs">Lưu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header" style="padding: 0;font-weight: bold;">Trường Trung học phổ thông</div>
                    <div class="row">
                        <div class="col-md-8 col-12">

                        </div>
                        <div class="col-md-4 col-12">
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
                        <div class="col-md-3 col-12">
                            <div class="col-form-label" style="padding: 0;font-weight: bold;margin-top: 5px;margin-left: 10px">Khu vực ưu tiên tính điểm xét tuyển: <span style="color: rgb(23, 162, 184);" id = "priority_area"></span></span></div>
                        </div>
                        <div class="col-md-1 col-12">
                            <button type="button"  id = "addArea"class="btn btn-block btn-primary btn-xs">Lưu</button>
                        </div>
                        <div class="col-md-4 col-12">

                        </div>
                        <div class="col-md-4 col-12">
                            <sup style = "color: rgb(23, 162, 184); margin-left: 0px;font-weight:bold">Lưu ý: Một học kì tương ứng 4.5 tháng. Một năm học tương ứng 9 tháng.</sup>
                        </div>
                    </div>

                    <div class="card-header" style="padding: 0;font-weight: bold; margin-top: 10px">Chính sách ưu tiên tuyển sinh
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-12" style="margin-top: 5px">
                            <div class="form-group row" style="margin-bottom: 3px;margin-left: 0px;">
                                <label for="Priority_policy" class="col-sm-4 col-form-label" style="padding-bottom: 0px ">Đối tượng ưu tiên:</label>
                                <div class="col-sm-8" >
                                    <select class="" id = "Priority_policy" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-12" style="margin-top: 5px">
                            <div class="form-group row" style="margin-bottom: 3px;margin-left: 0px;">
                                <button type="button"  id = "addPriority_policy" class="btn btn-block btn-primary btn-xs">Lưu</button>
                            </div>
                        </div>
                        <div class="col-md-7 col-12" style="margin-top: 5px">
                            <a id="load_list_policy"></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12" style="margin-top: 5px">
                            <div class="form-group row" style="margin-bottom: 3px;margin-left: 0px;">
                                <label for="Priority_policy" class="col-sm-1 col-form-label" style="padding-bottom: 0px;color: red ">Hướng dẫn:</label>
                                <div class="col-sm-11" >
                                    <textarea class="form-control" id = "note_Priority_policy" rows="6" style = "font-size: 0.9rem; background-color:inherit" disabled placeholder="Hướng dẫn chọn đối tượng chính sách ưu tiên theo quy định"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh --}}
<input type='file' id='open_img_policy' name ='open_img_policy' style = "display: none">



<div class = "modal" id="modal2">
    <div style="text-align:center; background-color: rgba(0,0,0,.4);height: 100%;">
        <div id="resizer-demo" style="margin-bottom: 0px;">
            <i class="fas fa-check" id = "crop" style = "font-size: 15pt; color: #007bff;"></i>&nbsp;&nbsp;&nbsp;
            <i class="fas fa-times" id = "crop_close" style = "font-size: 15pt; color: #007bff;"></i>
        </div>
    </div>
</div>



<div class = "modal" id="modal_policy">
    <div style="text-align:center; background-color: rgba(0,0,0,.4);height: 100%;">
        <div id="resizer-policy" style="margin-bottom: 0px;">
            <i class="fas fa-check" id = "crop_policy" style = "font-size: 15pt; color: #007bff;"></i>&nbsp;&nbsp;&nbsp;
            <i class="fas fa-times" id = "crop_policy_close" style = "font-size: 15pt; color: #007bff;"></i>
        </div>
    </div>
</div>


<div class = "modal" id="modal_loadding_info">
    <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
        <div class="loader"></div>
    </div>
</div>





</html>

<script src="/user/js/search/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/croppie/croppie.js"></script>
