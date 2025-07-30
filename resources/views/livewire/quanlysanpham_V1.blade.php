<div class="item-hoso">
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

        <div class="col-12 col-md-12 col-lg-12" style="padding-bottom: 5px;">
            <button type="button" manhinh = "ql_dotnhap" id="btn_ScanQR" onclick="Scan_QR('quanlysanpham')" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Quét QRcode</button>
        </div>

        <div class="row" style="padding: 0px 16px 0px 9px;">
            @if(count($sanphamnhap) > 0)
                @foreach ($sanphamnhap as $row)
                <div style = "margin-left: 5px; " class="col-xl-2 ms-1 item-thisinh">
                    <div class="item-header">
                        <div class="item-row1" style="text-align: center;">
                            <div class="row col-12">
                                <div class="right" style = "width:100%; height: 100%;">
                                    <div class="right"><img class = 'img_sanpham' id = "img_sanpham{{$row->id}}" src='{{$row->anhsanpham != null ? $row->anhsanpham : "https://placehold.co/150x200?text=%E1%BA%A2nh%20s%E1%BA%A3n%20ph%E1%BA%A9m%0A(150x200)" }}' alt='QR Code'  /></div>
                                    <div class="right col-12 " style="display: flex; justify-content: center;">
                                        <button style="width: 40%; text-align: center;" type="button" onclick="update_anhsanpham(event,'{{$row->id}}')" class="btn btn-block btn-xs btt_lammoi load-index">
                                            <div class="load-index-children"></div>
                                            <i class="fa-solid fa-upload"></i>&nbsp;&nbsp;&nbsp;Cập nhật
                                        </button>
                                        <input type="file" id="file_anhsp_update_mobile{{$row->id}}" accept="image/*" style="display: none;">
                                    </div>
                                </div>
                                <div style="display: none;" class="right">
                                    <div class="right"><img id = "img_Qrcode_{{$row->id}}" src='data:image/png;base64,{{ $row->qrcode }}' alt='QR Code' style='width: 30px; height: 30px; vertical-align: middle; margin-bottom: 5px;' /></div>
                                </div>
                                <!-- <div class="right col-12 " style="display: flex; justify-content: center;">
                                    <button style="width: 80%; text-align: center;" type="button" onclick="update_anhsanpham(event,'{{$row->id}}')" class="btn btn-block btn-xs btt_lammoi load-index">
                                        <div class="load-index-children"></div>
                                        <i class="fa-solid fa-upload"></i>&nbsp;&nbsp;&nbsp;Cập nhật
                                    </button>
                                    <input type="file" id="file_anhsp_update_mobile{{$row->id}}" accept="image/*" style="display: none;">
                                </div> -->

                            </div>
                            
                        </div>
                    </div>
                    <div class="item-bottom"></div>
                    <div class="item-body">
                        <div class="thongtin">
                            <span >Loại:</span>
                            <strong id = "loai_{{$row->id}}">{{$row->loai}}</strong>
                        </div>
                        <div class='thongtin'>
                            <span >Mã SP:</span>
                            <strong id = "ma_{{$row->id}}">{{$row->masp}}</strong>
                        </div>
                        <div class='thongtin'>
                            <div class="left">Nhà sản xuất: </div>
                            <div class="right">{{$row->nhasanxuat}}</div>
                        </div>
                        <div class='thongtin'>
                            <div class="left">Size:</div>
                            <div class="right">{{$row->size}}</div>
                        </div>
                        <div class='thongtin'>
                            <div class="left">Thông số:</div>
                            <div class="right">{{$row->thongso}}</div>
                        </div>
                        <div class='thongtin'>
                            <div class="left">Ghi chú:</div>
                            <div class="right">{{$row->ghichu}}</div>
                        </div>
                        <div class='thongtin'>
                            <div class="left">Ngày tạo:</div>
                            <div class="right">{{$row->create_at}}</div>
                        </div>
                        <div class='thongtin'>
                            <div class="left">Trạng thái:</div>
                            <div class="right">
                                @if ($row->trangthai == 1)
                                    {{ "Đang sử dụng" }}
                                @else
                                    {{ "Ngưng sử dụng" }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="item-bottom"></div>
                    <div class='thongtin'>
                        <!-- <div  class="col-8"> </div> -->
                        <div style="padding-left: 9px;" class="right">
                            <button onclick = "show_modal_edit_sanpham(event,'{{$row->id}}')"  type="button" class="btn btn-block btn-outline-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>&nbsp;Sửa</button></button>
                        </div>
                        <!-- <div style="padding-left: 9px;" class="right">
                            <button  type="button" class="btn btn-block btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i>&nbsp;Xóa</button></button>
                        </div> -->
                        <div style="padding-left: 9px;" class="right">
                            <button  type="button" onclick="modal_Down_Qrcode(event,'{{$row->id}}')" class="btn btn-block btn-outline-info btn-sm"><i class="fa-solid fa-qrcode"></i>&nbsp;Tải QR</button></button>
                        </div>
                        <div style="padding-left: 9px;" class="right">
                            <button  type="button" class="btn btn-block btn-outline-danger btn-sm"  id = "dlt_SP{{$row->id}}" onclick = "dlt_SP(event,'{{$row->id}}')"><i class="fa-solid fa-trash"></i>&nbsp;Xóa</button></button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div style='width:100%; color:red; text-align: center;'>Không tìm thấy sản phẩm</div>
            @endif
        </div>
    </div>
    @include('user_24.admin24.include.Scan_QR')
</div>