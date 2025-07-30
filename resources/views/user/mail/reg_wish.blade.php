
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <p><strong>Thí sinh đã đăng ký xét tuyển tại Trường Đại học Kỹ thuật - Công nghệ Cần Thơ, sau đây thứ tự nguyện vọng đã đăng ký:</strong> </p>
        <table style="width: 100%">
            <thead>
                <th> Thứ tự</th>
                <th> Phương thức</th>
                <th> Mã ngành</th>
                <th> Tên ngành</th>
                <th> Thời điểm đăng ký</th>
            </thead>
            <tbody>
                @foreach ( $major as $value )
                    <tr>
                        <td>{{$value->number}}</td>
                        <td>{{$value->name_method}}</td>
                        <td>{{$value->id_major}}</td>
                        <td>{{$value->name_major}}</td>
                        <td>{{$value->time}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p>Lưu ý:</p><br>
    <p>Thí sinh truy cập Chức năng Thanh toán lệ phí trên Cổng xét tuyển để được hướng dẫn Thanh toán lệ phí</p>
    <p>Nếu nguyện vọng có sai lệch so với cổng đăng ký xét tuyển, vui lòng liên hệ Phòng Đào tạo theo hotline: 02923898167</p>
</body>
</html>



