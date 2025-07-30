<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CTUT|HÓA ĐƠN</title>
    <style type="text/css">
        /* .border{
            border: none;
        } */

        .center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 20px;
        }

        th,
        td {
            padding: 6px 2px 2px 2px;
            text-align: left;
            /* white-space: nowrap;  */
            font-family: 'Times New Roman';
            font-size: 12pt;
        }

        span {
            padding: 2px;
            text-align: left;
            font-family: 'Times New Roman';
            font-size: 12pt;
        }

        /* .responsive-table {
            overflow-x: auto;
        } */
        .break_page {
            page-break-after: always;
        }

    </style>


</head>

<body>
    <table style="margin-top: 0px;margin-left: 10px;">
        <tbody>
            <tr>
                <td width="45%" class="border" style="vertical-align: top">
                    <div style="position: absolute;
                    top: 0;
                    right: 0;
                    padding: 20px; font-weight:bold font-family: 'Times New Roman', Times, serif; font-size: 10pt;font-style:italic">{{$hoadon[0]->ngayhd}}</div>
                </td width="55%">
            </tr>
        </tbody>
    </table>


    <table style="margin-top: 10px;margin-left: 10px;">
        <tbody>
            <tr>
                <td width="45%" class="center  border" style="vertical-align: top">
                    <div>UBND THÀNH PHỐ CẦN THƠ </div>
                    <div style="font-weight:bold">TRƯỜNG ĐẠI HỌC </div>
                    <div style="font-weight:bold">KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>
                    <hr width="50%" style="height:1px;color:black;margin-top: 2px;font-weight:bold;" />
                </td width="55%">
                <td class="center  border" style="vertical-align: top">
                    <div style="font-weight:bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                    <div style="font-weight:bold">Độc lập - Tự do - Hạnh phúc</div>
                    <hr width="62%" style="height:1px;color:black;margin-top: 2px;font-weight:bold;" />
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr>
                <td colspan="2" class="center  border" style="padding-top:15px;padding-bottom:15px">
                    <div style="font-weight:bold; font-size: 13pt">PHIẾU NHẬN ĐỒNG PHỤC</div>
                </td>
            </tr>
        </tbody>
    </table>




    <table>
        <tbody>
            <tr>
                <td colspan="3" class=" border">
                    <div> Họ và tên sinh viên:&nbsp; <strong>{{$hoadon[0]->tensv}}</strong></div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class=" border">
                    <div> Ngày sinh:&nbsp; <strong>{{$hoadon[0]->ngaysinh}}</strong></div>
                </td>
            </tr>

            <tr>
                <td colspan="3" class=" border">
                    <div>MSSV:&nbsp;{{$hoadon[0]->mssv}}</div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class=" border">
                    <div>CCCD/CMND:&nbsp;{{$hoadon[0]->cccd}}</div>
                </td>
            </tr>
    </table>




    <table class="table table-bordered table-hover table-striped" style="width: 100%;margin-top: 10px">
        <thead>
            <tr>
                <th style="border-bottom: 1px solid black;text-align:center">Loại</th>
                <th style="border-bottom: 1px solid black;text-align:center">Size</th>
                <th style="border-bottom: 1px solid black;text-align:center">Số lượng</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($hoadon); $i++)
                @if ($i == count($hoadon) - 1)
                <tr>
                    <td  style="border-bottom: 1px solid black;text-align:center">{{$hoadon[$i]->tensp}}</td>
                    <td  style="border-bottom: 1px solid black;text-align:center">{{$hoadon[$i]->tensz}}</td>
                    <td  style="border-bottom: 1px solid black;text-align:center">{{$hoadon[$i]->soluong}}</td>
                </tr>
                @else
                <tr>
                    <td style="text-align:center">{{$hoadon[$i]->tensp}}</td>
                    <td style="text-align:center">{{$hoadon[$i]->tensz}}</td>
                    <td style="text-align:center">{{$hoadon[$i]->soluong}}</td>
                </tr>
                @endif

            @endfor
        </tbody>
    </table>
    {{--  --}}
    <table style="margin-top:30px; ">
        <tbody>
            <tr>
                <td class=" center border" width="50%">

                </td>
                <td class=" center border" width="50%"     >
                    <div><i> Cần Thơ, ngày {{$hoadon[0]->ngay}} tháng {{$hoadon[0]->thang}} năm {{$hoadon[0]->nam}}</i></div>
                </td>
            </tr>
            <tr>
                <td class=" center border" width="50%" style="padding-right:100px">
                    <div><strong>NGƯỜI NHẬN</strong></div>
                </td>
                <td  class=" center border " width="50%" style="padding-top:0px " >
                    <div><strong>NGƯỜI PHÁT</strong></div>
                </td>
            </tr>
            <tr>
                <td class=" center border" width="50%" height = "120px" style="vertical-align: bottom; padding-right:100px;">
                    <div><strong>{{$hoadon[0]->tensv}}</strong></div>

                </td>
                <td  class=" center border " width="50%" height = "120px" style="vertical-align: bottom">
                    <div><strong>{{$hoadon[0]->nguoiphat}}</strong></div>
                </td>
            </tr>
        </tbody>
    </table>


</body>








