$(document).ready(function () {
    let currentSort = "moi-nhat"; // giá trị mặc định

    // Xử lý khi click nút sắp xếp (mới nhất, phổ biến, bán chạy)
    $(".sort-button").on("click", function () {
        $(".sort-button")
            .removeClass("active btn-warning")
            .addClass("btn-secondary");
        $(this).addClass("active btn-warning").removeClass("btn-secondary");

        currentSort = $(this).data("sort");
        fetchSanpham(); // gọi hàm lọc lại
    });

    // Xử lý khi nhấn nút "Lọc"
    $("#filterButton").on("click", function () {
        fetchSanpham(); // gọi hàm lọc lại
    });

    function fetchSanpham() {
        const url = "{{ route('store.filter') }}";

        const params = {
            danhmuc: $("#danhmucSelect2").val(),
            nsx_id: $("#nsxSelect2").val(),
            gia: $("#giaSelect2").val(),
            sort: currentSort,
        };

        $.ajax({
            url: url,
            method: "GET",
            data: params,
            success: function (response) {
                const html = $(response).find(".product-list").html();
                $(".product-list").html(html);
            },
            error: function (xhr) {
                console.log("Lỗi khi lọc sản phẩm:", xhr.responseText);
            },
        });
    }
});
