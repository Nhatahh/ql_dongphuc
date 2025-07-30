
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
    @foreach ( $infor as $value )
        @php
            $i ++;
        @endphp
        <div style="padding-top: -60px;text-align:right; font-family: 'Times New Roman', Times, serif; font-size: 10pt;font-style:italic">{{$value['sodon']}}</div>

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
                        <div > Sinh viên:&nbsp; <strong>{{$value['name_user']}}</strong></div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2"  class=" border">
                        <div    >Ngày, tháng, năm sinh: &nbsp; {{$value['birth_user']}} </div>
                    </td>
                </tr>

                <tr>
                    <td class=" border" width="50%">
                        <div  >Số CMND/CCCD:&nbsp;{{$value['id_card_users']}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Ngày cấp:&nbsp; {{$value['date_card']}} </div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Nơi cấp:&nbsp; {{$value['noicap']}}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Hộ khẩu thường trú:&nbsp; {{$value['hktt']}}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Hiện là sinh viên Khoa&nbsp;{{$value['khoa']}}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Ngành đào tạo:&nbsp; {{$value['name_major']}}</div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div  >Mã số sinh viên:&nbsp;{{$value['mssv']}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Khóa:&nbsp; 2023</div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Lớp:&nbsp;{{$value['lop']}}</div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div  >Loại hình đào tạo:&nbsp;Chính quy</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Thời gian đào tạo:&nbsp;{{$value['thoigian']}} </div>
                    </td>
                </tr>
                <tr>
                    <td colspan = "2" class=" border">
                        <div  >Trình độ đào tạo:&nbsp;Đại học</div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div  >Thời gian nhập học:&nbsp;{{$value['tgnhaphoc']}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Dự kiến thời gian tốt nghiệp:&nbsp; {{$value['tgratruong']}}</div>
                    </td>
                </tr>
            <tbody>
        </table>
        <table style="margin-top:20px; ">
            <tbody>
                <tr>
                    <td class=" center border" width="50%">

                    </td>
                    <td class=" center border" width="50%"     >
                        <div     ><i> Cần Thơ, ngày {{$value['day']}} tháng {{$value['month']}} năm {{$value['year']}} </i></div>
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
                        <div><strong>{{$value['admin_sig']}}</strong></div>
                    </td>
                </tr>
            </tbody>
        </table>

        @if ($i < count($infor))
            <div class="break_page"></div>
        @endif
    @endforeach




    {{-- @if ($check_block === 0)
        <div style="padding-top: -60px;text-align:left; font-family: 'Times New Roman', Times, serif; font-size: 11pt;font-weight:bold">Thầy/Cô chưa khóa hồ sơ của thí sinh. Vui lòng Khóa hồ sơ trước khi in</div>
    @else
        <div style="padding-top: -60px;text-align:right; font-family: 'Times New Roman', Times, serif; font-size: 11pt;font-weight:bold">{{$maphieu}}</div>
        <table style="margin-top: 30px">
            <tbody>
                <tr>
                    <td width="45%"  class="center  border"   style="vertical-align: top">
                        <div >TRƯỜNG ĐẠI HỌC</div>
                        <div >KỸ THUẬT - CÔNG NGHỆ CẦN THƠ</div>
                        <div style="font-weight:bold">HỘI ĐỒNG TUYỂN SINH 2023</div>
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
                        <div   > Thí sinh:&nbsp; <strong> {{$name_user}} </strong></div>
                    </td>
                    <td class=" border" width="50%">
                        <div   >Ngày sinh: &nbsp; {{$birth_user}} </div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" width="50%">
                        <div   >CMND/TCC:&nbsp; <strong>{{$id_card_users}} </strong> </div>
                    </td>
                    <td class=" border" width="50%">
                        <div   >Điện thoại:&nbsp;  {{$phone_users}} </div>
                    </td>
                </tr>
                <tr>
                    <td class=" border"  width="50%">
                        <div  > Giới tính:&nbsp; {{$sex_user}}</div>
                    </td>
                    <td class=" border" width="50%">
                        <div  >Năm tốt nghiệp: &nbsp; <strong> {{$graduation_year_user}} </strong></div>
                    </td>
                </tr>

                <tr>
                    <td  class=" border"width="50%">
                        <div   >Khu vực:&nbsp; <strong>{{$name_priority_area}}   </strong> </div>
                    </td>
                    <td  class=" border"  width="50%">
                        <div   >Đối tượng:&nbsp; <strong>{{$name_policy_user}}  </strong> </div>
                    </td>
                </tr>
                <tr>
                    <td class=" border" colspan = "2">
                        <div       ><strong> 2. Thông tin học tập</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class=" border"  colspan = "2">
                        <div       ><i><strong> i. Điểm học bạ cấp THPT</strong></i></div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th class="center"  >Lớp/HK</th>
                    @for ($i = 0;$i < count($sub_hb); $i++)
                        <th  class="center" >{{$sub_hb[$i]->name_subject}}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @if ($active_hb == 0)
                <tr>
                    <td colspan="{{count($sub_hb)}}"   >Lỗi hiện thị</td>
                </tr>
                @else
                <tr>
                    <td  class="center"  >Lớp 10 (CN)</td>
                    @for ($i = 0;$i < count($sub_hb); $i++)
                        @for ($j = 0;$j < count($mark_10); $j++)
                            @if ($sub_hb[$i]->id == $mark_10[$j]->id)
                                <td class="center"   > {{$mark_10[$j]->mark}}</td>
                                @break
                            @endif

                        @endfor
                    @endfor
                </tr>
                <tr>
                    <td  class="center"  >Lớp 11 (CN)</td>
                    @for ($i = 0;$i < count($sub_hb); $i++)
                        @for ($j = 0;$j < count($mark_11); $j++)
                            @if ($sub_hb[$i]->id == $mark_11[$j]->id)
                                <td  class="center"  > {{$mark_11[$j]->mark}}</td>
                                @break
                            @endif

                        @endfor
                    @endfor
                </tr>
                <tr>
                    <td class="center"   >Lớp 12 (CN)</td>
                    @for ($i = 0;$i < count($sub_hb); $i++)
                        @for ($j = 0;$j < count($mark_12); $j++)
                            @if ($sub_hb[$i]->id == $mark_12[$j]->id)
                                <td  class="center"  > {{$mark_12[$j]->mark}}</td>
                                @break
                            @endif

                        @endfor
                    @endfor
                </tr>
                <tr>
                    <td class="center"   >Lớp 12 (HK1)</td>
                    @for ($i = 0;$i < count($sub_hb); $i++)
                        @for ($j = 0;$j < count($mark_12hk1); $j++)
                            @if ($sub_hb[$i]->id == $mark_12hk1[$j]->id)
                                <td  class="center"  > {{$mark_12hk1[$j]->mark}}</td>
                                @break
                            @endif

                        @endfor
                    @endfor
                </tr>
                @endif

            </tbody>
        </table>
        <table>
            <tbody>
                <tr>
                    <tr>
                        <td class=" border"  colspan = "2">
                            <div       ><i><strong> ii. Điểm thi THPT Quốc gia</strong></i></div>
                        </td>
                    </tr>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th class="center"  >Môn</th>
                    @for ($i = 0;$i < count($sub_thpt); $i++)
                        <th  class="center" >{{$sub_thpt[$i]->name_subject}}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if ($active_thpt == 0)
                        <td colspan="{{count($sub_thpt)}}">Lỗi hiện thị</td>
                    @else
                    <td   >Điểm</td>
                        @for ($i = 0;$i < count($sub_thpt); $i++)
                            @for ($j = 0;$j < count($mark_thpt); $j++)
                                @if ($sub_thpt[$i]->id == $mark_thpt[$j]->id)
                                    <td class="center"   > {{$mark_thpt[$j]->mark}}</td>
                                    @break
                                @endif
                            @endfor
                        @endfor
                    @endif
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                <tr>
                    <tr>
                        <td class=" border"  colspan = "2">
                            <div    ><i><strong> iii. Điểm đánh giá năng lực:</strong>&nbsp;&nbsp;<span>{{$mark_nl}}</span></i></div>
                        </td>
                    </tr>
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
                    <th class="center" >Đủ ĐKTT</th>
                    <th class="center" >Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i <count($wish);$i++)
                    <tr>
                        <td class="center" >{{$wish[$i]->number_bo}}</td>
                        <td class="center" >{{$wish[$i]->id_method}}</td>
                        <td>{{$wish[$i]->name_major}}</td>
                        <td class="center" >{{$wish[$i]->name_group}}</td>
                        <td class="center" >{{$wish[$i]->group_mark}}</td>
                        <td class="center" >{{$wish[$i]->priority_mark}}</td>
                        <td class="center" >{{$wish[$i]->mark}}</td>
                        <td class="center" >{{$wish[$i]->tts}}</td>
                        <td class="center" >{{$wish[$i]->tt}}</td>
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
                    @for ($i = 0; $i< count($file);$i++)
                        @if ($i%2 === 0)
                        <tr>
                        @endif
                            <td class=" border" >
                                @if ($file[$i]->active == 1)
                                    <input type="checkbox" checked="checked" />&nbsp;&nbsp;<span>{{$file[$i]->name_file}}</span>
                                @else
                                    <input  type="checkbox">&nbsp;&nbsp;<span>{{$file[$i]->name_file}}</span>
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
                        <div     ><i> Cần Thơ, ngày {{$day}} tháng {{$month}} năm {{$year}} </i></div>
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
                    <td class=" center border" width="50%"      height = "100px" style="vertical-align: bottom">
                        <div><strong>{{$admin}}</strong></div>
                    </td>
                    <td  class=" center border " width="50%" height = "100x"     style="vertical-align: bottom">
                        <div><strong> {{{$name_user}}}</strong></div>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif --}}


</body>
</html>
