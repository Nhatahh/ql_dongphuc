
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTUT|Giấy báo trúng tuyển</title>
    <style type="text/css">

        /* .border{
            border: none;
        } */

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
    @if ($infor[0]['active'] == 0)
        <div >Không thí sinh</div>
    @else
        @php
            $i = 0;
        @endphp
        @foreach ( $infor as $value )
        @php
            $i ++;
        @endphp
            <div style="padding-top: -60px;text-align:right; font-family: 'Times New Roman', Times, serif; font-size: 10pt;font-style:italic">{{$value['sodon']}}</div>
            <table style="margin-top: 30px;margin-left: 10px;">
                <tbody>
                    <tr>
                        <td width="45%"  class="center  border"   style="vertical-align: top">
                            <div >TRƯỜNG ĐẠI HỌC </div>
                            <div >KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>
                            <div style="font-weight:bold">HỘI ĐỒNG TUYỂN SINH</div>
                            <hr  width="50%"  style="height:1px;color:black;margin-top: 2px;font-weight:bold;"/>
                        </td width="55%">
                        <td   class="center  border"   style="vertical-align: top">
                            <div    style="font-weight:bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                            <div    style="font-weight:bold">Độc lập - Tự do - Hạnh phúc</div>
                            <hr     width="62%" style="height:1px;color:black;margin-top: 2px;font-weight:bold;"/>
                            {{-- <div     ><i style="font-size:11pt"> Cần Thơ, ngày {{$value['day']}} tháng {{$value['month']}} năm {{$value['year']}} </i></div> --}}
                            <div     ><i style="font-size:11pt"> Cần Thơ, ngày 15 tháng 9 năm 2023 </i></div>

                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td colspan = "2"   class="center  border"   style="padding-top:15px;padding-bottom:15px">
                            <div style="font-weight:bold; font-size: 13pt">GIẤY BÁO TRÚNG TUYỂN ĐAI HỌC CHÍNH QUY</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div >  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Họ và tên sinh viên:&nbsp; <strong>{{$value['name_user']}}</strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div    > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ngày sinh: &nbsp; {{$value['birth_user']}} </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Số CMND/CCCD:&nbsp;{{$value['id_card_users']}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Đã trúng tuyển đại học chính quy 2023:</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Ngành: {{$value['name_major']}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Mã ngành: {{$value['id_major']}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Phương thức: {{$value['name_method']}}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3"  class=" border" >
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Điểm trúng tuyển: {{$value['mark']}}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="">
                <tbody>
                    <tr>
                        <td  style="text-align: justify" class=" border">
                            <div >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thí sinh: <strong> {{$value['name_user']}}</strong> chuẩn bị đầy đủ các giấy tờ theo yêu cầu và trực tiếp làm thủ tục nhập học tại Phòng Đào tạo, Trường Đại học Kỹ thuật - Công nghệ Cần Thơ, Số 256 Nguyễn Văn Cừ, phường An Hòa, quận Ninh Kiều, thành phố Cần Thơ, số điện thoại: 0292.3898.167.</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: justify"  class=" border">
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thí sinh xem chi tiết tại Hướng dẫn nhập học tại <i><u>https://www.ctuet.edu.vn</u></i></div>
                        </td>
                    </tr>
                    <tr>
                        <td class=" border">
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Lưu ý:</strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td class=" border">
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Thời gian hoàn thành thủ tục nhập học: Trước 17 giờ, ngày 16/09/2023. Sau thời gian trên, thí sinh không làm thủ tục nhập học xem như thí sinh đã tự ý bỏ học</div>
                        </td>
                    </tr>
                    <tr>
                        <td class=" border">
                            <div  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Thí sinh phải hoàn toàn chịu trách nhiệm về tính chính xác của thông tin trong hồ sơ nhập học.</div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="margin-top:10px; ">
                <tbody>
                    <tr>
                        <td class=" center border" width="50%"     >
                            <div     ><strong> </strong></div>
                        </td>
                        <td class=" center border " width="50%"  style="padding-top:20px "     >
                            <div    ><strong> TM. HỘI ĐỒNG TUYỂN SINH</strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td class=" center border" width="50%" >

                        </td>
                        <td  class=" center border " width="50%" style="padding-top:0px " >
                            <div><strong>CHỦ TỊCH</strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td class=" center border" width="50%"style="vertical-align: bottom">

                        </td>
                        <td  class=" center border " width="50%" height = "150px"     style="vertical-align: bottom">
                            <div><strong>Hiệu trưởng Trường ĐHKTCNCT</strong></div>
                            <div><strong>NGND.PGS.TS Huỳnh Thanh Nhã</strong></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            @if ($i < count($infor))
                <div class="break_page"></div>
            @endif

        @endforeach

    @endif
</body>
</html>
