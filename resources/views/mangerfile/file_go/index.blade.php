
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card card-navy card-outline" id = 'left_check'>
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Tìm kiếm quy trình</div>
                    <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_place_user" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Năm học:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="step_setup_year" style="width: 100%;">
                                            <option value="0">Chọn Năm học</option>
                                            <option value="1">Năm học 2022 - 2023(HK1)</option>
                                            <option value="2">Năm học 2022 - 2023(HK2)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_place_user" class="col-sm-3 col-form-label" style="padding-bottom: 0px">Quy trình</label>
                                    <div class="col-sm-9">
                                        <select class="form-control"  id="step_setup_steps" style="width: 100%;">
                                            {{-- <option value="0">Chọn Năm học</option>
                                            <option value="1">Đăng ký tài khoản</option>
                                            <option value="2">Lưu nguyện vọng</option> --}}
                                            <option value="3">Tuyển sinh đại học chính quy 2022</option>
                                        </select>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="id_user_check" class="col-sm-3 col-form-label" style="padding-bottom: 0px">ID Hố sơ:</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id='' style="height:28px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">

                                        <div class="col-md-4 col-12">
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <button type="button"  id = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <button type="button"  id = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="ccol-12 col-md-8 col-lg-8">
            <div class="card card-navy card-outline" id = 'right_check' >
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh mục hồ sơ</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "">
                        <table class="table table-hover text-nowrap"  id = "">
                            <thead>
                                <th>ID Hồ sơ</th>
                                <th>Loại hồ sơ</th>
                                <th>Nội dung</th>
                                <th>Hướng dẫn nhân viên</th>
                                <th>Mã hóa minh chứng</th>
                                <th colspan="2">Chức năng</th>
                                {{-- <th colspan="1">Chức năng</th> --}}
                            </thead>
                            <tbody>
                                <tr>
                                    <td>TS001</td>
                                    <td>Quy chế</td>
                                    <td>Quy chế tuyển sinh 2022</td>
                                    <td></td>
                                    <td></td>
                                    <td><i onclick = "view_check()" style = "color:#007bff" class="fas fa-pencil-alt"></i></td>
                                    <td><i  style = "color:red" class="fa fa-trash" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>TS002</td>
                                    <td>Thông tư</td>
                                    <td>Xác định chỉ tiểu tuyển sinh</td>
                                    <td></td>
                                    <td></td>
                                    <td><i onclick = "view_check()" style = "color:#007bff" class="fas fa-pencil-alt"></i></td>
                                    <td><i  style = "color:red" class="fa fa-trash" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>TS004</td>
                                    <td>Báo cáo</td>
                                    <td>Xác định chỉ tiểu tuyển sinh</td>
                                    <td></td>
                                    <td></td>
                                    <td><i  style = "color:#007bff" class="fas fa-pencil-alt"></i></td>
                                    <td><i  style = "color:red" class="fa fa-trash" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>TS005</td>
                                    <td>Thông báo</td>
                                    <td>Thông báo tuyển sinh đại học chính quy 2022</td>
                                    <td>Dựa vào BC xác định chỉ tiêu</td>
                                    <td></td>
                                    <td><i  style = "color:#007bff" class="fas fa-pencil-alt"></i></td>
                                    <td><i  style = "color:red" class="fa fa-trash" aria-hidden="true"></i></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                        <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                            <div class="row">

                                <div class="col-md-10 col-12">
                                </div>
                                {{-- <div class="col-md-4 col-12">
                                    <button type="button"  id = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                </div> --}}
                                <div class="col-md-2 col-12">
                                    {{-- <button type="button"  id = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-plus" aria-hidden="true"></i></i>&nbsp;&nbsp;&nbsp;Thêm hồ sơ</button> --}}
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Modal Resize Ảnh học bạ lớp 10--}}

    <div class = "" id="modal_file_go">
        <div style="background-color: #f4f6f9;height: 100%;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-navy card-outline" id = 'right_check_user'>

                            <div class="row">
                                <div class="col-12 col-md-8 col-lg-8">
                                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thông tin hồ sơ trong danh mục hồ sơ</div>
                                    <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="name_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">ID hồ sơ:</label>
                                                                    <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="" style="height:28px" value="TS001">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="id_place_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Loại Hồ sơ:</label>
                                                                    <div class="col-sm-8" style="text-align: left">
                                                                        <select class="form-control" id="" style="width: 100%;">
                                                                            <option>Quy chế</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal" >Quy trình:</label>
                                                                    <div class="col-sm-8" style="text-align: left">
                                                                        <select class="form-control" id="aaaaaaaaaaaaa" style="width: 100%;">
                                                                            <option>Tuyển sinh đại học chính quy 2022</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="birth_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Mã minh chứng:</label>
                                                                    <div class="col-sm-8">
                                                                    <input type="" class="form-control" id="" style="height:28px">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="birth_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px;font-weight:normal">Nội dung yêu cầu:</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control" id = "" value = "Quy chế tuyển sinh 2022" rows="2" style = "font-size: 0.9rem; background-color:inherit"  placeholder=""></textarea>

                                                                    </div>
                                                                </div>
                                                            </div>



                                                            {{-- <div class="col-md-4 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="add_infoUser_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px"></label>
                                                                    <div class="col-sm-8">
                                                                        <button type="button" id = "add_info_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp; Lưu</button>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Lập hồ sơ</div>
                                    <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="name_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Số hồ sơ:</label>
                                                                    <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="" style="height:28px" value="08/2022/TT-BGDĐT">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="name_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Thời gian ban hânh:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="date" class="form-control" id="" style="height:28px" value="06/06/2022">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="name_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Cơ quan ban hành:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" id="" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="name_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Người ký:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" id="" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal" >Hiệu lực:</label>
                                                                    <div class="col-sm-8" style="text-align: left">
                                                                        <select class="form-control" id="file_go_limit" style="width: 100%;">
                                                                            <option>Chưa ban hành</option>
                                                                            <option>Hiệu lực </option>
                                                                            <option>Hết hiệu lực </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="name_user_check" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Thay thế:</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" id="" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="birth_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px;font-weight:normal">Link công bố:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control" id="" style="height:28px" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-12">
                                                                <div class="form-group row" style="margin-bottom: 3px">
                                                                    <label for="birth_user_check" class="col-sm-2 col-form-label" style="padding-bottom: 0px;font-weight:normal">Nội dung yêu cầu:</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control" id = "" value = "Quy chế tuyển sinh 2022" rows="4" style = "font-size: 0.9rem; background-color:inherit"  placeholder=""></textarea>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-12">
                                                                <div>File soạn thảo &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" style="color:#007bff" aria-hidden="true"></i></div>
                                                            </div>
                                                            <div class="col-md-12 col-12">
                                                                <div>Bản chữ ký &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" style="color:#007bff" aria-hidden="true"></i></div>
                                                            </div>
                                                            <div class="col-md-12 col-12">
                                                                <div>Bản gốc &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip" style="color:#007bff" aria-hidden="true"></i></div>
                                                            </div>

                                                            <div class="col-md-9 col-12">
                                                            </div>
                                                            <div class="col-md-3 col-12">
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




                                </div>
                                <div class="col-12 col-md-4 col-lg-4">

                                    <div class="swiper">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper"></div>

                                            <!-- Slides -->
                                            <div class="swiper-slide"><img class="img-fluid" src="https://xettuyentest.ctuet.edu.vn/images/quychetuyensinh.png"></div>


                                        <div class="swiper-pagination"></div>
                                        <!-- If we need navigation buttons -->
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                        <!-- If we need scrollbar -->
                                        {{-- <div class="swiper-scrollbar"></div> --}}

                                    </div>
                                </div>
                            </div>













    <div class = "modal" id="modal_loadding_check_user">
        <div style="text-align:center; background-color: rgba(0,0,0,0);height: 100%;">
            <div class="loader"></div>
        </div>
    </div>

</html>



{{-- <script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script> --}}
<script src="/managerfile/js/file_go/control.js"></script>
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

