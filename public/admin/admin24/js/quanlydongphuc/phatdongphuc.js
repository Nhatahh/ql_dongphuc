$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    //QUagga
    // var originalGioHangPosition;
    // async function startCamera() {
    //     try {
    //         const devices = await navigator.mediaDevices.enumerateDevices();
    //         const videoDevices = devices.filter(device => device.kind === 'videoinput');

    //         if (videoDevices.length === 0) {
    //             alert("Thiết bị của bạn không có camera. Vui lòng kiểm tra lại.");
    //             return;
    //         }

    //         let videoDeviceId = videoDevices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('rear'))?.deviceId
    //             || videoDevices[0].deviceId;

    //         const stream = await navigator.mediaDevices.getUserMedia({
    //             video: { deviceId: videoDeviceId ? { exact: videoDeviceId } : undefined }
    //         });

    //         videoElement.srcObject = stream;
    //         videoElement.setAttribute("playsinline", true);
    //         videoElement.play();

    //         videoElement.addEventListener('loadedmetadata', () => {
    //             if (videoElement.videoWidth === 0 || videoElement.videoHeight === 0) {
    //                 alert('Không thể truy cập vào camera hoặc camera không hoạt động. Vui lòng thử lại.');
    //                 stopCamera();
    //                 stream.getTracks().forEach(track => track.stop());
    //             } else {
    //                 console.log('Video loaded:', videoElement.videoWidth, videoElement.videoHeight);
    //                 startQuagga(); // Khởi động Quagga ngay sau khi video đã sẵn sàng
    //             }
    //         });

    //         window.scrollTo({ top: 0, behavior: 'smooth' });
    //         const modal = document.getElementById('scannerModal');
    //         const newContainer = document.getElementById("tmp");
    //         if (modal) modal.classList.add('show');
    //         if (window.innerWidth <= 567) {
    //             // SetUp modal
    //             originalGioHangPosition = document.getElementById("giohang").style.marginTop;
    //             setTimeout(() => document.body.classList.add('no-scroll'), 300);
    //             setTimeout(() => {
    //                 const gioHang = document.getElementById("giohang");
    //                 originalGioHangPosition = gioHang.style.position; // Lưu vị trí ban đầu
    //                 gioHang.style.position = "absolute"; // Đảm bảo gioHang có position absolute
    //                 gioHang.style.top = "0"; // Đặt gioHang vào vị trí trên cùng của newContainer
    //                 gioHang.style.marginLeft = "5%"; // Đặt margin-left là 5%
    //                 gioHang.style.width = "85%"; // Đặt width là 85%

    //                 newContainer.appendChild(gioHang); // Di chuyển gioHang vào newContainer
    //             }, 300);
    //         }

    //     } catch (error) {
    //         console.error('Không thể khởi động camera:', error);
    //         stopCamera();
    //         alert('Không thể truy cập vào camera. Vui lòng kiểm tra quyền truy cập và thử lại.');
    //     }
    // }
    // function startQuagga() {
    //     if (typeof Quagga === 'undefined') {
    //         return console.error("Thư viện Quagga chưa được tải!");
    //     } else {
    //         console.log('Bắt đầu mở Quagga');
    //         alert('Bắt đầu mở Quagga');
    //         Quagga.init({
    //             inputStream: {
    //                 name: "Live",
    //                 type: "LiveStream",
    //                 target: document.getElementById("camera"),
    //                 constraints: {
    //                     facingMode: "environment",
    //                     width: 1280, // Đặt chiều rộng lớn hơn
    //                     height: 720, // Đặt chiều cao lớn hơn
    //                 },
    //             },
    //             decoder: {
    //                 readers: [
    //                     "code_128_reader",
    //                     "ean_reader"
    //                 ]
    //             }
    //         }, function(err) {
    //             if (err) {
    //                 console.log(err);
    //                 return;
    //             }
    //             console.log("Quagga đang chạy...");
    //             Quagga.start();

    //             // Bắt đầu quét mã QR sau khi Quagga khởi động
    //             // Di chuyển `onDetected` ra ngoài để thiết lập sau khi `init` thành công
    //             Quagga.onDetected(function(data) {
    //                 console.log('Đã quét được...');
    //                 alert('Đã vào dc quét');
    //                 const decodedText = data.codeResult.code;
    //                 console.log("Mã sản phẩm:", decodedText);
    //                 cart_Database_QR(decodedText); // Thực hiện hành động với mã đã quét
    //                 continue_QR(); // Hỏi người dùng có muốn tiếp tục quét hay không
    //                 Quagga.stop(); // Dừng Quagga sau khi phát hiện mã vạch
    //             });
    //         });
    //         // Quagga.init({
    //         //     inputStream: {
    //         //         name: "Live",
    //         //         type: "LiveStream",
    //         //         target: document.getElementById("camera"), // Phần tử để hiển thị video từ camera
    //         //         constraints: {
    //         //             facingMode: "environment", // Sử dụng camera chính
    //         //             width: 1280,
    //         //             height: 720,
    //         //         },
    //         //     },
    //         //     decoder: {
    //         //         readers: ["code_128_reader", "ean_reader", "upc_reader", "qr_reader"], // Thêm 'qr_reader' để quét mã QR
    //         //         locate: true // Tự động xác định vị trí mã QR
    //         //     }
    //         // }, function(err) {
    //         //     if (err) {
    //         //         console.log('Đã có lỗi');
    //         //         alert('Đã có lỗi');
    //         //         console.log(err);
    //         //         return;
    //         //     }
    //         //     console.log("Quagga đang chạy...");
    //         //     Quagga.start(); // Bắt đầu quét
    //         // });


    //     }
    // }
    // // Hàm dừng camera và quét
    // function stopCamera() {
    //     const gioHang = document.getElementById("giohang");
    //     const originalContainer = document.getElementById("giohangContainer"); // Container ban đầu của gioHang
    //     originalContainer.appendChild(gioHang); // Di chuyển gioHang về container ban đầu
    //     gioHang.style.position = originalGioHangPosition; // Khôi phục vị trí ban đầu
    //     gioHang.style.top = ""; // Reset top nếu cần
    //     gioHang.style.marginLeft = "";
    //     gioHang.style.marginRight = "";
    //     gioHang.style.width = "95%";
    //     document.body.classList.remove('no-scroll');

    //     // Dừng Quagga nếu nó đang hoạt động
    //     if (typeof Quagga !== 'undefined' && Quagga.running) {
    //         Quagga.stop();
    //     }else{
    //         console.log('thư viện Quagga chưa có')
    //     }

    //     // Dừng camera
    //     const videoElement = document.getElementById("videoElement"); // Đảm bảo phần tử video có id là 'camera'
    //     if (videoElement && videoElement.srcObject) {
    //         const stream = videoElement.srcObject;
    //         const tracks = stream.getTracks();

    //         tracks.forEach(track => track.stop()); // Dừng tất cả các track của camera
    //         videoElement.srcObject = null; // Xóa srcObject để ngăn video tiếp tục phát
    //     }

    //     // Đóng modal
    //     const modal = document.getElementById('scannerModal');
    //     if (modal) modal.classList.remove('show');
    //     $('#scannerModal').hide();
    //     $('#videoContainer').hide();
    // }
    // // Sự kiện khởi động quét
    // $('#startScan').on('click', function() {
    //     $('#scannerModal').show();
    //     $('#videoContainer').show();
    //     startCamera();
    // });

    // // Sự kiện đóng modal
    // $('#closeModal').on('click', function() {
    //     stopCamera();
    // });

    $(window).on('click', function(event) {
        if (event.target.id === 'scannerModal') {
            stopCamera();
        }
    });


    //Kết thúc QR
    $(window).resize(function() {
        setEqualHeight();
    });

    setEqualHeight()
    Responsive()
    // select_dot_phat()
    $(".slect_dongphuc").select2();
    $("#ds_dongphuc_filter").hide()
    change_sl_ban()
    window.addEventListener('resize', adjustView1);
    adjustView1()
    localStorage.removeItem('cart');



    $('.select_dotphat').select2({
        allowClear: true
    });

});
    //JsQr
    var originalGioHangPosition;

    async function startCamera() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');

            if (videoDevices.length === 0) {
                alert("Thiết bị của bạn không có camera. Vui lòng kiểm tra lại.");
                return;
            }

            // Tìm camera sau, nếu không có thì lấy camera đầu tiên
            let videoDeviceId = videoDevices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('rear'))?.deviceId
                || videoDevices[0].deviceId;

            const stream = await navigator.mediaDevices.getUserMedia({
                video: { deviceId: videoDeviceId ? { exact: videoDeviceId } : undefined }
            });

            videoElement.srcObject = stream;
            videoElement.setAttribute("playsinline", true);
            videoElement.play();

            videoElement.addEventListener('loadedmetadata', () => {
                if (videoElement.videoWidth === 0 || videoElement.videoHeight === 0) {
                    alert('Không thể truy cập vào camera hoặc camera không hoạt động. Vui lòng thử lại.');
                    stopCamera();
                    stream.getTracks().forEach(track => track.stop());
                } else {
                    console.log('Video loaded:', videoElement.videoWidth, videoElement.videoHeight);
                    requestAnimationFrame(scanQRCode);
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
            const modal = document.getElementById('scannerModal');
            const newContainer = document.getElementById("tmp");
            if (modal) modal.classList.add('show');
            if (window.innerWidth <= 567) {
                const gioHang = document.getElementById("giohang");

                originalGioHangPosition = gioHang.style.marginTop;
                gioHang.style.visibility = 'hidden';
                gioHang.style.opacity = '0';

                setTimeout(() => {
                    gioHang.style.position = "absolute";
                    gioHang.style.top = "0";
                    gioHang.style.marginLeft = "5%";
                    gioHang.style.width = "85%";
                    newContainer.appendChild(gioHang);

                    setTimeout(() => {
                        gioHang.style.visibility = 'visible';
                        gioHang.style.opacity = '1';
                        gioHang.style.transition = 'opacity 0.5s ease';
                    }, 10);

                }, 300);
            }

        } catch (error) {
            console.error('Không thể khởi động camera:', error);
            stopCamera();
            alert('Không thể truy cập vào camera. Vui lòng kiểm tra quyền truy cập và thử lại.');
        }
    }


    // Thêm thời gian tạm ngừng giữa các lần quét
    let lastScanTime = 0;
    const scanInterval = 1000; // Đặt thời gian chờ giữa các lần quét (500ms)

    function scanQRCode() {
        setTimeout(() => {
            const now = Date.now();
            if (now - lastScanTime < scanInterval) {
                requestAnimationFrame(scanQRCode);
                return;
            }
            lastScanTime = now;

            if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
                const canvasElement = document.createElement('canvas');
                const canvasContext = canvasElement.getContext('2d');

                if (videoElement.videoWidth > 0 && videoElement.videoHeight > 0) {
                    canvasElement.height = videoElement.videoHeight;
                    canvasElement.width = videoElement.videoWidth;
                    canvasContext.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
                    const imageData = canvasContext.getImageData(0, 0, canvasElement.width, canvasElement.height);
                    const code = jsQR(imageData.data, canvasElement.width, canvasElement.height);
                    if (code) {
                        onDetected(code.data);
                    }
                }
            }

            requestAnimationFrame(scanQRCode)
            }, 1500);
    }

    function onDetected(decodedText) {
        if (decodedText) {
            console.log("Mã sản phẩm:", decodedText);
            cart_Database_QR(decodedText);

        } else {
            alert("Đã có lỗi xảy ra khi quét");
            console.log("Lỗi khi quét");
            stopCamera();
        }
    }

    function continue_QR() {
        const userConfirmed = confirm("Đã thêm sản phẩm vào giỏ hàng thành công! Bạn có muốn tiếp tục quét mã vạch không?");
        if (!userConfirmed) {
            stopCamera();
        }
    }

    function stopCamera() {
        const gioHang = document.getElementById("giohang");
        const originalContainer = document.getElementById("giohangContainer"); // Giả sử đây là container ban đầu của giohang
        if (window.innerWidth <= 567) {
            // Bắt đầu ẩn giỏ hàng với hiệu ứng
            gioHang.style.transition = 'opacity 0.5s ease'; // Đặt hiệu ứng chuyển đổi
            gioHang.style.opacity = '0'; // Giảm độ mờ về 0

            // Đợi cho hiệu ứng hoàn thành trước khi di chuyển giỏ hàng
            setTimeout(() => {
                // Di chuyển giỏ hàng về container ban đầu
                originalContainer.appendChild(gioHang);
                // Khôi phục vị trí và kiểu CSS về trạng thái ban đầu
                gioHang.style.position = ""; // Khôi phục vị trí ban đầu
                gioHang.style.top = ""; // Reset top nếu cần
                gioHang.style.marginLeft = ""; // Reset margin-left
                gioHang.style.marginRight = ""; // Reset margin-right
                gioHang.style.width = "95%"; // Thiết lập chiều rộng

                // Hiển thị lại giỏ hàng với opacity
                gioHang.style.opacity = '1'; // Đặt độ mờ về 1 để hiện lại
                gioHang.style.visibility = 'visible'; // Đảm bảo giỏ hàng có thể nhìn thấy
            }, 500); // Thời gian chờ trước khi di chuyển giỏ hàng (phải bằng thời gian hiệu ứng)
        }

            // Tắt camera
            const stream = videoElement.srcObject;
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            videoElement.srcObject = null;

            // Đóng modal scanner nếu có
            const modal = document.getElementById('scannerModal');
            if (modal) {
                modal.classList.remove('show');
                $('#scannerModal').hide('slow');
            }

            // Ẩn container video
            $('#videoContainer').hide();

            // Khôi phục trạng thái của body
            document.body.classList.remove('no-scroll');


    }

    $('#startScan').on('click', function() {
        $('#scannerModal').show('slow');
        setTimeout(() => {
            $('#videoContainer').show('slow');
        }, 50);
        startCamera();
    });

    $('#closeModal').on('click', function() {
        stopCamera();
    });
