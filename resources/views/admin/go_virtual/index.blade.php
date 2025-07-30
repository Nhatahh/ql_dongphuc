
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
                                    <label for="go_virtual_batch_ts" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chọn đợt tuyển sinh:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="go_virtual_batch_ts" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group row" style="margin-bottom: 3px">
                                     <label for="go_virtual_batch" class="col-sm-2 col-form-label" style="padding-bottom: 0px">Đợt lọc ảo:</label>
                                     <div class="col-sm-10">
                                         <select class="form-control" id="go_virtual_batch" style="width: 100%;">

                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-1 col-6">
                                <button type="button"  id = "go_virtual_search" onclick="go_virtual_load()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tìm kiếm</button>
                            </div>

                            <div class="col-md-6 col-12">

                            </div>

                            <div class="col-md-12 col-12">
                                <div class="row">
                                    <div class="col-md-12 col-12" id ="remove_go_virtual_load">
                                        <div style="border: 2px solid  #dee2e6">
                                            <table class="table table-bordered text-nowrap" style="min-height: 550px" id="go_virtual_ex">
                                                <thead>
                                                    <tr>
                                                        <th style="vertical-align:middle" rowspan="3">STT</th>
                                                        <th style="vertical-align:middle" rowspan="3">Ngành xét tuyển</th>

                                                        <th colspan="10" style="vertical-align: middle">Tổng</th>

                                                        <th colspan="10">Học bạ THPT</th>

                                                        <th colspan="5" rowspan="2" style="vertical-align:middle">Trung học phổ thông</th>
                                                        <th colspan="10">Đánh giá năng lực</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2" style="vertical-align: middle">CT</th>
                                                        <th  rowspan="2" style="vertical-align: middle">DK</th>

                                                        <th rowspan="2" style="vertical-align: middle">SL</th>
                                                        <th rowspan="2" style="vertical-align: middle">TL</th>

                                                        <th  colspan="2" style="vertical-align: middle">NV1</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV2</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV3</th>

                                                        {{-- <th  colspan="2" style="vertical-align: middle">Trường</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV1</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV2</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV3</th>



                                                        <th  colspan="2" style="vertical-align: middle">Trường</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV1</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV2</th>
                                                        <th  colspan="2" style="vertical-align: middle">NV3</th>
 --}}

                                                        <th rowspan="2" style="vertical-align: middle">CT</th>
                                                        <th colspan="3">Trúng tuyển sớm</th>
                                                        <th colspan="4">Đăng ký mới</th>
                                                        <th rowspan="2" style="vertical-align: middle">Tổng</th>
                                                        <th rowspan="2" style="vertical-align: middle">TL</th>


                                                        <th rowspan="2" style="vertical-align: middle">CT</th>
                                                        <th colspan="3">Trúng tuyển sớm</th>
                                                        <th colspan="4">Đăng ký mới</th>
                                                        <th rowspan="2" style="vertical-align: middle">Tổng</th>
                                                        <th rowspan="2" style="vertical-align: middle">TL</th>
                                                    </tr>
                                                    <tr>


                                                        <th>TTS</th>
                                                        <th>Mới</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th>

                                                        {{-- <th>SL</th>
                                                        <th>TL</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th> --}}

                                                        {{-- <th>SL</th>
                                                        <th>TL</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th>
                                                        <th>TTS</th>
                                                        <th>Mới</th> --}}



                                                        <th>SL</th>
                                                        <th>TT</th>
                                                        <th>TL</th>

                                                        <th>ĐK</th>
                                                        <th>DC</th>
                                                        <th>TT</th>
                                                        <th>TL</th>



                                                        <th>CT</th>
                                                        <th>ĐK</th>
                                                        <th>DC</th>
                                                        <th>TT</th>
                                                        <th>TL</th>

                                                        <th>SL</th>
                                                        <th>TT</th>
                                                        <th>TL</th>

                                                        <th>ĐK</th>
                                                        <th>DC</th>
                                                        <th>TT</th>
                                                        <th>TL</th>
                                                    </tr>
                                                </thead>
                                                <tbody  id = "go_virtual_load">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="card-header" style="padding-bottom: 5px;padding-top: 4px;font-weight: bold;"></div>
                                        <div class="card-body" style="padding-top: 3px; padding-bottom:10px">
                                            <div class="row">
                                                <div class="col-md-6 col-6">
                                                    <div class="row">
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"  id = "go_virtual_batch_clear" onclick = "go_virtual_batch_clear()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"  id = "go_virtual_batch_pass" onclick = "go_virtual_batch_pass()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-step-forward"></i>&nbsp;&nbsp;&nbsp;Lọc ảo</button>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"   id = "go_virtual_batch_sta"   onclick = "go_virtual_batch_sta('xlsx')" class="btn btn-block btn-primary btn-xs"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Thống kê</button>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"   id = "go_virtual_batch_list"   onclick = "go_virtual_batch_list()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;DS Trường</button>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"  id = "go_virtual_batch_clear" onclick = "go_virtual_batch_block()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-key"></i>&nbsp;&nbsp;&nbsp;Khóa</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-6">
                                                    <div class="row">
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"  id = "go_virtual_batch_pass" onclick = "go_virtual_batch_list_bo()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;DS Bộ</button>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"   id = "go_virtual_batch_ip_list_nhom"   onclick = "go_virtual_batch_ip_list_nhom()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;DS Nhóm</button>
                                                            <form id="submit_go_virtual_batch_ip_list_nhom">
                                                                <input type="text" name="import_go_virtual_batch_ip_list_id_batch_ts" id="import_go_virtual_batch_ip_list_id_batch_ts" value=""/>
                                                                <input type="text" name="import_go_virtual_batch_ip_list_id_batch" id="import_go_virtual_batch_ip_list_id_batch" value=""/>
                                                                <input type="file" name="import_go_virtual_batch_ip_list_nhom" id="import_go_virtual_batch_ip_list_nhom"/>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"   id = "go_virtual_batch_ip_list_bo"   onclick = "go_virtual_batch_ip_list_bo()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;Tải KQ Bộ</button>
                                                            <form id="submit_go_virtual_batch_ip_list_bo">
                                                                <input type="text" name="go_virtual_batch_ip_list_bo_id_batch_ts" id="go_virtual_batch_ip_list_bo_id_batch_ts" value="2"/>
                                                                <input type="text" name="go_virtual_batch_ip_list_bo_id_batch" id="go_virtual_batch_ip_list_bo_id_batch" value="29"/>
                                                                <input type="file" name="import_go_virtual_batch_ip_list_bo" id="import_go_virtual_batch_ip_list_bo"/>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"  id = "go_virtual_batch_list_bo_block" onclick = "go_virtual_batch_list_bo_block()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-key"></i>&nbsp;&nbsp;&nbsp;Khóa đợt</button>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"  id = "go_virtual_batch_list_bo_internet" onclick = "go_virtual_batch_list_bo_internet()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-globe"></i>&nbsp;&nbsp;&nbsp;Công bố</button>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <button type="button"  id = "go_virtual_batch_list_bo_new_dowload" onclick = "go_virtual_batch_list_bo_new_dowload(1)" class="btn btn-block btn-primary btn-xs"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;In GBTT</button>
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
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div>
                <div class="card card-navy card-outline">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Đối sánh Trường - Nhóm - Bộ</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" >
                        <div class="col-md-12 col-12 go_setup_method2">
                            <div class="row">
                                <div class="col-md-12 col-12" id ="">Đang cập nhật
                                    <div style="border: 2px solid  #dee2e6">
                                        <div class="card-header" style="padding-bottom: 5px;padding-top: 4px;font-weight: bold;"></div>
                                        <div class="card-body" style="padding-top: 3px; padding-bottom:10px">
                                            <div class="row">
                                                <div class="col-md-3 col-6">
                                                    <div class="row">
                                                        <div class="col-md-6 col-6">
                                                            {{-- <button type="button"  id = "go_virtual_batch_clear" onclick = "go_virtual_batch_clear()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-broom"></i>&nbsp;&nbsp;&nbsp;Làm mới</button> --}}
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            {{-- <button type="button"  id = "go_virtual_batch_pass" onclick = "go_virtual_batch_pass()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-step-forward"></i>&nbsp;&nbsp;&nbsp;Lọc ảo</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="row">
                                                        <div class="col-md-6 col-6">
                                                            {{-- <button type="button"   id = "go_virtual_batch_sta"   onclick = "go_virtual_batch_sta('xlsx')" class="btn btn-block btn-primary btn-xs"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Thống kê</button> --}}
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            {{-- <button type="button"   id = "go_virtual_batch_list"   onclick = "go_virtual_batch_list()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Danh sách (TT)</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="row">
                                                        <div class="col-md-6 col-6">
                                                            {{-- <button type="button"  id = "go_virtual_batch_clear" onclick = "go_virtual_batch_block()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-key"></i>&nbsp;&nbsp;&nbsp;Khóa</button> --}}
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            {{-- <button type="button"  id = "go_virtual_batch_pass" onclick = "go_virtual_batch_list_bo()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Danh sách (UP)</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="row">
                                                        <div class="col-md-6 col-6">
                                                            {{-- <button type="button"   id = "go_virtual_batch_ip_list_nhom"   onclick = "go_virtual_batch_ip_list_nhom()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;Tải KQ Nhóm</button>
                                                            <form id="submit_go_virtual_batch_ip_list_nhom">
                                                                <input type="text" name="import_go_virtual_batch_ip_list_id_batch_ts" id="import_go_virtual_batch_ip_list_id_batch_ts" value=""/>
                                                                <input type="text" name="import_go_virtual_batch_ip_list_id_batch" id="import_go_virtual_batch_ip_list_id_batch" value=""/>
                                                                <input type="file" name="import_go_virtual_batch_ip_list_nhom" id="import_go_virtual_batch_ip_list_nhom"/>
                                                            </form> --}}
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <button type="button"   id = ""   onclick = "" class="btn btn-block btn-primary btn-xs"><i class="fa fa-table"></i>&nbsp;&nbsp;&nbsp;Xuất</button>
                                                            {{-- <button type="button"   id = "go_virtual_batch_ip_list_bo"   onclick = "go_virtual_batch_ip_list_bo()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;Tải KQ Bộ</button>
                                                            <form id="submit_go_virtual_batch_ip_list_bo">
                                                                <input type="text" name="go_virtual_batch_ip_list_bo_id_batch_ts" id="go_virtual_batch_ip_list_bo_id_batch_ts" value="2"/>
                                                                <input type="text" name="go_virtual_batch_ip_list_bo_id_batch" id="go_virtual_batch_ip_list_bo_id_batch" value="29"/>
                                                                <input type="file" name="import_go_virtual_batch_ip_list_bo" id="import_go_virtual_batch_ip_list_bo"/>
                                                            </form> --}}
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
        </div>
    </div>
</div>


<div class = "modal" id="loadding_go_virtual">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;">&nbsp;&nbsp;
            <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto">
            <span style="color:white"><strong id = "loadding_go_virtual_mess"></strong></span>
        </div>
    </div>
</div>

<div class = "modal" id="loadding_go_virtual_show">
    <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);height: 100%;">
        <div   id="go_virtual_chart_major" >&nbsp;&nbsp;
        {{-- <div  style = "position: absolute; right: 0; left: 0; top: 0; bottom: 0; margin: auto; witdh:40px;height:40px;" id="go_virtual_chart_major" >&nbsp;&nbsp; --}}





            {{-- <img src = "https://xettuyentest.ctuet.edu.vn/img/Loading.gif" width="40px" height="auto" > --}}
            {{-- <span style="color:white"><strong>Hệ thống đang lọc ảo ..., Có thể mất vài phút!!!</strong></span> --}}
        </div>
    </div>
</div>


</html>

<script src="/admin/js/go_virtual/control.js"></script>
<script src="/exceljs/control.js"></script>

<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/chart/chart.js"></script>
<script src="/chart/config.js"></script>


<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>



