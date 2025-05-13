$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });



});

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
function showProductDetail(sp_id) {
    $.ajax({
        url: "/show_detail/" + sp_id, // Gửi yêu cầu tới route đã định nghĩa
        type: "GET",
        success: function (res) {
            if (res.status === "success") {
                // Xử lý dữ liệu sản phẩm trả về
                const sanpham = res.sanpham;
                const detailHtml = `
                          <h3>${sanpham.tensp}</h3>
                          <img src="{{ asset('images/') }}/${sanpham.image_url}" alt="${sanpham.tensp}" class="img-fluid">
                          <p><strong>Giá:</strong> ${sanpham.gia} VND</p>
                          <p><strong>Mô tả:</strong> ${sanpham.mota}</p>
                          <p><strong>Size:</strong> ${sanpham.size}</p>
                      `;
                // Hiển thị thông tin chi tiết sản phẩm trong modal hoặc nơi bạn muốn
                $("#product-detail-container").html(detailHtml); // Ví dụ sử dụng modal hoặc một div cụ thể
                $("#product-detail-modal").modal("show"); // Hiển thị modal nếu có
            } else {
                toastr.error(res.message); // Hiển thị lỗi nếu không tìm thấy sản phẩm
            }
        },
        error: function () {
            toastr.error("Có lỗi xảy ra khi tải chi tiết sản phẩm.");
        },
    });
}

function showDetailAction() {
    const imgMain = document.querySelector(".product-img__main");
    const imgExtra = document.querySelectorAll(".product-img__extra-item");

    imgExtra.forEach((item) => {
        item.onclick = () => {
            if (imgMain && item) {
                imgMain.src = item.src;
            }
        };
    });
}

function profileTab(selector) {
    // Lấy ul, a, div và kiểm tra
    this.container = document.querySelector(`${selector}`);
    if (!this.container) {
        console.log(`Không tìm thấy ${this.container}`);
        return;
    }

    this.tabs = Array.from(this.container.querySelectorAll("li a"));

    this.panels = this.tabs.map((tab) => {
        const panel = document.querySelector(tab.getAttribute("href"));
        return panel;
    });

    // Reset lại không có gì
    this.tabs.forEach((tab) => {
        tab.closest("li").classList.remove("tab--active");
    });
    this.panels.forEach((panel) => (panel.hidden = true));

    // Lấy tab đầu tiên làm mặc định
    this.tabs[0].closest("li").classList.add("tab--active");
    this.panels[0].hidden = false;

    this.tabs.forEach((tab) => {
        tab.onclick = (e) => {
            e.preventDefault();

            // Reset lại không có gì
            this.tabs.forEach((tab) => {
                tab.closest("li").classList.remove("tab--active");
            });
            this.panels.forEach((panel) => (panel.hidden = true));

            // Gán active cho từng thẻ
            tab.closest("li").classList.add("tab--active");

            const panelActive = document.querySelector(
                tab.getAttribute("href")
            );
            panelActive.hidden = false;
        };
    });
}