//Thêm giỏ hàng bằng QR
async function cart_Database_QR(masp) {
    // var val_sl = $('#soluong_ban_' + id_loai).val();
    // var id_sanpham = $('#select_size_' + id_loai).val();
    const check = await laythongtincheckquyen(11);
    var id_dotphat = $('#select_dotphat').val();
    var id_nguoinhan = $('#ten_sv').attr('id_taikhoan');
    if(id_nguoinhan == null || id_nguoinhan ==''){
        if(id_dotphat == 0 || id_dotphat == ""){
            return toastr.warning('Vui lòng chọn đợt phát')
        }else{
            return toastr.warning('Vui lòng nhập đúng căn cước công dân để tìm sinh viên')
        }
    }
    $('#modal_event').show();
    $.ajax({
        type: "post",
        url: "/admin24/cart_Database_QR",
        data: {
            // val_sl: val_sl,
            // id_sanpham: id_sanpham,
            masp: masp,
            id_nguoinhan: id_nguoinhan,
            id_dotphat: id_dotphat,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 11,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if(res.trangthai==1){
                toastr.success("Đã thêm sản phẩm vào giỏ hàng!!")
                draw_cart(res.noidung)
                continue_QR();
            }else{
                stopCamera()
                if(res.kieudulieu=="json"){
                    var data = Object.values(res.noidung);
                    var message = data[0][0]; // Lấy thông báo lỗi từ phần tử đầu tiên của mảng lỗi
                    toastr.warning(message);

                }else{
                    thongbao(res.noidung)
                }
            }
        }
    });
}
//Tìm kiếm sinh viên
async function phatdongphuc_timkiem() {
    const check = await laythongtincheckquyen(11);
        $('#modal_event').show();
        let cccd_sv=$('#cccd_sv').val()
        let mssv_dp=$('#mssv_dp').val()
        var id_dotphat = $('#select_dotphat').val();

        $.ajax({
            type: 'get',
            url: '/admin24/phatdongphuc_timkiem',
            data: {
                cccd_sv : cccd_sv,
                mssv_dp : mssv_dp,
                id_dotphat : id_dotphat,
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 11,
                active: 1,
            },
            success: function(res) {
                $('#modal_event').hide();
                if(res.trangthai==1){
                    var html =  res.noidung['hoten'];
                    $('#ten_sv').html(html);
                    $('#ten_sv').attr('id_taikhoan',res.noidung['id_taikhoan']);
                    draw_cart(res.cart)
                }else if(res.trangthai == 3){
                    thongbao(res.noidung)
                }else{
                    $('#ten_sv').html('');
                    draw_cart(res.cart)
                    $('#ten_sv').attr('id_taikhoan','');
                    // var data = Object.values(res.noidung['original'])
                    // toastr.warning(data[0]);
                }

                // if(res.trangthai==1){
                //     var html =  res.noidung['hoten'];
                //     $('#ten_sv').html(html);
                //     $('#ten_sv').attr('id_taikhoan',res.noidung['id_taikhoan']);
                //     draw_cart(res.cart)
                //     Livewire.emit('get_cccdsv',cccd_sv);
                // }else if(res.trangthai==2){
                //     if(cccd_sv.length == 12){
                //         toastr.warning("Không tìm thấy thông tin sinh viên")
                //     }
                //     $('#ten_sv').html('');
                // }else{
                //     var data = Object.values(res.noidung['original'])
                //     toastr.warning(data[0]);
                // }
            }
        })
}
// Gán sự kiện onchange cho input và select
$('#cccd_sv').on('change', phatdongphuc_timkiem);
$('#select_dotphat').on('change', phatdongphuc_timkiem);
$('#mssv_dp').on('change', phatdongphuc_timkiem);
async function phat_dongphuc(kieu){
    const check = await laythongtincheckquyen(11);
    var cccd = $('#cccd_sv').val();
    var email = $('#email_sv').text();
    var result = {};
    var loaisanpham = document.getElementsByClassName('loaisanpham')
    for (let i = 0; i < loaisanpham.length; i++) {
        var id_loai = $(loaisanpham[i]).attr('id_loai')
        var idsp =  $(loaisanpham[i]).val()
        var value = $('#soluong_ban_'+id_loai).val();
        if (value > 0 && value != null && !isNaN(value)) {
            result[idsp] = value;
        }
    }
    if($('#ten_sv').text() != ''){
        $('#modal_event').show();
        $.ajax({
            type: "post",
            url: "/admin24/phat_dongphuc",
            data: {
                result: result,
                cccd: cccd,
                time: check[1],
                id_manhinh: check[0],
                id_chucnang: 11,
                active: 1,
            },
            success: function(res) {
                $('#modal_event').hide();
                if (res.trangthai == 1) {
                    if(kieu==1){
                        var pri = confirm("Có muốn in hóa đơn ?!")
                        if (pri == true){
                            // location.reload()
                            window.open("https://dichvucong.ctuet.edu.vn/admin24/in_hoadon/"+res.mahoadon, "_blank");
                        }

                    }else{
                        thongbao(res.noidung);
                        $('.sl_ban').val(0);
                        phatdongphuc_timkiem()
                        // $('.sl_ban').val(0)
                    }
                } else {
                    if (res.kieudulieu == 'json') {
                        var data = Object.values(res.noidung['original'])
                        toastr.warning(data[0]);
                    } else {
                        thongbao(res.noidung);
                    }
                }
            }
        })
    }else{
        toastr.warning('Chưa tìm kiếm sinh viên')
    }
}
function change_sl_ban() {
    // Sử dụng phương thức .on() để gắn sự kiện cho các phần tử được thêm động
    $(document).on('click', '.decrease', function() {
        let input = $(this).siblings('input');
        let value = parseInt(input.val());
        if (value >= 1) {
            input.val(value - 1);
        }
    });
    $(document).on('click', '.increase', function() {
        let input = $(this).siblings('input');
        let value = parseInt(input.val());
        input.val(value + 1);
    });



    $(document).on('input', '.nguyenvong', function() {
        let value = $(this).val().replace(/\D/g, ''); // Loại bỏ các ký tự không phải số
        $(this).val(value);
    });
}
//Reponsive
function adjustView1() {

    var nhapMobile = document.getElementsByClassName('pdphd_mobile');
    var nhapPc = document.getElementsByClassName('pdphd_pc');
    // phatdongphuc_timkiem()
    if (window.innerWidth <= 567) {
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'block';
        }
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'none';
        }
    } else {
        for (var i = 0; i < nhapPc.length; i++) {
            nhapPc[i].style.display = 'block';
        }
        for (var i = 0; i < nhapMobile.length; i++) {
            nhapMobile[i].style.display = 'none';
        }
    }
}
async function cart_Database(id_loai) {
    const check = await laythongtincheckquyen(11);
    var val_sl = $('#soluong_ban_' + id_loai).val();
    var id_sanpham = $('#select_size_' + id_loai).val();
    var id_dotphat = $('#select_dotphat').val();
    var id_nguoinhan = $('#ten_sv').attr('id_taikhoan');
    if(id_nguoinhan == null || id_nguoinhan ==''){
        if(id_dotphat == 0 || id_dotphat == ""){
            return toastr.warning('Vui lòng chọn đợt phát')
        }else{
            return toastr.warning('Vui lòng nhập đúng căn cước công dân để tìm sinh viên')
        }
    }
    $('#modal_event').show();
    $.ajax({
        type: "post",
        url: "/admin24/cart_Database",
        data: {
            val_sl: val_sl,
            id_sanpham: id_sanpham,
            id_nguoinhan: id_nguoinhan,
            id_dotphat: id_dotphat,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 11,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if(res.trangthai==1){
                toastr.success("Đã thêm sản phẩm vào giỏ hàng!!")
                draw_cart(res.noidung)
            }else{
                if(res.kieudulieu=="json"){
                    var data = Object.values(res.noidung);
                    var message = data[0][0]; // Lấy thông báo lỗi từ phần tử đầu tiên của mảng lỗi
                    toastr.warning(message);
                }else{
                    thongbao(res.noidung)
                }
            }
        }
    });
}
function draw_cart(res) {
    let carts = $('#carts_pc');
    let html = '';
    if (res.length > 0) {
        $('#group_phatdongphuc').css('display', 'block');
        res.forEach(function(item) {
            html += `<div id="item_${item.id_cart}" style="margin-bottom:5px;" class="col-12 col-sm-12 col-md-12">
                        <div class="row">

                            <label  id_loai='${item.id_loai}' id_cart="${item.id_cart}" class="col-5 col-sm-5 col-md-5" style="padding-top: 5px; font-weight:light;">
                                ${item.ten_loai} (${item.ten_size})
                            </label>
                            <div style="text-align:center;" class="col-6 col-sm-6 col-md-6">
                                <div class="_9m0o30 shopee-input-quantity">
                                    <button style="width:30px" class="suQW3X decrease_cart" onclick="update_sl(-1, ${item.id_cart}, event)"> - </button>
                                    <input  onchange="update_input_sl(this.value, ${item.id_cart}, event)" style="width:30px" value="${item.tong_soluong}" class="suQW3X u00pLG nguyenvong sl_ban" id="soluong_ban_cart_${item.id_cart}" id_cart="${item.id_cart}" id_loai="${item.id_loai}" type="text">
                                    <button style="width:30px" class="suQW3X increase_cart" onclick="update_sl(1, ${item.id_cart}, event)"> + </button>
                                </div>
                            </div>
                            <div style="padding-top: 7px; font-weight:light;" class="col-1 col-sm-1 col-md-1" style="text-align: right;">
                                <i onclick='remove_from_cart("${item.id_cart}","${item.id_nguoinhan}","${item.id_dotphat}","${item.id_nguoiphat}")' class="fa-solid fa-xmark"></i>
                            </div>
                        </div>
                        <div style="margin-top:5px;" class="style_all_button"></div>
                    </div>`;
        });
    } else {
        $('#group_phatdongphuc').css('display', 'none');
        html = `<div style="font-weight:light;text-align:center"><span class="">Chưa có sản phẩm</span></div>`;
    }
    carts.html(html);
    carts.animate({ scrollTop: carts[0].scrollHeight }, 500);
}
function remove_from_cart(id_cart, id_nguoinhan, id_dotphat, id_nguoiphat) {
    // Hiển thị hộp thoại xác nhận trước khi thực hiện xóa
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        $.ajax({
            type: "post",
            url: "/admin24/remove_from_cart/" + id_cart + "/" + id_nguoinhan + "/" + id_dotphat + "/" + id_nguoiphat,
            success: function(res) {
                if (res.trangthai == 1) {
                    thongbao(res.noidung);
                    draw_cart(res.res);
                } else {
                    thongbao(res.noidung);
                }
            }
        });
    }
}

