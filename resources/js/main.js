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
