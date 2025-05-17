$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    update_Tongtien();
    search_GH();
    btn_thanhtoan();
});

// Size Select2
$("#sizeSelect2").select2({
    placeholder: "--- Chọn size ---",
    allowClear: true,
    ajax: {
        url: "/user/sizes",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return { results: data };
        },
        cache: true,
    },
});
// Danh mục Select2
$("#danhmucSelect2").select2({
    placeholder: "--- Chọn danh mục ---",
    allowClear: true,
    ajax: {
        url: "/user/danhmuc",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return { results: data };
        },
        cache: true,
    },
});
// Nhà sản xuất Select2
$("#nsxSelect2").select2({
    placeholder: "--- Chọn nhà sản xuất ---",
    allowClear: true,
    ajax: {
        url: "/user/nsx",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return { results: data };
        },
        cache: true,
    },
});
// Phương thức thanh toán Select2
$("#ptThanhToanSelect2").select2({
    placeholder: "--- Chọn phương thức thanh toán ---",
    allowClear: true,
    ajax: {
        url: "/user/ptThanhToan",
        dataType: "json",
        delay: 250,
        processResults: function (data) {
            return { results: data };
        },
        cache: true,
    },
});
// Giá Select2
$("#giaSelect2").select2({
    placeholder: "--- Chọn giá ---",
    allowClear: true,
    data: [
        { id: "1", text: "Giảm dần" },
        { id: "2", text: "Tăng dần" },
    ],
});

// Get size select2
$(".getsizeSelect2").each(function () {
    let $select = $(this);
    let ghId = $select.data("gh-id");

    // Gọi ajax lấy size hiện tại
    $.ajax({
        url: "/user/getSizes",
        data: { gh_id: ghId },
        success: function (data) {
            if (data.length > 0) {
                // Tạo option cho size hiện tại và chọn nó
                let option = new Option(data[0].text, data[0].id, true, true);
                $select.append(option).trigger("change");
            }
        },
    });

    // Khởi tạo Select2 với ajax load tất cả size
    $select.select2({
        placeholder: "--- Chọn size ---",
        allowClear: true,
        ajax: {
            url: "/user/sizes",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return { results: data };
            },
            cache: true,
        },
    });
});

// Chức năng nút tăng giảm số lượng (+,-)
function changeQuantity(button, delta) {
    let input = $(button)
        .closest(".quantity-group")
        .find("input.quantity-input");
    let currentVal = parseInt(input.val());

    if (isNaN(currentVal)) {
        currentVal = 1;
    }

    let newVal = currentVal + delta;

    if (newVal < 1) {
        newVal = 1;
    }

    input.val(newVal);
}

// Thêm sản phẩm
$(".btn-addSP").on("click", function () {
    let sp_id = $(this).data("sp-id");
    let url = $(this).data("url");
    let cart_url = $(this).data("cart-url");
    let soluong = $("#soluong_" + sp_id).val();

    // Lấy giá trị size hiện tại của select2 tương ứng
    let size_id = $(".sizeSelect2[data-sp-id='" + sp_id + "']").val();

    // Kiểm tra nếu chưa chọn size
    if (!size_id) {
        toastr.error("Vui lòng chọn size!!!");
        return;
    }

    $.ajax({
        url: url,
        method: "POST",
        data: {
            sp_id: sp_id,
            soluong: soluong,
            size_id: size_id,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            switch (response) {
                case "1":
                    toastr.success("Đã thêm sản phẩm vào giỏ hàng.");
                    window.location.href = cart_url;
                    break;
                case "0":
                    toastr.warning("Thêm sản phẩm thất bại!!!");
                    break;
                case "-1":
                    toastr.error("Hệ thống lỗi");
                    break;
            }
        },
        error: function (xhr) {
            // if (xhr.status === 422) {
            //     let errors = xhr.responseJSON;
            //     const keys = Object.keys(errors);
            //     for (let i = 0; i < keys.length; i++) {
            //         $("#err_soluong_" + keys[i]).text(errors[keys[i]]);
            //     }
            // } else {
            toastr.error("Lỗi không xác định");
            // }
        },
    });
});

