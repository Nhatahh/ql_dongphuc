
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTUT|Giấy báo đủ điều kiện</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">


    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/template/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <style type="text/css">
        /* * {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
        } */

        td{
            /* border: solid  1px */
        }

        .header{
            font-family: 'Times New Roman', Times, serif;
            margin-bottom: -5px;
            font-size: 11.5pt;
        }

        .center{
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            font-size: 11pt;
        }

        .content{
            font-family: 'Times New Roman', Times, serif;
            text-align: left;
            font-size: 11pt;

        }
    </style>
</head>

<body>


    {{-- @if ($title === 0)
        <a>Bạn chưa đủ điều kiện trúng tuyển</a>
    @else --}}

        <table style="width:100%;">
            {{-- border:solid 1px --}}
            <tbody>
                <tr>
                    <td width="45%" class="center" style="vertical-align: top">
                        <div class="header">TRƯỜNG ĐẠI HỌC</div>
                        <div class="header">KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>
                        <div class="header" style="font-weight:bold">HỘI ĐỒNG TUYỂN SINH 2023</div>
                        <hr class="header" width="50%" style="margin-top: 2px"/>
                    </td width="55%">
                    <td class="center" style="vertical-align: top">
                        <div class="header">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
                        <div class="header" style="font-weight:bold">Độc lập - Tự do - Hạnh phúc</div>
                        <hr  class="header" style="" width="60%" style="margin-top: 2px"/>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2" class="center" style="padding-top:30px;padding-bottom:20px">
                        <div style="font-weight:bold">GIẤY BÁO</div>
                        <div style="font-weight:bold">Đủ điều kiện trúng tuyển đại học chính quy 2023 (trừ điều kiện tốt nghiệp THPT)</div>
                        <hr class="header" width="30%" style="margin-top: 2px"/>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content" style="padding-top:30px"> Hội đồng tuyển sinh <strong> Trường Đại học Kỹ thuật - Công nghệ Cần Thơ </strong> thông báo:</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content"> Thí sinh:&nbsp; <strong> {{$name_user}} </strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">ID xét tuyển: &nbsp; <strong> {{$id_user}} </strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">Chứng minh nhân dân:&nbsp; <strong> {{$id_card_users}} </strong> </div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">Số điện thoại:&nbsp; <strong> {{$phone_users}} </strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">Email:&nbsp; <strong> {{$email_users}} </strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">Ngành đủ điều kiện trúng tuyển:&nbsp; <strong> {{$name_major}} </strong></div>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <div  class="content">Phương thức xét tuyển:&nbsp; <strong> {{$name_method}} </strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">Tổ hợp xét tuyển:&nbsp; <strong> {{$id_group}} ({{$name_group}}) </strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">Điểm xét tuyển:&nbsp; <strong> {{$mark}} </strong></div>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <hr class="header" width="100%" style="margin-top: 2px"/>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div class="content"><strong>LƯU Ý</strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Thí sinh đủ điều kiện trúng tuyển (trừ điều kiện tốt nghiệp THPT) đăng ký nguyện vọng cao nhất là ngành <strong>{{$name_major}}</strong>,Mã trường <strong>KCC</strong> trên <strong style="color:red">HỆ THỐNG QUẢN LÝ THI TỐT NGHIỆP THPT</strong> của Bộ Giáo dục và Đào tạo tại <a href = "https://thisinh.thitotnghiepthpt.edu.vn/">https://thisinh.thitotnghiepthpt.edu.vn/</a></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Thời gian đăng ký: <span style="color:red"><strong>từ ngày 10/07/2023 đến trước 17 giờ, ngày 30/07/2023</span></strong></div>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <div  class="content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Hình thức đăng ký: <span><strong style="red">trực tuyến</strong></span></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <div  class="content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Hướng dẫn đăng ký: <a href="https://tuyensinh.ctuet.edu.vn/">https://tuyensinh.ctuet.edu.vn/</a></span> hoặc <a href="https://congmotcua.ctuet.edu.vn">https://congmotcua.ctuet.edu.vn</a></div>
                    </td>
                </tr>
            </tbody>
        </table>


    {{-- @endif --}}





</body>
</html>
