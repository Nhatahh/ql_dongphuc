<section class="content control-sidebar-slide-open">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-3 col-lg-3">
                <div class="card card-navy card-outline" style=" min-height: 630px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Thêm chức năng</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                        <div class="row">
                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="name" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chức năng:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name = "name" class="font_fix form-control menus "  id="name" style="height:28px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="parent_id" class="col-sm-4 col-form-label" style="padding-bottom: 0px">CN gốc:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name = "parent_id" id="parent_id" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="link" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Link:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name = "link" id = 'link' class="form-control menus" style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="link" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mô tả:</label>
                                    <div class="col-sm-8">
                                        <textarea rows="2" type="text" id="content" name="content" class="form-control menus"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="link" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Icon:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name = "fa_icon" id = 'fa_icon' class="form-control menus"  style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12  col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="link" class="col-sm-4 col-form-label" style="padding-bottom: 0px" >Thứ tự:</label>
                                    <div class="col-sm-8">
                                        <input type="number"name = "number" id = 'number' class="form-control menus"  style="height:28px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group row" style="margin-bottom: 3px">
                                    <label for="active" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Kích hoạt:</label>
                                    <div class="col-sm-8">
                                        <input type="checkbox" id="active" name="active" checked="" class="validate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <button type="button"  onclick="freshMenu()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <button type="button" id ='addMenu'  onclick="addMenu()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Thêm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ccol-12 col-md-9 col-lg-9">
                <div class="card card-navy card-outline" style="min-height: 630px" >
                    <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">Danh sách chức năng</div>
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 3px" id = "remove_load_go_mark" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body table-responsive p-0" style="margin-top: 3px" id = "remove_loadMenu">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <div class = "modal" id = "formactive">
            <div style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%;">
                <div class="row">
                    <div class="col-md-2 col-12">
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="card card-navy card-outline" style="width:auto; height:auto;0 solid rgba(0,0,0,.125); padding: 2px;background-color:#fff; margin-top: 20%">
                            <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                                <div class="row">
                                    <div class="col-md-11 col-lg-11 col-11">
                                        <span  class="">Cập nhật chức năng</span>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-1">
                                        <span  class="float-right" style="margin-right: 10px"><i onclick="modal_close_menu()" id = 'modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 3px">
                                <form id="editForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="name" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Chức năng:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name = "e_name" id = 'e_name' value="{{old('e_name')}}" class="validate form-control" style="height:28px">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p class="error" id="v_e_name" ></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="parent_id" class="col-sm-4 col-form-label" style="padding-bottom: 0px">CN gốc:</label>
                                                <div class="col-sm-8">
                                                    <select lass="form-control validate"  data-select2-id="1" tabindex="-1" aria-hidden="true" name = "e_parent_id" id="e_parent_id">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id = "v_e_parent_id" class="error"></p>
                                                </sup>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="link" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Link:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name = "e_link" id = 'e_link' value="{{old('e_link')}}" class="form-control validate"style="height:28px">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id = "v_e_link" class="error"></p>
                                                </sup>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_content" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Mô tả:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name = "e_content" id = 'e_content' value="{{old('e_content')}}" class="form-control validate"style="height:28px">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id='v_e_content' class="error"></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_icon" class="col-sm-4 col-form-label" style="padding-bottom: 0px">Icon:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name = "e_icon" id = 'e_icon' value="{{old('e_fa_icon')}}" class="form-control validate"style="height:28px">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id='v_e_icon' class="error"></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_number" class="col-sm-6 col-form-label" style="padding-bottom: 0px" >Thứ tự:</label>
                                                <div class="col-sm-6">
                                                    <input type="number" name = "e_number" id = 'e_number' value="{{old('e_number')}}" class="form-control validate" style="height:28px">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <sup>
                                                    <p id = "v_e_number" class="error"></p>
                                                </sup>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6">
                                            <div class="form-group row" style="margin-bottom: 3px">
                                                <label for="e_active" class="col-sm-8 col-form-label" style="padding-bottom: 0px">Kích hoạt:</label>
                                                <div class="col-sm-4">
                                                    <input type="checkbox" id="e_active" name="e_active" checked="" class="validate">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;"></div>
                                            <div class="card-body" style="padding-top: 3px; padding-bottom:0px">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                    </div>
                                                    <div class="col-md-2 col-6">

                                                        <button type="button" id ='editMenu' class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Cập nhật</button>
                                                    </div>
                                                    <div class="col-md-2 col-6">
                                                        <button type="button" id ='clearEditMenu'   class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;&nbsp;Làm mới</button>
                                                    </div>
                                                    <div class="col-md-2 col-6">
                                                        <button type="button" id ='destroyEditMenu'   class="btn btn-block btn-primary btn-xs"><i class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;&nbsp;Hủy</button>
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

        </div>
    </div>
</section>




    <script src="/admin/js/menus/control.js"></script>

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


{{-- @endsection --}}

