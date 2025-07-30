<div class="item-hoso">
    @if ($trangthai == 1)
        <div class="col-12 col-md-12 col-lg-12" style="padding:0px;">
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
                            <!-- <option value="1">Tây Đô</option>
                            <option value="2">VIệt Tiến</option>
                            <option value="3">Hải Anh</option> -->
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
                            <!-- <option value="1">Áo đồng phục</option>
                            <option value="2">Quần thể dục</option>
                            <option value="3">Áo polo</option>
                            <option value="4">Áo sơ mi nữ</option> -->
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
                            <!-- <option value="1">S</option>
                            <option value="2">M</option>
                            <option value="3">L</option>
                            <option value="4">XL</option> -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12" >
                <button type="button" manhinh="qldp-nhap" id="btn_ScanQR" onclick="Scan_QR('qldp-nhap')" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Quét QRcode</button>
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
                                <div class="right"> <strong>{{$row->masp}}</strong></div>
                            </div>
                        </div>
                        <div class="item-bottom"></div>
                        <div class="item-body">
                            <div class='thongtin'>
                                <div class="left">Nhà sản xuất: </div>
                                <div class="right">{{$row->nhasanxuat}}</div>
                            </div>
                            <div class='thongtin'>
                                <div class="left">Size: </div>
                                <div class="right">{{$row->size}}</div>
                            </div>
                            <div class='thongtin'>
                                <div class="left">Số lượng yêu cầu: </div>
                                <div class="right">{{$row->soluongyeucau}}</div>
                            </div>
                            <div class='thongtin'>
                                <div class="left">Số lượng đã nhập: </div>
                                <div class="right">{{$row->soluongnhap}}</div>
                            </div>


                            <div class="form-group row" style="margin-bottom: 0px">
                                <label for="" class="col-sm-8 col-8 col-form-label"
                                    style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Số lượng nhập:</label>
                                <div class=" right col-sm-4 col-4 ">
                                    <input  type="text"  class="form-control " style=" height:28px;width:100% " id_nhaphang = "{{$row->id}}" id_sanpham = "{{$row->id_sanpham}}"  id_dot = "{{$row->id_dotnhap}}"  onchange= "change_nhapsanpham(event,'{{$row->id}}')"  id ="soluongnhap_{{$row->id}}" value = '0'>
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