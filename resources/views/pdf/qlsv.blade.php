
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTUT|Giấy xác nhận NVQS</title>
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
            margin-left: 20px;
        }
        th, td {
            padding: 8px 2px 2px 2px;
            text-align: left;
            border: 1px solid black;
            /* white-space: nowrap;  */
            font-family: 'Times New Roman';

            font-size: 12pt;
        }
        span{
            padding: 2px;
            text-align: left;
            font-family: 'Times New Roman';
            font-size: 12pt;
        }
        /* .responsive-table {
            overflow-x: auto;
        } */
        .break_page{
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
        $i = 0;
    @endphp
    @foreach ( $pdf as $value )
        @php
            $i ++;
        @endphp
        <div style="padding-top: -60px;text-align:right; font-family: 'Times New Roman', Times, serif; font-size: 10pt;font-style:italic">{{$value->mp}}</div>

        <table style="margin-top: 30px;margin-left: 10px;">
            <tbody>
                <tr>
                    <td width="45%"  class="center  border"   style="vertical-align: top">
                        <div>UBND THÀNH PHỐ CẦN THƠ </div>
                        <div style="font-weight:bold">TRƯỜNG ĐẠI HỌC </div>
                        <div style="font-weight:bold">KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>
                        <hr  width="50%"  style="height:1px;color:black;margin-top: 2px;font-weight:bold;"/>
                    </td width="55%">
                    <td   class="center  border"   style="vertical-align: top">
                        <div    style="font-weight:bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                        <div    style="font-weight:bold">Độc lập - Tự do - Hạnh phúc</div>
                        <hr     width="62%" style="height:1px;color:black;margin-top: 2px;font-weight:bold;"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                <tr>
                    <td colspan = "2"   class="center  border"   style="padding-top:20px;padding-bottom:20px">
                        <div style="font-weight:bold; font-size: 13pt">GIẤY XÁC NHẬN</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2"   class="center  border"   style="padding-top:0px;padding-bottom:20px">
                        <div style="font-weight:bold;">Trường Đại học Kỹ thuật - Công nghệ Cần Thơ xác nhận:</div>

                    </td>
                </tr>

                <tr>
                    <td colspan = "2"  class=" border" >
                        <div > Sinh viên:&nbsp; <strong>{{$value->hoten}}</strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2"  class=" border">
                        <div    >Ngày, tháng, năm sinh: &nbsp; {{$value->ngaysinh}} </div>
                    </td>
                </tr>

                <tr>
                    <td class=" border" width="50%">
                        <div  >Số CMND/CCCD:&nbsp;{{$value->cccd}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Ngày cấp:&nbsp; {{$value->ngaycapcccd}} </div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Nơi cấp:&nbsp; {{$value->noicapcccd}}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Hộ khẩu thường trú:&nbsp;  {{$value->xa}}, {{$value->huyen}}, {{$value->tinh}}  </div>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Hiện là sinh viên Khoa&nbsp;{{$value->khoa}}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Ngành đào tạo:&nbsp; {{$value->name_major}}</div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div  >Mã số sinh viên:&nbsp;{{$value->mssv}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Khóa:&nbsp; 2024</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Lớp:&nbsp;{{$value->lop}}</div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div  >Loại hình đào tạo:&nbsp;Chính quy</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Thời gian đào tạo:&nbsp;{{$value->thoigian}}</div>
                    </td>
                </tr>
                <tr>
                    <td  class=" border">
                        <div  >Trình độ đào tạo:&nbsp;Đại học</div>
                    </td>
                    <td  class=" border">
                        <div>Năm học:&nbsp;2024 - 2025</div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div  >Thời gian nhập học:&nbsp;{{$value->tgnhaphoc}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Dự kiến thời gian tốt nghiệp:&nbsp; {{$value->tgratruong}}</div>
                    </td>
                </tr>
            <tbody>
        </table>
        <table style="margin-top:20px; ">
            <tbody>
                <tr>
                    <td class=" center border" width="50%">

                    </td>
                    <td class=" center border" width="50%" >
                        <div><i> Cần Thơ, ngày @if ($value->day < 10) 0{{$value->day}} @else {{$value->day}} @endif tháng @if ($value->month < 2) 0{{$value->month}} @else {{$value->month}}  @endif năm {{$value->year}} </i></div>
                    </td>
                </tr>
                <tr>
                    <td class=" center border" width="50%"     >
                        <div     ><strong> </strong></div>
                    </td>
                    <td class=" center border " width="50%"  style="padding-top:0px "     >
                        <div    ><strong> KT. HIỆU TRƯỞNG</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class=" center border" width="50%" >

                    </td>
                    <td  class=" center border " width="50%" style="padding-top:0px " >
                        <div><strong>PHÓ HIỆU TRƯỞNG</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class=" center border" width="50%"style="vertical-align: bottom">

                    </td>
                    <td  class=" center border " width="50%" height = "140px"     style="vertical-align: bottom">
                        <div><strong>{{$value->admin_sig}}</strong></div>
                    </td>
                </tr>
            </tbody>
        </table>

        @if ($i < count($pdf))
            <div class="break_page"></div>
        @endif
    @endforeach



</body>
</html>
