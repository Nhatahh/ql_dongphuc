
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTUT|Giấy báo đủ điều kiện</title>
    <style type="text/css">

        .border{
            border: none;
        }

        .center{
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 2px;
            text-align: left;
            border: 1px solid black;
            /* white-space: nowrap;  */
            font-family: 'Times New Roman', Times, serif;

            font-size: 11pt;
        }
        span{
            padding: 2px;
            text-align: left;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
        }
        /* .responsive-table {
            overflow-x: auto;
        } */
    </style>
</head>

<body>
    @if (1 === 0)
        <div style="padding-top: -60px;text-align:left; font-family: 'Times New Roman', Times, serif; font-size: 11pt;font-weight:bold">Thầy/Cô chưa khóa hồ sơ của thí sinh. Vui lòng Khóa hồ sơ trước khi in</div>
    @else
        <div style="padding-top: -60px;text-align:right; font-family: 'Times New Roman', Times, serif; font-size: 11pt;font-weight:bold">{{$maphieu}}</div>
        <table style="margin-top: 30px">
            <tbody>
                <tr>
                    <td width="45%"  class="center  border"   style="vertical-align: top">
                        <div >TRƯỜNG ĐẠI HỌC</div>
                        <div >KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>
                        <div style="font-weight:bold">HỘI ĐỒNG TUYỂN SINH 2024</div>
                        <hr width="50%" style="margin-top: 2px"/>
                    </td width="55%">
                    <td   class="center  border"   style="vertical-align: top">
                        <div   >CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                        <div    style="font-weight:bold">Độc lập - Tự do - Hạnh phúc</div>
                        <hr     style = "" width="60%" style="margin-top: 2px"/>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2"   class="center  border"   style="padding-top:20px;padding-bottom:20px">
                        <div style="font-weight:bold">PHIẾU RÀ SOÁT THÔNG TIN ĐĂNG KÝ XÉT TUYỂN</div>
                        <hr    width="30%" style="margin-top: 2px"/>
                    </td>
                </tr>
                <tr>
                    <td class=" border"  colspan = "2">
                        <div s><strong> 1. Thông tin cá nhân</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class=" border"  width="50%">
                        <div   > Thí sinh:&nbsp; <strong> {{$hoten}} </strong></div>
                    </td>
                    <td class=" border" width="50%">
                        <div   >Ngày sinh: &nbsp; {{$ngaysinh}} </div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div   >CMND/TCC:&nbsp; <strong>{{$cccd}} </strong> </div>
                    </td>
                    <td class=" border" width="50%">
                        <div   >Điện thoại:&nbsp;  {{$dienthoai}} </div>
                    </td>
                </tr>
                <tr>
                    <td class=" border"  width="50%">
                        <div  > Giới tính:&nbsp; {{$gioitinh}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Năm tốt nghiệp: &nbsp; <strong> {{$namtotnghiep}} </strong></div>
                    </td>
                </tr>
                <tr>
                    <td  class=" border"width="50%">
                        <div   >Khu vực:&nbsp; <strong>{{$khuvucuutien}}   </strong> </div>
                    </td>
                    <td  class=" border"  width="50%">
                        <div   >Đối tượng:&nbsp; <strong>{{$doituonguutien}}  </strong> </div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" colspan = "2">
                        <div       ><strong> 2. Thông tin học tập</strong></div>
                    </td>
                </tr>
                {{-- <tr>
                    <td class=" border"  colspan = "2">
                        <div       ><i><strong> a. Điểm học bạ cấp THPT</strong></i></div>
                    </td>
                </tr> --}}
            </tbody>
        </table>
        {{-- {{$diemhocba[0]->id_subject}} --}}

        <table>
            <thead>
                <tr>
                    <th class="center">Lớp/HK</th>
                    @for ($i = 0;$i < count($mons); $i++)
                        <th  class="center" >{{$mons[$i]->name_subject}}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td  class="center">Lớp 10 (CN)</td>
                    @for ($i = 0;$i < count($lop10); $i++)
                        @if (empty($diemthpt[$i]->diemlop10))
                            <td class="center">0</td>
                        @else
                            <td class="center">{{$lop10[$i]->diemlop10}}</td>
                        @endif
                    @endfor
                </tr>
                <tr>
                    <td  class="center">Lớp 11 (CN)</td>
                    @for ($i = 0;$i < count($lop11); $i++)
                        @if (empty($diemthpt[$i]->diemlop11))
                            <td class="center">0</td>
                        @else
                            <td class="center">{{$lop12CN[$i]->diemlop11}}</td>
                        @endif
                    @endfor
                </tr>
                <tr>
                    <td  class="center">Lớp 12 (HK1)</td>
                    @for ($i = 0;$i < count($lop12); $i++)
                        @if (empty($diemthpt[$i]->diemlop12))
                            <td class="center">0</td>
                        @else
                            <td class="center">{{$lop12CN[$i]->diemlop12}}</td>
                        @endif
                    @endfor
                </tr>
                <tr>
                    <td  class="center">Lớp 12 (CN)</td>
                    @for ($i = 0;$i < count($lop12CN); $i++)
                        @if (empty($diemthpt[$i]->diemhocba12CN))
                            <td class="center">0</td>
                        @else
                            <td class="center">{{$lop12CN[$i]->diemhocba12CN}}</td>
                        @endif
                    @endfor
                </tr>
                <tr>
                    <td  class="center">THPT</td>
                    @for ($i = 0;$i < count($diemthpt); $i++)
                        @if (empty($diemthpt[$i]->diemthpt))
                            <td class="center">X</td>
                        @else
                            <td class="center">{{$diemthpt[$i]->diemthpt}}</td>
                        @endif
                    @endfor
                </tr>
            </tbody>
        </table>

        <table>
            <tbody>
                <tr>
                    <td class=" border"  colspan = "2" >
                        <div><strong> 3. Danh sách nguyện vọng</strong></div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th class="center" >TT</th>
                    <th class="center" >PT</th>
                    <th class="center" >Ngành</th>
                    <th class="center" >Tổ hợp</th>
                    <th class="center" >Điểm TH</th>
                    <th class="center" >Ưu tiên</th>
                    <th class="center" >Điểm XT</th>
                    <th class="center" >TTS</th>
                    <th class="center" >Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i <count($nguyenvong);$i++)
                    <tr>
                        <td class="center" >{{$nguyenvong[$i]->thutu}}</td>
                        <td class="center" >{{$nguyenvong[$i]->phuongthuc}}</td>
                        <td>{{$nguyenvong[$i]->tenchuyennganh}}</td>
                        <td class="center" >{{$nguyenvong[$i]->tohop}}</td>
                        <td class="center" >{{$nguyenvong[$i]->diemtohop}}</td>
                        <td class="center" >{{$nguyenvong[$i]->diemuutien}}</td>
                        <td class="center" >{{$nguyenvong[$i]->diemxettuyen}}</td>
                        <td class="center" >{{$nguyenvong[$i]->ttsom}}</td>
                        <td class="center" >{{$nguyenvong[$i]->ketqua}}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <table>
            <tbody>
                <tr>
                    <td class=" border"  colspan = "2" >
                        <div><strong> 4. Hồ sơ tuyển sinh</strong></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                    @for ($i = 0; $i< count($danhmuc);$i++)
                        @if ($i%2 === 0)
                        <tr>
                        @endif
                            <td class=" border" >
                                @if ($danhmuc[$i]->id_taikhoan)
                                    <input type="checkbox" checked="checked" />&nbsp;&nbsp;<span>{{$danhmuc[$i]->loaihoso}}</span>
                                @else
                                    <input  type="checkbox">&nbsp;&nbsp;<span>{{$danhmuc[$i]->loaihoso}}</span>
                                @endif
                            </td>
                        @if (($i+2)%2 === 0)
                    </tr>
                        @endif
                    @endfor
            </tbody>
        </table>
        <table style="margin-top:5px;">
            <tbody>
                <tr>
                    <td class=" border"  colspan = "2">
                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tôi cam kết thông tin đăng ký là chính xác và chịu trách nhiệm.</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="margin-top:20px; ">
            <tbody>
                <tr>
                    <td class=" center border" width="50%">

                    </td>
                    <td class=" center border" width="50%"     >
                        <div     ><i> Cần Thơ, ngày {{$day}} tháng {{$month}} năm {{$year}}</i></div>
                    </td>
                </tr>
                <tr>
                    <td class=" center border" width="50%"     >
                        <div     ><strong> Cán bộ nhận hồ sơ</strong></div>
                    </td>
                    <td class=" center border " width="50%"      >
                        <div    ><strong> Thí sinh</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class=" center border" width="50%" height = "100px" style="vertical-align: bottom">
                        <div><strong>{{$canbonhanhoso}}</strong></div>
                    </td>
                    <td  class=" center border " width="50%" height = "100x" style="vertical-align: bottom">
                        <div><strong>{{$hoten}}</strong></div>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif


</body>
</html>
