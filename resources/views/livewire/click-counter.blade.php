
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Đợt TS:</label>
                            <div class="col-sm-12">
                                <select wire:model="iddotts" class=""  id="xnnh_nganh" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                        {{-- <option value="-1">Chọn đợt xét tuyển</option> --}}
                                    <option value="3">Xét tuyển chung 2024 - Bổ sung đợt 1(27/08/2024)</option>
                                    <option value="2">Xét tuyển chung 2024 - Đợt 1 (23/08/2024)</option>
                                    <option value="1">Xét tuyển sớm 2024(01- 08/07/2024)</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group row" style="margin-bottom: 0px">
                            <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Ngành/Chuyên ngành:</label>
                            <div class="col-sm-12">
                                <select wire:model="iddotxt" class=""  id="xnnh_nganh" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">

                                    <option value="5"  selected = "selected">Xét tuyển chung 2024 (Lọc ảo lần 6) (17/08/2024)</option>
                                    <option value="4">Xét tuyển sớm 2024 - Đợt 4 (08/07/2024)</option>
                                    <option value="3">Xét tuyển sớm 2024 - Đợt 3 (08/07/2024)</option>
                                    <option value="2">Xét tuyển sớm 2024 - Đợt 2 (05/07/2024)</option>
                                    <option value="1">Xét tuyển sớm 2024 - Đợt 1 (01/07/2024)</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Chuyên ngành:</label>
                            <div class="col-sm-12">
                                <select wire:model="idchuyennganh" class=""  id="xnnh_nganh" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                        <option value="-1">Chọn chuyên ngành</option>
                                        @foreach ($nganh as $row )
                                            <option value="{{$row->id}}">{{$row->text}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Năm tốt nghiệp:</label>
                            <div class="col-sm-12">
                                <select wire:model="namtotnghiep" class=""  id="xnnh_nganh" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                    <option value="-1">Chọn năm tốt nghiệp</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="daxem" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Đã xem:</label>
                            <div class="col-sm-12">
                                <select wire:model="daxem" class=""  id="daxem" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                    <option value="-1">Chọn Trạng thái</option>
                                    <option value="1">Đã xem</option>
                                    <option value="0">Chưa xem</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">XN Cổng Trường:</label>
                            <div class="col-sm-12">
                                <select wire:model="xacnhan" class=""  id="xacnhan" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                    <option value="-1">Chọn Trạng thái</option>
                                    <option value="0">Chưa xác nhận</option>
                                    <option value="1">Xác nhận</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">XN Cổng Bộ:</label>
                            <div class="col-sm-12">
                                <select wire:model="xacnhanbo" class=""  id="xacnhan" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                    <option value="-1">Chọn Trạng thái</option>
                                    <option value="0">Chưa xác nhận</option>
                                    <option value="1">Xác nhận</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="daxem" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Nhập học:</label>
                            <div class="col-sm-12">
                                <select wire:model="nhaphoc" class=""  id="nhaphoc" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                    <option value="-1">Chọn Trạng thái</option>
                                    <option value="1">Nhập học</option>
                                    <option value="0">Chưa nhập học</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Điều tra:</label>
                            <div class="col-sm-12">
                                <select wire:model="trangthaidieutra" class=""  id="trangthaidieutra" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                                    <option value="-1">Chọn Trạng thái</option>
                                    <option value="1">Xác nhận</option>
                                    <option value="2">Không xác nhận</option>
                                    <option value="3">Phân vân</option>
                                    <option value="4">Không liên lạc được</option>
                                    <option value="5">Chuyển ngành</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">CMND/CCCD:</label>
                            <div class="col-sm-12">
                                <input wire:model="cccd" type="text" class="form-control" id="" value = "" style="padding-top: 0px;height:28px;width:100%">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Họ tên thí sinh</label>
                            <div class="col-sm-12">
                                <input wire:model="hoten" type="text" class="form-control" id="" value = "" style="padding-top: 0px;height:28px;width:100%">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 col-lg-2">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: 800;">Tổng Điều tra:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="" value = "{{$soluong}}" style="padding-top: 0px;height:28px;width:100%;background-color:inherit;border:none" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 col-lg-3">
                        <div class="form-group" style="margin-bottom: 0px">
                            <label for="" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight:800;">Số lượng:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="" value = "{{count($trungtuyen)}}" style="padding-top: 0px;height:28px;width:100%;background-color:inherit;border:none" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach ( $trungtuyen as $row )
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="item-thisinh">
                                <div class="item-header">
                                    <div class="item-row1">
                                        <div class="maphieu">
                                            <span></span>
                                            <strong>{{$row->sothutu}}. {{$row->hoten}}</strong>
                                        </div>
                                        <div class="maphieu">
                                            <span>CMND:</span>
                                            <strong>{{$row->cccd}}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-bottom"></div>
                                <div class="item-body">
                                    <div class = 'thongtin'>
                                        <div class = "left">Trạng thái: </div>
                                        <div style = "color:#11a2f3">Trúng tuyển chính thức</div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">Xét tuyển sớm: </div>
                                        <div style = "color:#11a2f3">
                                            @if ($row->ttsom == 1)
                                                Đủ điều kiện
                                            @else

                                            @endif
                                        </div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">Ngành: </div>
                                        <div class = "right">{{$row->tenchuyennganh}}</div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">Điểm xét tuyển: </div>
                                        <div class = "right">{{$row->diemxettuyen}}</div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">XN Cổng Bộ:</div>
                                        <div class = "right">
                                            @if ($row->xacnhanbo == 1)
                                                <span style="color:#007bff;font-weight:bold">Đã xác nhận</span>
                                            @else
                                                <span style="color:red;font-weight:bold">Chưa xác nhận</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">Nhập học:</div>
                                        <div class = "right">
                                            @if ($row->nhaphoc == 1)
                                                <span style="color:#007bff;font-weight:bold">Đã nhập học</span>
                                            @else
                                                <span style="color:red;font-weight:bold">Chưa nhập học</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">XN Cổng Trường</div>
                                        <div class = "right">
                                            @if ($row->daxem == 1)
                                                <span style="color:#007bff;font-weight:bold">Đã xem</span>  -
                                            @else
                                                <span style="color:red;font-weight:bold">Chưa xem</span>  -
                                            @endif

                                            @if ($row->xacnhan == 1)
                                                <span style="color:#007bff;font-weight:bold">Đã xác nhận</span>
                                            @else
                                                <span style="color:red;font-weight:bold">Chưa xác nhận</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class = 'thongtin'>
                                        <div class = "left">Email:</div>
                                        <div class = "right">{{$row->email}}</div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">Năm tốt nghiệp: </div>
                                        <div class = "right"><span>{{$row->namtotnghiep}}</span></div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">Điện thoại</div>
                                        <div class = "right"><i style="color: #007bff" dienthoai = "{{$row->dienthoai}}"  class="callButton fa-solid fa-phone"></i>&nbsp;&nbsp;<span style="color:#007bff">{{$row->dienthoai}}</span></div>
                                    </div>
                                    <div class = 'thongtin'>
                                        <div class = "left">ĐT Phụ huynh:</div>
                                        <div class = "right"><span style="color:#007bff">{{$row->dienthoai_phu}}</span></div>
                                    </div>

                                    <div class="item-bottom"></div>
                                    <div class = 'thongtin'>
                                        <div class = "left">Trạng thái điều tra:</div>
                                        <div class = "right"></div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class = 'row'>
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <div class="checkbox-container" style="padding: 0;margin-top:0px">
                                                    @if ($row->trangthaidieutra == 1)
                                                        <input type="checkbox" checked = "checked" onclick="dieutraxacnhan(1,{{$row->id}})" id_trangthai = "1" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_1_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @else
                                                        <input type="checkbox" onclick="dieutraxacnhan(1,{{$row->id}})" id_trangthai = "1" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_1_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @endif
                                                    <label for="dieutraxacnhan_1_{{$row->id}}" class="">Xác nhận</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <div class="checkbox-container" style="padding: 0;margin-top:0px">
                                                    @if ($row->trangthaidieutra == 2)
                                                        <input checked = "checked" type="checkbox" onclick="dieutraxacnhan(2,{{$row->id}})" id_trangthai = "2" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_2_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @else
                                                        <input type="checkbox"  onclick="dieutraxacnhan(2,{{$row->id}})" id_trangthai = "2" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_2_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @endif
                                                    <label for="dieutraxacnhan_2_{{$row->id}}" class="">Không xác nhận</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <div class="checkbox-container" style="padding: 0;margin-top:0px">
                                                    @if ($row->trangthaidieutra == 3)
                                                        <input type="checkbox" onclick="dieutraxacnhan(3,{{$row->id}})" checked = "checked"  id_trangthai = "3" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_3_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @else
                                                        <input type="checkbox" onclick="dieutraxacnhan(3,{{$row->id}})" id_trangthai = "3" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_3_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @endif
                                                    <label for="dieutraxacnhan_3_{{$row->id}}" class="">Phân vân</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <div class="checkbox-container" style="padding: 0;margin-top:0px">
                                                    @if ($row->trangthaidieutra == 4)
                                                        <input type="checkbox" onclick="dieutraxacnhan(4,{{$row->id}})" checked = "checked" id_trangthai = "4" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_4_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @else
                                                        <input type="checkbox"  onclick="dieutraxacnhan(4,{{$row->id}})" id_trangthai = "4" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_4_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @endif
                                                    <label for="dieutraxacnhan_4_{{$row->id}}" class="">Không liên lạc được</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <div class="checkbox-container" style="padding: 0;margin-top:0px">
                                                    @if ($row->trangthaidieutra == 5)
                                                        <input type="checkbox" onclick="dieutraxacnhan(5,{{$row->id}})" checked = "checked" id_trangthai = "5" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_5_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @else
                                                        <input type="checkbox"  onclick="dieutraxacnhan(5,{{$row->id}})" id_trangthai = "5" id_trungtuyen = "{{$row->id}}" id="dieutraxacnhan_5_{{$row->id}}" class="dieutraxacnhan{{$row->id}} dieutraxacnhan">
                                                    @endif
                                                    <label for="dieutraxacnhan_5_{{$row->id}}" class="">Chuyển ngành</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom: 0px">
                                        <label for="" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Ghi chú:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control capnhatghichuxnnh" onchange="capnhatghichuxnnh({{$row->id}})" id_trungtuyen = "{{$row->id}}" id="capnhatghichuxnnh{{$row->id}}"  value = '{{$row->ghichu_xnnh}}' style="padding-top: 0px;height:28px;width:100%">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

