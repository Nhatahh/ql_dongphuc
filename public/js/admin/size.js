$(document).ready(function () {
    $.ajax({
        url: SizeDataUrl,
        method: "GET",
        dataType: "json",
        success: function (response) {
            // Load size
            let sizeTable = $("#tableSize").DataTable({
                data: response.sizes,
                destroy: true,
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                    },
                    { data: "size_id" },
                    { data: "ten" },
                ],
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        },
    });
});
