<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('user_24.admin24.include.header')
    <link rel="stylesheet" href="/admin/admin_24/plugins/summernote/summernote.min.css">

@livewireStyles
</head>

<body class="sidebar-mini sidebar-collapse">
    <div class="wrapper">
        {{-- @include('user_24.admin24.include.preloader') --}}
        @include('user_24.admin24.include.navbar')
        @include('user_24.admin24.include.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @include('user_24.admin24.include.contentheader')
                    <div class="row">
                        <div class="card">



                            @livewire('click-counter')



                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('user_24.modalevent')
        {{-- @include('user_24.admin24.include.footer') --}}
    </div>

    @livewireScripts
</body>

{{-- <script src="/admin/admin24/js/quanlyxettuyen/thuchienxettuyen.js"></script> --}}

<!-- summernote -->
{{-- <script src="/admin/admin_24/plugins/summernote/summernote.min.js"></script> --}}

</html>

