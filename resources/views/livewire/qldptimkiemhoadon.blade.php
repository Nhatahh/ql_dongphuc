<div class="col-12 col-md-12">
    <div class="row">
        <!-- Kiếm theo mã hóa đơn -->
        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group row" style="margin-bottom: 3px">
                <label for="mahoadon" class="col-sm-3" style="padding-bottom: 0px;font-weight:bold">Mã hóa đơn:</label>
                <div class="col-sm-9">
                    <input wire:model="mahoadon" id="mahoadon_hoadon_search" style="height: 28px" type="text" class="form-control" >
                </div>
            </div>
        </div>
        <!-- Kiếm theo cccd sinh viên -->
        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group row" style="margin-bottom: 3px">
                <label for="mahoadon" class="col-sm-3" style="padding-bottom: 0px;font-weight:bold">CCCD:</label>
                <div class="col-sm-9">
                    <input wire:model="cccd" id="cccd_hoadon_search" style="height: 28px;" type="text" class="form-control" >
                </div>
            </div>
        </div>
        <!-- Kiếm theo họ tên sinh viên -->
        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group row" style="margin-bottom: 3px">
                <label for="mahoadon" class="col-sm-3" style="padding-bottom: 0px;font-weight:bold">Họ tên:</label>
                <div class="col-sm-9">
                    <input wire:model="hoten" id="hoten_hoadon_search" style="height: 28px;" type="text" class="form-control" >
                </div>
            </div>
        </div>
        <!-- <div class="col-8">
        </div>
        <div style="padding-bottom:10px"  class="col-4 style_all_button">
            <button style="height: 28px;" type="button" time="" data-id="" id="phat_dongphuc" onclick="phatdongphuc_timkiem()" class="btn btn-block btn-primary btn-xs">
                <i class="fa-solid fa-magnifying-glass"></i>Tìm Kiếm&nbsp;&nbsp;
            </button>
        </div> -->
    </div>
    <div style="padding-top:10px" class=""></div>
    <legend style="margin-bottom: 12px">Danh sách hóa đơn</legend>
    <div class="row">
        @foreach($hoadon as $val)
            <div style="" class="col-12 col-md-4 col-lg-4">
                <div class="item-thisinh">
                    <div class="item-header">
                        <div class="item-row1">
                            <div class="maphieu">
                                <span style="font-weight:bold">Mã hóa đơn:</span>
                                <strong style="color:#f40f02;">{{$val->mahoadon}}</strong>
                            </div>
                            <div class="maphieu">
                                <span><i onclick="xoa_hoadon('{{ $val->mahoadon }}')" style="color: #f40f02;" class="fa-regular fa-circle-xmark  "></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="item-bottom"></div>
                    <div class="item-body">
                        <div class="thongtin">
                            <div class="left">Người phát:</div>
                            <div class="right">{{$val->nguoiphat}}</div>
                        </div>
                        <div class="thongtin">
                            <div class="left">Người nhận:</div>
                            <div class="right">{{$val->nguoinhan}}</div>
                        </div>
                        <div class="thongtin">
                            <div class="left">Thời gian:</div>
                            <div class="right">{{$val->ngaytao}}</div>
                        </div>
                        <div class="thongtin">
                            <div class="left">Đợt phát:</div>
                            <div class="right">{{$val->dotphat}}</div>
                        </div>
                        <div class="thongtin">
                            <div class="left">CCCD:</div>
                            <div class="right">{{$val->cccd}}</div>
                        </div>
                    </div>
                    <div class="item-bottom"></div>
                    <div class="item-row1">
                        <div class="maphieu">
                            <span style="font-weight:700"><span>
                        </div>
                        <div class="maphieu">
                            <span style="color:rgba(49, 59, 245,0.8);font-weight:light;" onclick="in_hoadon('{{ $val->mahoadon }}')" >Xem chi tiết...</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
