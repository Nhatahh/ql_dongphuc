    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card card-navy card-outline" style = "min-height: 600px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Thêm năm tuyển sinh
                        {{-- <a style="margin-left: 10px;font-weight: bold;">Thêm năm xét tuyển</a> --}}
                    </div>

                    <div class="card-body">

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Năm tuyển sinh:</button>
                            </div>
                            <input type="text" class="form-control">
                        </div>

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Chủ tịch HĐTS:</button>
                            </div>
                            <input type="text" name = 'president' class="form-control">
                            <i class="fa fa-paperclip" id = 'icon_file_council' onclick= "file_council()" aria-hidden="true"></i>
                        </div>
                        <form id="f_file_council" enctype="multipart/form-data" style="display: none;">
                            <input name="file_council" type="file" id="file_council" accept=".pdf">
                        </form>

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Trưởng ban thư ký:</button>
                            </div>
                            <input type="text" name = 'chief_amanuensis' class="form-control">
                            <i class="fa fa-paperclip" id = 'icon_chief_amanuensis' onclick= "file_amanuensis()" aria-hidden="true"></i>
                        </div>
                        <form id="f_file_amanuensis" enctype="multipart/form-data" style="display: none;">
                            <input name="file_amanuensis" type="file" id="file_amanuensis" accept=".pdf">
                        </form>

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Quy chế Bộ:</button>
                            </div>
                            <input type="text" name = 'regulation' class="form-control">
                            <i class="fa fa-paperclip" id = 'icon_regulation' onclick= "file_regulation()" aria-hidden="true"></i>
                        </div>
                        <form id="f_file_regulation" enctype="multipart/form-data" style="display: none;">
                            <input name="file_regulation" type="file" id="file_regulation" accept=".pdf">
                        </form>

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Quy chế Trường:</button>
                            </div>
                            <input type="text" name = 'regulation2' class="form-control">
                            <i class="fa fa-paperclip" id = 'icon_regulation2' onclick= "file_regulation2()" aria-hidden="true"></i>
                        </div>
                        <form id="f_file_regulation2" enctype="multipart/form-data" style="display: none;">
                            <input name="ffile_regulation2" type="file" id="file_regulation2" accept=".pdf">
                        </form>

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Kế hoạch Bộ:</button>
                            </div>
                            <input type="text" name = 'plan1' class="form-control">
                            <i class="fa fa-paperclip" id = 'icon_plan1' onclick= "file_plan1()" aria-hidden="true"></i>
                        </div>
                        <form id="f_file_plan1" enctype="multipart/form-data" style="display: none;">
                            <input name="file_plan1" type="file" id="file_plan1" accept=".pdf">
                        </form>

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Kế hoạch Trường:</button>
                            </div>
                            <input type="text" name = 'plan2' class="form-control">
                            <i class="fa fa-paperclip" id = 'icon_plan2' onclick= "file_plan2()" aria-hidden="true"></i>
                        </div>
                        <form id="f_file_plan2" enctype="multipart/form-data" style="display: none;">
                            <input name="file_plan2" type="file" id="file_plan2" accept=".pdf">
                        </form>

                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <button type="button" class="btn">Ghi chú:</button>
                            </div>
                            <textarea type="text" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card card-gray-dark card-outline" style = "min-height: 600px">
                    <div class="card-header" style="padding: 0;margin-left: 10px;font-weight: bold;">Danh sách năm tuyển sinh
                        {{-- <a style="margin-left: 10px;font-weight: bold;">Thêm năm xét tuyển</a> --}}
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Special title treatment</h6>

                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

        </div>







    </div>

    <script src="/admin/js/years/control.js"></script>
    <script src="/template/admin/plugins/jquery/jquery.min.js"></script>


    {{-- <script src="/template/admin/jqueryupload/upload.js"></script> --}}
{{-- @endsection --}}