function Reset_sl(id_loai){
    $('#soluong_ban_'+id_loai).val(0)
}
function update_sl(sl, id_cart, event) {
    var sl_hientai = parseInt($('#soluong_ban_cart_' + id_cart).val());
    // var id_loai = $('#soluong_ban_cart_' + id_cart).attr('id_loai');
    var buttonClicked = $(event.target);
    buttonClicked.prop('disabled', true);

    // Kiểm tra nếu số lượng hiện tại cộng với sl bằng 0
    if ((sl_hientai + sl) === 0) {
        var confirmDelete = confirm("Số lượng sẽ về 0. Bạn có chắc chắn muốn cập nhật?");
        if (!confirmDelete) {
            // Nếu người dùng không đồng ý, bật lại nút và thoát khỏi hàm
            buttonClicked.prop('disabled', false);
            return;
        }
    }

    // Gửi yêu cầu AJAX để cập nhật số lượng
    $.ajax({
        type: "post",
        url: "/admin24/update_sl",
        data: {
            id_cart: id_cart,
            sl: sl,
            sl_hientai: sl_hientai,
        },
        success: function(res) {
            buttonClicked.prop('disabled', false);
            if (res.trangthai == 1) {
                toastr.success("Cập nhật số lượng sản phẩm thành công");
                draw_cart(res.noidung);
            } else {
                thongbao(res.noidung);
            }
        },
    });
}

