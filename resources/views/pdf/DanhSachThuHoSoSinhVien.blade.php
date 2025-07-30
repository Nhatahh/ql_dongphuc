
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTUT|Danh sach thu ho so sinh vien</title>
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
        .break_page{
            page-break-after: always;
        }

    </style>
</head>
<body>
    <div style="padding-top: -60px;text-align:right; font-family: 'Times New Roman', Times, serif; font-size: 11pt;font-weight:bold"></div>
    <table style="margin-top: 30px">
        <tbody>
            <tr>
                <td width="45%"  class="center  border"   style="vertical-align: top">
                    <div >TRƯỜNG ĐẠI HỌC</div>
                    <div >KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>
                    <div style="font-weight:bold">PHÒNG CTCT & QLSV</div>
                    <hr width="50%" style="margin-top: 2px"/>
                </td width="55%">
                <td   class="center  border"   style="vertical-align: top">
                    <div   >CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                    <div    style="font-weight:bold">Độc lập - Tự do - Hạnh phúc</div>
                    <hr     style = "" width="60%" style="margin-top: 2px"/>
                </td>
            </tr>
            <tr>
                <td colspan = "2"   class="center  border"   style="padding-top:20px;padding-bottom:10px">
                    <div style="font-weight:bold">DANH SÁCH HỒ SƠ SINH VIÊN</div>
                    <hr    width="30%" style="margin-top: 2px"/>
                </td>
            </tr>
        </tbody>
    </table>
    <table >
        <tbody>
            <tr>
                <td class="border" >Lớp {{$lop}}</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                @foreach ($data['columns'] as $title)
                    <th class="center" style="font-size:14px">{{ $title['title'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $row)
                <tr>
                    @foreach ($data['columns'] as $title)
                        <td class="center">
                            @if ($row->{$title['data']} == 'checked')
                                <input  type="checkbox"  checked = "checked" style = "height: 13px" >
                            @else
                                @if ($row->{$title['data']} == 'no_checked')
                                    <input type="checkbox"  style = "height: 13px" >
                                @else
                                    {{ $row->{$title['data']} }}
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="margin-top:20px; ">
        <tbody>
            <tr>
                <td class=" center border" width="50%">

                </td>
                <td class=" center border" width="50%"     >
                    <div     ><i> Cần Thơ, ngày &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; tháng &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; năm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></div>
                </td>
            </tr>
            <tr>
                <td class=" center border" width="50%"     >
                    <div     ><strong>Người lập</strong></div>
                </td>
                <td class=" center border " width="50%"      >
                    <div    ><strong>Trưởng phòng</strong></div>
                </td>
            </tr>
            <tr>
                <td class=" center border" width="50%" height = "100px" style="vertical-align: bottom">
                    <div><strong></strong></div>
                </td>
                <td  class=" center border " width="50%" height = "100x" style="vertical-align: bottom">
                    <div><strong></strong></div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="break_page"></div>
    <table>
        <tbody>
            <tr>
                <td class=" border " >
                    Ghi chú danh mục hồ sơ
                </td>
            </tr>
        </tbody>
    </table>
    <table >
        <thead>
            <tr>
                <th class=" center " >STT</th>
                <th class=" center " >Mã hồ sơ</th>
                <th class=" center " >Tên hồ sơ</th>
                <th class=" center " >Bắt buộc</th>
                <th class=" center " >Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $data['danhmuchoso'] as $key => $danhmuc  )
                <tr>
                    <td class=" center " >{{1+$key}}</td>
                    <td class=" center " >{{$danhmuc->text_hienthi}}</td>
                    <td class="">{{$danhmuc->danhmuc_hoso_ten}}</td>
                    <td class=" center " >
                        @if ($danhmuc->batbuoc == 1)
                            <input  checked = "checked" type="checkbox" style="height: 13px">
                        @else
                            <input type ="checkbox" style="height: 13px">
                        @endif
                    </td>
                    <td>{{$danhmuc->danhmuc_hoso_ghichu}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
