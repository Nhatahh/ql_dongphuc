$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // dm_select2();
});

// function dm_select2() {
//     $.ajax({
//         url: "/dm_select2",
//         type: "GET",
//         dataType: "json",
//         success: function (res) {
//             console.log("Dữ liệu:", res);

//             $("#dm_Select2").select2({
//                 data: res,
//             });
//         },
//         error: function (xhr) {
//             console.error("Lỗi khi lấy dữ liệu:", xhr);
//         },
//     });
// }

function changeQuantity(button, change) {
    const input = $(button).siblings("input.quantity-input");
    let sl = parseInt(input.val()) || 1;
    let new_sl = sl + change;

    if (new_sl < 1) {
        new_sl = 1;
    }

    input.val(new_sl);
}

$(".btn_update_quantity").on("click", function () {
    // setTimeout(() => {
    let gh_id = $(this).data("id");
    console.log(gh_id);
    let soluong = $("#soluong_" + gh_id).val();
    $(".err_soluong").text("");

    $.ajax({
        url: "/cart/update-quantity",
        method: "POST",
        data: {
            gh_id: gh_id,
            soluong: soluong,
        },
        success: function (response) {
            switch (response) {
                case "1":
                    toastr.success("Cập nhật số lượng thành công!");
                    location.reload();
                    break;
                case "0":
                    toastr.warning("Sản phẩm không tồn tại trong giỏ hàng!");
                    break;
                case "-1":
                    toastr.error("Hệ thống bị lỗi, vui lòng thử lại sau!");
                    break;
                default:
                    const keys = Object.keys(response);
                    for (let i = 0; i < keys.length; i++) {
                        $("#err_soluong_" + keys[i]).text(response[keys[i]]);
                    }
                    break;
            }
        },
        error: function (xhr, status, error) {
            toastr.error("Lỗi kết nối đến máy chủ!");
            console.error(xhr.responseText);
        },
    });
    // }, 1000);
});

// Xóa sản phẩm
$(".btn-delete").on("click", function () {
    var gh_id = $(this).data("id");
    Swal.fire({
        title: "Xác nhận xóa?",
        text: "Bạn có chắc chắn muốn xóa mục này không?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đồng ý",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(() => {
                $.ajax({
                    url: "/cart/delete/" + gh_id,
                    type: "DELETE",
                    success: function (response) {
                        switch (response) {
                            case "1":
                                toastr.success("Xóa sản phẩm thành công!");
                                table.ajax.reload();
                                break;
                            case "0":
                                toastr.warning("Xóa sản phẩm thất bại!");
                                break;
                            default:
                                toastr.error(
                                    "Hệ thống bị lỗi, vui lòng tải lại trang hoặc liên hệ quản trị viên!"
                                );
                                break;
                        }
                    },
                });
            }, 1000);
        }
    });
});

// function showProductDetail(sp_id) {
//     $.ajax({
//         url: "/show_detail/" + sp_id,
//         type: "GET",
//         success: function (res) {
//             if (res.status === "success") {
//                 // Xử lý dữ liệu sản phẩm trả về
//                 const sanpham = res.sanpham;
//                 const detailHtml = `
//                         <h3>${sanpham.tensp}</h3>
//                         <img src="{{ asset('images/') }}/${sanpham.image_url}" alt="${sanpham.tensp}" class="img-fluid">
//                         <p><strong>Giá:</strong> ${sanpham.gia} VND</p>
//                         <p><strong>Mô tả:</strong> ${sanpham.mota}</p>
//                         <p><strong>Size:</strong> ${sanpham.size}</p>
//                     `;
//             } else {
//                 toastr.error(res.message); // Hiển thị lỗi nếu không tìm thấy sản phẩm
//             }
//         },
//         error: function () {
//             toastr.error("Có lỗi xảy ra khi tải chi tiết sản phẩm.");
//         },
//     });
// }
// function changeQuantity(button, delta) {
//     const input = button.parentElement.querySelector("input[type=number]");
//     let value = parseInt(input.value) + delta;
//     if (value < 1) value = 1;
//     input.value = value;

//     const gh_id = input.getAttribute("data-kho-id");

//     fetch("/update-cart", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": "{{ csrf_token() }}",
//         },
//         body: JSON.stringify({
//             gh_id: gh_id,
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