function update_input_sl(sl, id_cart, event) {
    var id_loai = $('#soluong_ban_cart_' + id_cart).attr('id_loai');
    var buttonClicked = $(event.target);
    buttonClicked.prop('disabled', true);

    // Kiểm tra nếu số lượng bằng 0
    if (sl == 0) {
        var confirmDelete = confirm("Số lượng sẽ về 0. Bạn có chắc chắn muốn cập nhật?");
        if (!confirmDelete) {
            // Nếu người dùng không đồng ý, bật lại nút và thoát khỏi hàm
            buttonClicked.prop('disabled', false);
            return;
        }
    }
    // Gửi yêu cầu AJAX để cập nhật số lượng
    $.ajax({
        type: "post",
        url: "/admin24/update_input_sl",
        data: {
            id_cart: id_cart,
            sl: sl,
        },
        success: function(res) {
            buttonClicked.prop('disabled', false);
            if (res.trangthai == 1) {
                toastr.success("Cập nhật số lượng sản phẩm thành công");
                draw_cart(res.noidung);
            } else {
                thongbao(res.noidung);
            }
        },
    });
}

async function phat_dong_phuc(){
    const check = await laythongtincheckquyen(11);
    var id_nguoinhan = $('#ten_sv').attr('id_taikhoan');
    var id_dotphat = $('#select_dotphat').val();
    $('#modal_event').show();
    $.ajax({
        type: "post",
        url: "/admin24/phat_dong_phuc",
        data: {
            id_dotphat: id_dotphat,
            id_nguoinhan: id_nguoinhan,
            time: check[1],
            id_manhinh: check[0],
            id_chucnang: 11,
            active: 1,
        },
        success: function(res) {
            $('#modal_event').hide();
            if(res.trangthai==1){
                thongbao(res.noidung)
                var pri = confirm("Đã phát thành công.Có muốn in hóa đơn ?!")
                if (pri == true){
                    window.open("https://congmotcua.ctuet.edu.vn/admin24/in_hoadon/"+res.mahoadon, "_blank");
                }
                $('.sl_ban').val(0);
                $('#cccd_sv').val('');
                $('#ten_sv').html('');
                $('.select_size_phat_sp').val(0).trigger('change');
                $('.select_dotphat').val(0).trigger('change');
                draw_cart(res.get_giohang_new)
            }else if(res.trangthai == 3){
                toastr.warning(res.sanpham_0_hople)
            }else{
                thongbao(res.noidung)
            }
        }
    });
}

