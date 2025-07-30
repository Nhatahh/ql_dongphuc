
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div>
                <div class="card card-navy card-outline" style="min-heigh: 600px; heigh: 600px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thực hiện xét tuyển</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        <div class="row">
                            <div class="col-md-5 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="go_batch" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chọn đợt tuyển sinh:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="go_batch" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group row" style="margin-bottom: 3px">
                                     <label for="go_active" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Trạng thái hồ sơ:</label>
                                     <div class="col-sm-8">
                                         <select class="form-control" id="go_active" style="width: 100%;">
                                             {{-- <option value="0">Chọn trạng thái</option> --}}
                                             {{-- <option value="1">Lưu nguyện vọng</option>
                                             <option value="2">Đã đăng ký xét tuyển</option>
                                             <option value="3">Đã đóng lệ phí</option>
                                             <option value="4">Đã kiểm tra hồ sơ</option>
                                             <option value="5">Đủ điều kiện xét tuyển</option> --}}
                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-1 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="go_number_wish" class="col-sm-5 col-form-label" style="padding-bottom: 0px" >NV:</label>
                                    <div class="col-sm-7">
                                    <input type="text" class="form-control" id='go_number_wish' style="height:28px">
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-2 col-6">
                                <button type="button"  id = "go_search" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                            </div>

                            <div class="col-md-6 col-12">

                            </div>

                            <div class="col-md-12 col-12 go_setup_method2" id-data = "1">
                                <div class="row">
                                    <div class="col-md-12 col-12" id ="remove_go_load"  >
                                        <div style="border: 2px solid  #dee2e6">
                                            <table class="table table-bordered text-nowrap" style="min-height: 550px">
                                                <thead>
                                                    <tr>
                                                        <th style="vertical-align:middle" rowspan="2">STT</th>
                                                        <th style="vertical-align:middle" rowspan="2">Ngành xét tuyển</th>
                                                        <th colspan="10">Tổng</th>
                                                        <th colspan="7">05 học kì (HB1)</th>
                                                        <th colspan="7">Lớp 12 (HB2)</th>
                                                        <th colspan="7">Đánh giá năng lực</th>
                                                    </tr>
                                                    <tr>
                                                        <th>CT</th>
                                                        <th>DK</th>
                                                        <th>DK_NV1</th>
                                                        <th>CT+</th>
                                                        <th>TT</th>
                                                        <th>NV1</th>
                                                        <th>NV2</th>
                                                        <th>NV3</th>
                                                        <th>TLCT</th>
                                                        <th>TL</th>
                                                        <th>CT</th>
                                                        <th>DK</th>
                                                        <th>Ngưỡng</th>
                                                        <th>ĐC</th>
                                                        <th>CT+</th>
                                                        <th>TT</th>
                                                        <th>TL</th>
                                                        <th>CT</th>
                                                        <th>DK</th>

                                                        <th>Ngưỡng</th>
                                                        <th>ĐC</th>
                                                        <th>CT+</th>
                                                        <th>TT</th>
                                                        <th>TL</th>
                                                        <th>CT</th>
                                                        <th>DK</th>
                                                        <th>Ngưỡng</th>
                                                        <th>ĐC</th>
                                                        <th>CT+</th>
                                                        <th>TT</th>
                                                        <th>TL</th>
                                                    </tr>
                                                </thead>
                                                <tbody  id = "go_load">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-12">
                                    </div>

                                    <div class="col-md-8 col-12">
                                        <div class="card-header" style="padding-bottom: 5px;padding-top: 4px;font-weight: bold;"></div>
                                        <div class="card-body" style="padding-top: 3px; padding-bottom:10px">
                                            <div class="row">
                                                {{-- <div class="col-md-2 col-6">
                                                    <button type="button"  id = "clear_check" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                </div> --}}
                                                <div class="col-md-2 col-6">
                                                    <button type="button"  id = "clear_check" onclick = "clear_check()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button type="button"  id = "go_virtual" onclick = "go_virtual()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-step-forward"></i>&nbsp;&nbsp;&nbsp;Lọc ảo</button>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button type="button"  id = "save_go"   onclick = "save_go()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Lưu</button>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button type="button"   id = "go_sta"   onclick = "go_sta()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Thống kê</button>
                                                </div>
                                                <div class="col-md-2 col-6">


                                                    {{-- <button type="button"  id = "ex_list_go" onclick = "ex_list_go()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Danh sách</button> --}}


                                                    {{-- <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                          Action
                                                        </button>
                                                        <ul class="dropdown-menu" style="">
                                                          <li class="dropdown-item"><a href="#">Action</a></li>
                                                          <li class="dropdown-item"><a href="#">Another action</a></li>
                                                          <li class="dropdown-item"><a href="#">Something else here</a></li>
                                                          <li class="dropdown-divider"></li>
                                                          <li class="dropdown-item"><a href="#">Separated link</a></li>
                                                        </ul>
                                                      </div> --}}


                                                    <div class="input-group-prepend">
                                                        {{-- <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> --}}
                                                            <button type="button" class="btn btn-block btn-primary btn-xs dropdown-toggle"  data-toggle="dropdown" aria-expanded="false"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Danh sách</button>
                                                          {{-- Action
                                                        </button> --}}
                                                        <ul class="dropdown-menu">
                                                            <li class="dropdown-item"><a id = "ex_list_student">Danh sách thí sinh</a></li>
                                                            <li class="dropdown-item"><a id = "ex_list_wish">Danh sách nguyện vọng</a></li>
                                                            <li class="dropdown-item"><a id = "ex_list_go">Danh sách TS trúng tuyển</a></li>
                                                            <li class="dropdown-item"><a id = "ex_list_fail">Danh sách TS không đạt</a></li>
                                                            <li class="dropdown-item"><a id = "ex_list_wish_fail">DS Nguyện vọng không đạt</a></li>
                                                        </ul>
                                                      </div>




                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <button type="button"  id = "go_block"   onclick = "go_block()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;Khóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 col-12 go_setup_method2" id-data = "2">
                                <div class="row">





                                </div>
                            </div>

                        </div>







                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div>
                <div class="card card-navy card-outline">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Biểu đồ số lượng thí sinh đăng ký</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        {{-- <div class="row">
                            <div class="col-12 col-md-5 col-lg-4">
                                <div class="form-group row" style="margin-bottom: 3px">
                                     <label for="sta_reg_active" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Đợt xét tuyển:</label>
                                     <div class="col-sm-8" style="text-align: left">
                                         <select class="form-control" id="sta_reg_batch" style="width: 100%;">

                                             <option value="1">Xét tuyển sớm 2023, đợt 1</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                            <div class="col-12 col-md-5 col-lg-4">
                               <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="sta_reg_active" class="col-sm-6 col-form-label" style="padding-bottom: 0px;font-weight:normal">Trạng thái đăng ký:</label>
                                    <div class="col-sm-6" style="text-align: left">
                                        <select class="form-control" id="sta_reg_active" style="width: 100%;">

                                            <option value="1">Lưu nguyện vọng</option>
                                            <option value="2">Đã đăng ký xét tuyển</option>
                                            <option value="3">Đã đóng lệ phí</option>
                                            <option value="4">Đã kiểm tra hồ sơ</option>
                                            <option value="5">Đủ điều kiện xét tuyển</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 col-lg-4">
                                <div class="form-group row" style="margin-bottom: 3px">
                                     <label for="sta_reg_active" class="col-sm-6 col-form-label" style="padding-bottom: 0px;font-weight:normal">Trạng thái xét tuyển:</label>
                                     <div class="col-sm-6" style="text-align: left">
                                         <select class="form-control" id="sta_reg_go" style="width: 100%;">
                                             <option value="0">Chọn trạng thái</option>
                                             <option value="1">Chưa chạy xét tuyển</option>
                                             <option value="2">Xét tuyển với điểm chuẩn </option>
                                         </select>
                                     </div>
                                 </div>
                             </div>

                            <div class="col-12 col-md-7 col-lg-4">

                            </div>
                            <div class="col-12 col-md-12 col-lg-12" id = "add_barChart">

                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</html>

<script src="/admin/js/go/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js" integrity="sha256-IMCPPZxtLvdt9tam8RJ8ABMzn+Mq3SQiInbDmMYwjDg=" crossorigin="anonymous"></script>

<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>



