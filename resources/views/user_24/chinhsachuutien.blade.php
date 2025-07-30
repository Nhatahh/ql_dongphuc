<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Dashboard 2</title>
  @include('user_24.head')


</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Navbar -->
@include('user_24.navbar')
  <!-- /.navbar -->



  @include('user_24.navbarfooter')
  @include('user_24.modalevent')
</div>














<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
@include('user_24.footer')


<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/swiper/swiper.js"></script>
<script src="/user_24/js/chinhsachuutien.js"></script>
</body>
</html>
