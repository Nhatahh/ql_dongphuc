<div class="item-hoso">
    <div class="col-12 col-md-12 col-lg-12 card-header" style="padding-bottom: 5px;padding-left: 0px;">
        <div class="form-group row" style="margin-bottom: 0px">
            <label class="col-12 col-sm-2 col-md-2 col-lg-1  col-form-label"
                style="padding-top: 0px; padding-bottom: 0px;font-weight: bold;">Đợt nhập</label>
            <div class="col-12 col-sm-8 col-md-6 col-lg-1" style = "padding-bottom: 5px;">
                <select wire:model="id_dotnhap" class="" id="id_dotnhap"
                    style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem; ">
                    <option value="-1">Chọn đợt nhập</option>

                    @foreach($dotnhaps as $dotnhap)
                        <option value="{{$dotnhap->id}}">{{$dotnhap->dotnhap }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-1">
                <button type="button" id="" onclick="btt_show_model_nhapdongphuc()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-circle-plus"></i>&nbsp;&nbsp;&nbsp;Nhập ĐP</button>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-1" style="padding-bottom: 5px;">
                <button type="button" id="" onclick="bieudo_thongke_nhap()" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;&nbsp;Biểu đồ</button>
            </div>
            <!-- <div class="col-md-2 col-6">
                <button type="button" id="" onclick="btt_xuatexcel_ql_sanphamnhap_mobile()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xuất excel</button>
            </div> -->
            <!-- <div class="col-md-2 col-6">
                <button type="button" id="" onclick="btt_xuatexcel_sanphamnhap()" class="btn btn-block btn-primary btn-xs"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Xuất TK</button>
            </div> -->
        </div>
    </div>

    @if ($trangthai == 1)
        <div class="col-12 col-md-12 col-lg-12 card-body" style="padding: 5px 2px 0px;">

            <div class="col-12 col-md-12 col-lg-12" style="padding-bottom: 5px;">
                <div class="form-group row" style="margin-bottom: 0px">
                    <label for="" class="col-12 col-sm-2 col-md-2 col-lg-1  col-form-label"
                        style="padding-top: 0px; padding-bottom: 0px;font-weight: bold;">Nhà sản xuất</label>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-3">
                        <select wire:model="id_nhasanxuat" class="" id="id_nhasanxuat"
                            style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                            <option value="">Tất cả</option>
                            @foreach($nhasanxuats as $nhasanxuat)
                                <option value="{{$nhasanxuat->id}}">{{$nhasanxuat->nhasanxuat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12" style="padding-bottom: 5px;">
                <div class="form-group row" style="margin-bottom: 0px">
                    <label for="" class="col-12 col-sm-2 col-md-2 col-lg-1  col-form-label"
                        style="padding-top: 0px; padding-bottom: 0px;font-weight: bold;">Loại</label>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-3">
                        <select wire:model="id_loai" class="" id="id_loai"
                            style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                            <option value="">Tất cả</option>
                            @foreach($loais as $loai)
                                <option value="{{$loai->id}}">{{$loai->loai }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12" style="padding-bottom: 5px;">
                <div class="form-group row" style="margin-bottom: 0px">
                    <label for="" class="col-12 col-sm-2 col-md-2 col-lg-1  col-form-label"
                        style="padding-top: 0px; padding-bottom: 0px;font-weight: bold;">Size</label>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-3">
                        <select wire:model="id_size" class="" id="id_size"
                            style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                            <option value="">Tất cả</option>
                            @foreach($sizes as $size)
                                <option value="{{$size->id}}">{{$size->size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12" >
                <button type="button" id="qlnhap_btn_ScanQR"  onclick="Scan_QR('quanlynhap')" class="btn btn-block btn-primary btn-xs qlnhap_ScanQR"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Quét QRcode</button>
            </div>
            
            <div class="row" style="padding: 0px 16px 0px 9px;">
                @if(count($sanphamnhap) > 0)
                    @foreach ($sanphamnhap as $row)
                    <div  style = "margin-left: 5px; " class="col-xl-2 ms-1 item-thisinh">
                        <div class="item-header">
                            <div class="item-row1">
                                <div class="">
                                    <span>Loại:</span>
                                    <strong>{{$row->loai}}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="item-bottom"></div>
                        <div class="item-body">
                            <div class='thongtin'>
                                <div class="left">Mã sản phẩm: </div>
                                <div class="right">{{$row->masp}}</div>
                            </div>
                            <div class='thongtin'>
                                <div class="left">Nhà sản xuất: </div>
                                <div class="right">{{$row->nhasanxuat}}</div>
                            </div>
                            <div class='thongtin'>
                                <div class="left">Size: </div>
                                <div class="right">{{$row->size}}</div>
                            </div>
                            <div class='thongtin'>
                                <div class="left">Ngày nhập </div>
                                <div class="right">{{$row->ngaynhap}}</div>
                            </div>
                            <div class='thongtin'>
                                <div class="left">Người nhập </div>
                                <div class="right">{{$row->dienthoai}}</div>
                            </div>


                            <div class="form-group row" style="margin-bottom: 0px">
                                <label for="" class="col-sm-8 col-8 col-form-label"
                                    style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Số lượng đã nhập:</label>
                                <div class=" right col-sm-4 col-4 ">
                                    <input  type="text"  class="form-control " id="soluongnhap_mobile_{{$row->id}}" id_kiemtra = "{{$row->id}}" id_dot_sanpham = "{{$row->id_dot_sanpham}}" id_sanpham = "{{$row->id_sanpham}}" soluongnhap_old = "{{$row->soluongnhap}}" id_dot = "{{$row->id_dotnhap}}" onchange="capnhat_soluongnhap(event,'{{$row->id}}')"
                                        style=" height:28px;width:100% " value = '{{$row->soluongnhap}}'>
                                </div>
                            </div>

                            <div class="item-bottom"></div>

                            <div class='thongtin'>
                                <div  class="col-8"> </div>
                                <div style="padding-left: 9px;" class="right">
                                    <button  type="button" class="btn btn-block btn-outline-danger btn-sm" id_kiemtra = "{{$row->id}}" id_dot_sanpham = "{{$row->id_dot_sanpham}}" id="deltesanpham_{{$row->id}}" id_sanpham = "{{$row->id_sanpham}}" id_dotnhap = "{{$row->id_dotnhap}}" soluong ="{{$row->soluongnhap}}" onclick="delete_sanphamnhap(event,'{{$row->id}}')"><i class="fa-solid fa-trash"></i>&nbsp;Xóa</button></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style='width:100%; color:red; text-align: center;'>Không tìm thấy sản phẩm</div>
                @endif
            </div>
        </div>
    @else
        <div style='width:100%; color:red; text-align: center;'>Không tìm thấy sản phẩm nhập của đợt</div>
    @endif
</div>
