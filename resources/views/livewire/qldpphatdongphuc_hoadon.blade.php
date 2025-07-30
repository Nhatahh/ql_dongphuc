<div class="col-12 col-md-12">
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