// Cập nhật sản phẩm
$(".btn-update-quantity").on("click", function () {
    let gh_id = $(this).data("gh-id");
    let user_id = $(this).data("user_id");
    let url = $(this).data("url");
    let soluong = $("#soluong_" + gh_id).val();

    // Lấy giá trị size hiện tại của select2 tương ứng
    let size_id = $(".getsizeSelect2[data-gh-id='" + gh_id + "']").val();

    // Kiểm tra nếu chưa chọn size
    if (!size_id) {
        toastr.error("Vui lòng chọn size!!!");
        return; // dừng gửi ajax
    }

    // Lấy giá trị hiện tại từ data attribute
    let currentQuantity = $("#soluong_" + gh_id).data("current-quantity");
    let currentSize =
        $(".getsizeSelect2[data-gh-id='" + gh_id + "']").data("current-size") ||
        "";

    // Kiểm tra có thay đổi gì không
    if (soluong == currentQuantity && size_id == currentSize) {
        toastr.info("Bạn chưa thay đổi số lượng hoặc size.");
        return;
    }

    $(".err_soluong").text(""); // clear lỗi

    $("#loading").show();

    setTimeout(() => {
        $.ajax({
            url: url,
            method: "POST",
            data: {
                gh_id: gh_id,
                user_id: user_id,
                soluong: soluong,
                size_id: size_id,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                switch (response) {
                    case "1":
                        toastr.success("Cập nhật thành công");
                        // window.location.reload();

                        // Cập nhật lại quantity hiện tại để lần sau check
                        $("#soluong_" + gh_id).data(
                            "current-quantity",
                            soluong
                        );
                        $(".getsizeSelect2[data-gh-id='" + gh_id + "']").data(
                            "current-size",
                            size_id
                        );

                        // Tính lại tổng tiền nếu checkbox được tick
                        let checkbox = $(
                            ".btn-update-quantity[data-gh-id='" + gh_id + "']"
                        )
                            .closest(".cart-item")
                            .find(".item-checkbox");

                        if (checkbox.is(":checked")) {
                            // Lấy đơn giá từ HTML
                            let giaText = $(
                                ".btn-update-quantity[data-gh-id='" +
                                    gh_id +
                                    "']"
                            )
                                .closest(".cart-item")
                                .find("h3.text-danger")
                                .text()
                                .replace(/\D/g, "");
                            let gia = parseInt(giaText);

                            let thanhTien = gia * parseInt(soluong);

                            // Cập nhật lại tổng tiền
                            let total = 0;
                            $(".item-checkbox").each(function () {
                                if ($(this).is(":checked")) {
                                    let item = $(this).closest(".cart-item");
                                    let giaItem = parseInt(
                                        item
                                            .find("h3.text-danger")
                                            .text()
                                            .replace(/\D/g, "")
                                    );
                                    let slItem = parseInt(
                                        item.find(".quantity-input").val()
                                    );
                                    total += giaItem * slItem;
                                }
                            });

                            // Hiển thị tổng tiền mới
                            $("#totalPrice").text(
                                total.toLocaleString("vi-VN") + " ₫"
                            );
                        }

                        $("#loading").hide();
                        break;
                    case "0":
                        toastr.warning("Sản phẩm không tồn tại trong giỏ hàng");
                        $("#loading").hide();
                        break;
                    case "-1":
                        toastr.error("Hệ thống lỗi");
                        $("#loading").hide();
                        break;
                    default:
                        const keys = Object.keys(response);
                        for (let i = 0; i < keys.length; i++) {
                            $("#err_soluong_" + keys[i]).text(
                                response[keys[i]]
                            );
                        }
                        break;
                }
            },
            error: function (xhr) {
                // if (xhr.status === 422) {
                //     let errors = xhr.responseJSON;
                //     const keys = Object.keys(errors);
                //     for (let i = 0; i < keys.length; i++) {
                //         $("#err_soluong_" + keys[i]).text(errors[keys[i]]);
                //     }
                // } else {
                toastr.error("Lỗi không xác định");
                // $("#loading").hide();
                // }
            },
        });
    }, 500);
});