function Responsive() {
    const danhmucContainer = document.getElementById("danhmuc_sp_container");
    const cartsContainer = document.getElementById("carts_pc");


    // Mobile
    if (window.innerWidth <= 567) {


        danhmucContainer.style.maxHeight = "360px";
        cartsContainer.style.maxHeight = "300px";
        cartsContainer.style.minHeight = "100px";
        cartsContainer.style.overflowY = "auto";
    } else {


        danhmucContainer.style.maxHeight = "500px";
        cartsContainer.style.maxHeight = "250px";
        cartsContainer.style.overflowY = "auto";
    }
}




function setEqualHeight() {
    var maxHeight = 0;

    // Đặt chiều cao về auto để tính lại
    $('.thongtin_sanpham_loai_nsx').css('height', 'auto');

    // Tìm chiều cao lớn nhất
    $('.thongtin_sanpham_loai_nsx').each(function() {
        var thisHeight = $(this).outerHeight();
        if (thisHeight > maxHeight) {
            maxHeight = thisHeight;
        }
    });

    // Đặt chiều cao cho tất cả các div bằng chiều cao lớn nhất
    $('.thongtin_sanpham_loai_nsx').css('height', maxHeight);
}
// Gọi hàm Reponsive khi tải trang và khi thay đổi kích thước cửa sổ trình duyệt
window.onload = Responsive();
window.onresize = Responsive();














