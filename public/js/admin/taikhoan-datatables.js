$(document).ready(function () {
    $("#usersTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "admin/users/data",
        columns: [
            { data: "user_id" },
            { data: "username" },
            { data: "mssv" },
            { data: "email" },
            { data: "sdt" },
            { data: "hoten" },
            { data: "diachi" },
            { data: "trangthai" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    $("#adminsTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "admin/admins/data",
        columns: [
            { data: "admin_id" },
            { data: "username" },
            { data: "created_at" },
            { data: "trangthai" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
});
