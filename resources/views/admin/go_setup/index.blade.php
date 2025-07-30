
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <div>
                <div class="card card-navy card-outline" style="min-heigh: 450px; heigh: 450px" id="left_go_setup">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Cài đặt chỉ tiêu, ngưỡng ảo</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="go_setup_batch" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chọn đợt tuyển sinh:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="go_setup_batch" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <button type="button"  id = "go_setup_search" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                            </div>

                            <div class="col-md-6 col-12">

                            </div>
                            <div class="col-md-12 col-12" id ="">
                                <div id = "remove_load_go_setup" style="min-height: 500px;border: 2px solid  #dee2e6">
                                    {{-- <table class="table table-bordered text-nowrap" style="min-height: 550px" id = "load_go_setup"> --}}
                                        {{-- <thead>
                                            <tr>
                                                <th style="vertical-align:middle" rowspan="2">STT</th>
                                                <th style="vertical-align:middle" rowspan="2">Ngành xét tuyển</th>
                                                <th style="vertical-align:middle" rowspan="2">Phương thức</th>
                                                <th style="vertical-align:middle">Chỉ tiêu</th>
                                                <th style="vertical-align:middle">Ngưỡng ảo</th>
                                            </tr>
                                        </thead>
                                        <tbody  id = "go_load">

                                        </tbody> --}}
                                    {{-- </table> --}}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="card-header" style="padding-bottom: 5px;padding-top: 4px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:10px">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <button type="button"  id = "go_setup_save" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Lưu</button>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <button type="button"  id = "go_setup_export" class="btn btn-block btn-primary btn-xs"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Xuất</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <canvas id="barReg" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas> --}}




                    </div>
                </div>
            </div>
        </div>



        <div class="col-12 col-md-6 col-lg-6">
            <div>
                <div class="card card-navy card-outline" style="min-heigh: 600px; heigh: 600px" id="right_go_setup">
                    <div>
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Cấu hình lấy danh sách trúng tuyển</div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                            <div class="row">
                                <div class="col-md-12 col-12" style="margin-bottom: -18px">
                                    <div class="form-group row" style="margin-bottom: 3px;">
                                        {{-- <label for="sex_user_check" class="col-sm-6 col-form-label" style="padding-bottom: 0px;font-weight:normal">Giới tính:</label> --}}
                                        <div class="col-sm-12">
                                            <div class="input-group  input-group-sm mb-3">
                                                <div class="input-group-prepend">
                                                    <input class="go_setup_method1" type="radio" id = 'go_setup_1' id-data = "1" name="go_setup_radio" style="margin-top: 2px">
                                                    <div class="" style="padding-top: 7px;">
                                                        <span class="" >&nbsp;&nbsp;&nbsp; Lấy ưu tiên theo điểm. Thí sinh trúng tuyển nhiều ngành thì lấy nguyện vọng cao nhất</span>
                                                    </div>
                                                </div>
                                                <div class="input-group-prepend" >
                                                    <input class="go_setup_method1" type="radio" id = 'go_setup_2' id-data = "2" name="go_setup_radio" style="margin-top: -5px;">
                                                    <div class="" style="padding-top: 0px;">
                                                        <span class="" >&nbsp;&nbsp;&nbsp; Lấy ưu tiên theo NV. Lấy NV1 xét trước, nếu còn chỉ tiêu xét NV2 ...</span>
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
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <div>
                <div class="card card-navy card-outline" style="min-heigh: 600px; height: 600px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 20px;font-weight: bold;">Biểu đồ tương quan chỉ tiêu và ngưỡng ảo theo ngành</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        <div class="col-12 col-md-12 col-lg-12" id = "add_barChart_go_setup">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-12 col-md-12 col-lg-12">
            <div>
                <div class="card card-navy card-outline" style="min-heigh: 600px; heigh: 600px">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Cấu hình email</div>
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <span><strong>Tiêu đề:&nbsp;</strong></span><input type="" id="title_email_go_setup" class="form-control form-control-sm" placeholder="" style="width: 100%">
                                </div>
                                <div class="col-md-12 col-12">
                                    <span><strong>Nội dung:&nbsp;</strong></span><textarea id="email_go_setup" style="display: block;">
                                    </textarea>
                                </div>
                                <div class="col-md-4 col-12">
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="card-header" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;"></div>
                                    <div class="card-body" style="padding-top: 3px; padding-bottom:10px">
                                        <div class="row">
                                            <div class="col-md-4 col-6">
                                            </div>
                                            <div class="col-md-6 col-6">

                                            </div>
                                            <div class="col-md-2 col-6">
                                                <button type="button"  id = "go_setup_save_email" class="btn btn-block btn-primary btn-xs"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}



    </div>
</div>
</html>

<script src="/admin/js/go_setup/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>

<script src="/chart/chart.js"></script>
<script src="/chart/config.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js" integrity="sha256-IMCPPZxtLvdt9tam8RJ8ABMzn+Mq3SQiInbDmMYwjDg=" crossorigin="anonymous"></script> --}}

<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- Summernote -->
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>

