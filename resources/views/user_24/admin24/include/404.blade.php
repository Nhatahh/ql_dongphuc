<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <div class="content-wrapper" style="min-height: 1302.12px;">
            @include('user_24.admin24.include.contentheader')
            <section class="content">
                <div class="container-fluid">
                    <section class="content">
                        <div class="error-page">
                          <h2 class="headline text-warning"> 404</h2>

                          <div class="error-content">
                            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Cảnh báo! Trang không tồn tại.</h3>

                            <p>
                              Vui lòng liên hệ ADMIN để truy cập hoặc truy cập Trang chủ <a href="/admin24/main">Tại đây</a>.
                            </p>

                          </div>
                          <!-- /.error-content -->
                        </div>
                        <!-- /.error-page -->
                      </section>
                </div>
            </section>
        </div>
        @include('user_24.admin24.include.footer')

    </div>

</body>

</html>

<script src="/admin/admin24/js/home.js"></script>

