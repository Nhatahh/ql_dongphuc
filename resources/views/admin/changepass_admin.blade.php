<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card card-navy card-outline" style = "min-height:600px">
                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Đổi mật khẩu

                </div>

                <div class="card-body" style=" padding: 3px" >


                    <div class="row">
                        {{-- mật khẩu cũ--}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span style = "background-color: inherit;color: black;font-weight: bold;border: none;" class="input-group-text">Mật khẩu cũ:</span>
                                </div>
                                <input type="password" name = "user_passwordreset_old_admin" id = 'user_passwordreset_old_admin' value="{{old('user_passwordreset_old_admin')}}" class="validate_changepass_admin form-control">
                            </div>
                            <div class="col-md-12">
                                <sup>
                                    <p class="error" id="v_user_passwordreset_old_admin" ></p>
                                </sup>
                            </div>
                        </div>

                        <div class="col-md-6">
                        </div>

                        {{-- Mật khẩu mới --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span style = "background-color: inherit;color: black;font-weight: bold;border: none;" class="input-group-text">Mật khẩu mới:</span>
                                </div>
                                <input type="password" name = "user_passwordreset_admin" id = 'user_passwordreset_admin' value="{{old('user_passwordreset_admin')}}" class="form-control validate_changepass_admin">
                            </div>
                                <div class="col-md-12">
                                <sup>
                                    <p id = "v_user_passwordreset_admin" class="error"></p>
                                </sup>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        {{-- Nhập lại mật khẩu mới --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span style = "background-color: inherit;color: black;font-weight: bold;border: none;" class="input-group-text">Nhập lại mật khẩu mới:</span>
                                </div>
                                <input type="password" id="user_passwordreset_confirm_admin" name="user_passwordreset_confirm_admin" class="validate_changepass_admin form-control" value="{{old('user_passwordreset_admin')}}">
                            </div>
                            <div class="col-md-12">
                                <sup>
                                    <p id='v_user_passwordreset_confirm_admin' class="error"></p>
                                </sup>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-3 col-md-12">
                                <div class="input-group-prepend">
                                </div>
                                <button type="button" id = 'id_user_admin' id-data = '{{Auth::user()->id}}' onclick="UserChangePass_admin()" class="btn-sm btn-primary"><i class="fa fa-key"></i> Đổi mật khẩu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/admin/js/changepass_admin/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>


