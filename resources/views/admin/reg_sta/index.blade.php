
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-navy card-outline">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thống kê cơ bản</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        <canvas id="barReg" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-navy card-outline">
                <div>
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Biểu đồ số lượng thí sinh đăng ký</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        <div class="row">
                            <div class="col-12 col-md-5 col-lg-4">
                                <div class="form-group row" style="margin-bottom: 3px">
                                     <label for="sta_reg_active" class="col-sm-4 col-form-label" style="padding-bottom: 0px;font-weight:normal">Đợt xét tuyển:</label>
                                     <div class="col-sm-8" style="text-align: left">
                                         <select class="form-control" id="sta_reg_batch" style="width: 100%;">
                                             {{-- <option value="0">Chọn trạng thái</option> --}}
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
                                            {{-- <option value="0">Chọn trạng thái</option> --}}
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
                                             {{-- <option value="0">Chọn trạng thái</option> --}}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</html>

<script src="/admin/js/reg_sta/control.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js" integrity="sha256-IMCPPZxtLvdt9tam8RJ8ABMzn+Mq3SQiInbDmMYwjDg=" crossorigin="anonymous"></script>

<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
{{-- <script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script> --}}