function Upload_ttsv(){
    $('#upload_ttsv_open').click();
}

$('#upload_ttsv_open').on('change', function(){
    $('#submit_Upload_ttsv_open').submit();
})

// function import_upload_ttsv(){
//     $('#submit_Upload_ttsv_open').submit();
// }

$('#submit_Upload_ttsv_open').on('submit', function(e){
    e.preventDefault();
    $('#modal_event').show();
    $.ajax({
        url: "/admin24/upload_ttsv",
        type:"POST",
        data: new FormData(this),
        contentType:false,
        processData:false,
        success:function(data){
            var wb = XLSX.utils.book_new();
            var header = [ 'EMAIL','CCCD','HỌ TÊN','NGÀY SINH','GIỚI TÍNH','SĐT','MSSV','TÊN LỚP','MÃ LỚP','GHI CHÚ'];
            var tdata = [ header ];
            data.forEach((row,index) => {
                if(index > 0){
                    var rowData = [];
                    row.forEach(function(col) {
                        rowData.push(col)
                    });
                    tdata.push(rowData);
                }
            })
            var ws = XLSX.utils.aoa_to_sheet(tdata);
            XLSX.utils.book_append_sheet(wb, ws, "Thongke");
            var ws1 = XLSX.utils.aoa_to_sheet(tdata);
            XLSX.utils.book_append_sheet(wb, ws1, "Thongke1");
            XLSX.writeFile(wb, "thongkeuploadsinhvien.xlsx");
            $('#modal_event').hide();
        }
    });
})