// Xóa sản phẩm
$(".btn-delete-item").on("click", function () {
    let gh_id = $(this).data("gh-id");
    let url = $(this).data("url");

    Swal.fire({
        title: "Xác nhận xóa?",
        text: "Bạn có chắc chắn muốn xóa sản phẩm này không?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đồng ý",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            setTimeout(() => {
                $.ajax({
                    url: url,
                    method: "delete",
                    data: {
                        gh_id: gh_id,
                    },
                    success: function (response) {
                        switch (response) {
                            case "1":
                                toastr.success("Đã xóa sản phẩm khỏi giỏ hàng");
                                $("#loading").hide();
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                                break;
                            case "0":
                                toastr.error("Xóa thất bại");
                                $("#loading").hide();
                                break;
                            case "-1":
                                toastr.error("Hệ thống lỗi");
                                $("#loading").hide();
                                break;
                        }
                    },
                });
            }, 1000);
        }
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

// Định dạng đơn vị tiền
function formatCurrency(value) {
    return new Intl.NumberFormat("vi-VN").format(value);
}

// Tìm kiếm
document.getElementById("searchInput").addEventListener("keyup", function () {
    const query = this.value.trim();

    if (!query) {
        document.getElementById("searchResults").style.display = "none";
        return;
    }

    fetch(`${searchURL}?query=${encodeURIComponent(query)}`)
        .then((response) => response.json())
        .then((data) => {
            const resultsContainer = document.getElementById("searchResults");
            resultsContainer.innerHTML = "";

            if (data.length > 0) {
                data.forEach((item) => {
                    resultsContainer.innerHTML += `
                        <div class="search-item">
                            <a class="sreach-a" href="${linksearchURL}${
                        item.sp_id
                    }" style="color: black;">
                                <div class="row">
                                    <div class="col-4 d-flex-column justify-content-center align-items-center">
                                        <img src="${imgURL}/${
                        item.image_url
                    }" alt="${item.tensp}" width="80%" class="me-2" />
                                    </div>
                                    <div class="col-8 ">
                                        <h1><strong>${item.tensp}</strong></h1>
                                        <h2  style="color: red;">${formatCurrency(
                                            item.gia
                                        )} VND</h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                });
            } else {
                resultsContainer.innerHTML =
                    "<h3 class='text-danger'>Không tìm thấy sản phẩm nào!!!</h3>";
            }

            resultsContainer.style.display = "block";
        })
        .catch((err) => console.error("Lỗi tìm kiếm!!!"));
});

// Ẩn kết quả tìm kiếm khi click ra ngoài
document.addEventListener("click", function (e) {
    const searchInput = document.getElementById("searchInput");
    const resultsContainer = document.getElementById("searchResults");

    if (
        !searchInput.contains(e.target) &&
        !resultsContainer.contains(e.target)
    ) {
        resultsContainer.style.display = "none";
    }
});

//Hàm xóa dấu tiếng Việt
function removeVietnameseTones(str) {
    return str
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/đ/g, "d")
        .replace(/Đ/g, "D")
        .toLowerCase();
}

//Lọc trong trang store
$("#filterButton").on("click", function () {
    const url = $(this).data("url");
    const danhmuc = $("#danhmucSelect2").val();
    const nsx_id = $("#nsxSelect2").val();
    const gia = $("#giaSelect2").val();

    const params = new URLSearchParams({
        danhmuc: danhmuc,
        nsx_id: nsx_id,
        gia: gia,
    });
    window.location.href = `${url}?${params.toString()}`;
});
// Lọc - Mới nhất - Bán chạy - Phổ biến
$(".sort-button").on("click", function () {
    const sortType = $(this).data("sort");
    const url = $(this).data("url");

    const params = new URLSearchParams({ sort: sortType });
    window.location.href = `${url}?${params.toString()}`;
});

// Tìm kiếm trong giỏ hàng
function search_GH() {
    // Tìm kiếm trong giỏ hàng
    const searchInput = document.getElementById("searchGioHang");
    const noResultsMessage = document.getElementById("noResultsMessage");
    const items = document.querySelectorAll(".cart-item");

    searchInput.addEventListener("input", function () {
        const query = removeVietnameseTones(this.value.trim()).toLowerCase();
        let found = false;

        items.forEach((item) => {
            const name = removeVietnameseTones(
                item.getAttribute("data-name") || ""
            ).toLowerCase();
            const wrapper = item.closest(".cart-item-wrapper");

            if (name.includes(query)) {
                wrapper.style.display = "";
                found = true;
            } else {
                wrapper.style.display = "none";
            }
        });

        // Hiển thị hoặc ẩn thông báo không có sản phẩm
        if (!found) {
            noResultsMessage.style.display = "block";
        } else {
            noResultsMessage.style.display = "none";
        }
    });
}

// Update tổng tiền
function update_Tongtien() {
    // Cập nhật tổng tiền khi nhấn vào checkbox
    const checkboxes = document.querySelectorAll(".item-checkbox");
    const totalPriceEl = document.getElementById("totalPrice");

    function updateTotalPrice() {
        let total = 0;

        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const item = checkbox.closest(".cart-item");
                const quantityInput = item.querySelector(".quantity-input");
                const quantity = quantityInput
                    ? parseInt(quantityInput.value)
                    : 1;

                // Lấy giá từ thẻ <h3 class="text-danger">
                const priceText =
                    item.querySelector("h3.text-danger")?.innerText || "0";
                const price = parseInt(priceText.replace(/[^\d]/g, "")) || 0;

                total += price * quantity;
            }
        });

        // Hiển thị tổng tiền theo định dạng Việt Nam
        totalPriceEl.textContent =
            new Intl.NumberFormat("vi-VN").format(total) + " ₫";
    }

    // Gắn sự kiện click cho tất cả checkbox
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateTotalPrice);
    });

    updateTotalPrice();
}

// Thanh toán
function btn_thanhtoan() {
    $(".checkoutBtn").on("click", function () {
        let selectedItems = [];
        let sizeError = false;

        $(".item-checkbox:checked").each(function () {
            let item = $(this).closest(".cart-item");
            let sizeId = item.find(".getsizeSelect2").val();

            if (!sizeId) {
                toastr.warning("Vui lòng chọn size cho sản phẩm được chọn.");
                sizeError = true;
                return false;
            }

            selectedItems.push({
                gh_id: item.find(".btn-update-quantity").data("gh-id"),
                size_id: item.find(".getsizeSelect2").val(),
                soluong: item.find(".quantity-input").val(),
                user_id: item.find(".btn-update-quantity").data("user-id"),
            });
        });

        if (sizeError) {
            return;
        }

        let pttt_id = $("#ptThanhToanSelect2").val();
        if (!pttt_id) {
            toastr.warning("Vui lòng chọn phương thức thanh toán.");
            return;
        }

        if (selectedItems.length === 0) {
            toastr.warning("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
            return;
        }

        let url = $(this).data("url-checkout");

        $("#loading").show();
        setTimeout(() => {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    items: selectedItems,
                    pttt_id: pttt_id,
                },
                // contentType: "application/json",
                // dataType: "json",
                // success: function (response) {
                //     toastr.success("Đặt hàng thành công!");
                //     window.location.href = response.redirect_url;
                // },
                success: function (response) {
                    switch (response) {
                        case "1":
                            toastr.success("Thanh toán thành công");
                            $("#loading").hide();
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                            break;
                        case "0":
                            toastr.error("Thanh toán thất bại");
                            $("#loading").hide();
                            break;
                        case "-1":
                            toastr.error("Hệ thống lỗi");
                            $("#loading").hide();
                            break;
                    }
                },
                error: function (xhr) {
                    toastr.error("Có lỗi xảy ra khi đặt hàng.");
                    // console.error("Lỗi từ server:", xhr.responseText);
                },
            });
        }, 500);
    });
}
