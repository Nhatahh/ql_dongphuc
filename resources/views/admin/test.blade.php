
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    aaaaaaaaaaa
   <div id="a">

   </div>
</body>

<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
        type: "get",
        url: "/admin/test",
        // data: "data",
        // dataType: "dataType",
        success: function (response) {
            $('#a').html('<button id="b" onclick = bc()>Cilck</button>')
            }
        });
    });
    function bc(){
        alert(1111)
    }
</script>



</html>

