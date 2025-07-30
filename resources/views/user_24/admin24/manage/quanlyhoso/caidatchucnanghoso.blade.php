<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">
</head>

<body class="sidebar-mini sidebar-collapse">
<div class="wrapper">
    @include('user_24.admin24.include.preloader')
    @include('user_24.admin24.include.navbar')
    @include('user_24.admin24.include.sidebar')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @include('user_24.admin24.include.contentheader')
                <div class="card" style="">
                    <div class="card-header">
                        aaaaa
                    </div>
                    <div class="card-body">
                        bbbbbb
                    </div>
                    <div class="card-footer">
                        ccccccc
                    </div>
                </div>
            </div>
        </section>
        @include('user_24.modalevent')
    </div>
    @include('user_24.admin24.include.footer')
</div>
</body>
<script src="/admin/admin24/js/quanlyhoso/phancongduyethoso.js"></script>
</html>
