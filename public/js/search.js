$(document).ready(function () {
    $("#sidebar-search-input").on("input", function () {
        let keyword = $(this).val().trim();

        if (keyword.length > 1) {
            $.ajax({
                url: "/user/search-sidebar",
                method: "GET",
                data: { keyword },
                success: function (data) {
                    let html = "";
                    if (data.length === 0) {
                        html = '<div class="p-2">Không tìm thấy sản phẩm</div>';
                    } else {
                        data.forEach((item) => {
                            html += `
                                <a href="/user/uniforms/${
                                    item.sp_id
                                }" class="d-block p-2 text-dark border-bottom">
                                    <strong>${item.tensp}</strong><br>
                                    <small>Giá: ${item.gia.toLocaleString()} đ</small>
                                </a>
                            `;
                        });
                    }
                    $("#sidebar-search-result").html(html).show();
                },
            });
        } else {
            $("#sidebar-search-result").hide();
        }
    });

    // Ẩn kết quả khi click ra ngoài
    $(document).on("click", function (e) {
        if (
            !$(e.target).closest(
                "#sidebar-search-input, #sidebar-search-result"
            ).length
        ) {
            $("#sidebar-search-result").hide();
        }
    });
});
