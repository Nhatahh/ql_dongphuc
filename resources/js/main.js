$(document).ready(function () {
    dm_select2();
});

function dm_select2() {
    $.ajax({
        url: "/dm_select2",
        type: "GET",
        dataType: "json",
        success: function (res) {
            console.log("Dữ liệu:", res);

            $("#dm_Select2").select2({
                data: res,
            });
        },
        error: function (xhr) {
            console.error("Lỗi khi lấy dữ liệu:", xhr);
        },
    });
}

$(".btn-update-quantity").on("click", function () {
    let kho_id = $(this).data("kho-id");
    let soluong = $("#soluong_" + kho_id).val();
    $(".err_soluong").text(""); // clear lỗi

    $.ajax({
        url: "{{ route('cart.updateQuantity') }}", // Route xử lý
        method: "POST",
        data: {
            kho_id: kho_id,
            soluong: soluong,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            switch (response) {
                case "1":
                    toastr.success("Cập nhật thành công");
                    // location.reload(); // nếu muốn reload lại trang
                    break;
                case "0":
                    toastr.warning("Sản phẩm không tồn tại trong giỏ hàng");
                    break;
                case "-1":
                    toastr.error("Hệ thống lỗi");
                    break;
                default:
                    const keys = Object.keys(response);
                    for (let i = 0; i < keys.length; i++) {
                        $("#err_soluong_" + keys[i]).text(response[keys[i]]);
                    }
                    break;
            }
        },
    });
});

// function changeQuantity(button, delta) {
//     const input = button.parentElement.querySelector("input[type=number]");
//     let value = parseInt(input.value) + delta;
//     if (value < 1) value = 1;
//     input.value = value;

//     const kho_id = input.getAttribute("data-kho-id");

//     fetch("/update-cart", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": "{{ csrf_token() }}",
//         },
//         body: JSON.stringify({
//             kho_id: kho_id,
//             soluong: quantity,
//         }),
//     })
//         .then((response) => response.json())
//         .then((data) => {
//             if (data.success) {
//                 console.log("Đã cập nhật giỏ hàng.");
//             } else {
//                 alert("Cập nhật thất bại!");
//             }
//         });
// }

// function showDetailAction() {
//     const imgMain = document.querySelector(".product-img__main");
//     const imgExtra = document.querySelectorAll(".product-img__extra-item");

//     imgExtra.forEach((item) => {
//         item.onclick = () => {
//             if (imgMain && item) {
//                 imgMain.src = item.src;
//             }
//         };
//     });
// }

// document.addEventListener("DOMContentLoaded", function () {});
