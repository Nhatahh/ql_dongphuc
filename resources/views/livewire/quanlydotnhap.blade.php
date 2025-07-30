<div class="item-hoso">
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

            <div class="col-12 col-md-12 col-lg-12" style="padding-bottom: 5px;">
                <button type="button" manhinh = "ql_dotnhap" id="btn_ScanQR" onclick="Scan_QR('ql_dotnhap')" class="btn btn-block btn-primary btn-xs"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;&nbsp;Quét QRcode</button>
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
                                <!-- <div class="right"> <strong>{{$row->masp}}</strong></div> -->
                            </div>
                        </div>
                        <div class="item-bottom"></div>
                        <div class="item-body">
                            <div class='thongtin'>
                                <div class="left">Mã SP: </div>
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
                            <!-- <div class='thongtin'>
                                <div class="left">Thông số </div>
                                <div class="right">{{$row->thongso}}</div>
                            </div> -->
                            <div class="form-group row" style="margin-bottom: 0px">
                                <label for="" class="col-sm-8 col-8 col-form-label"
                                    style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Số lượng nhập:</label>
                                <div class=" right col-sm-4 col-4 ">
                                    <input  type="text"  class="form-control " style=" height:28px;width:100% "  id ="soluongsanphamnhap_mobile_{{$row->id}}" onchange="change_soluong(event,'{{$row->id}}')" value = {{$row->soluong}}>
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
    @include('user_24.admin24.include.Scan_QR')
</div>