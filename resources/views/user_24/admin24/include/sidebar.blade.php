{{-- @extends('admin.main') --}}

<asides style="background-color: rgb(10 85 140);" class="main-sidebar sidebar-dark-primary elevation-0">
    <!-- Brand Logo -->
    <a href="" style="border-bottom: 3px solid #4577a3;padding: 0.653rem 0.5rem;" class="brand-link">

        <img src="\img\CTUT_logo.jpg" alt="logo CTUT" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CTUT|Quản lý hồ sơ</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <div class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu"
                data-accordion="false" style = "color: white" id = "sidebar">
                {{-- <li class="nav-item" style="">
                    <a class="nav-link lev0" style="margin-bottom: 1px;">
                        <i class="nav-icon fa-solid fa-users" style="font-size: 14px;color:white"></i>
                        <p id="levelpr1" > Người dùng - Chức năng<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul id="level6" class="nav nav-treeview">
                        <li class="nav-item" style="display: block">
                            <a class="nav-link lev1" style="margin-bottom: 1px;">
                                <i class="nav-icon fa-solid fa-users" style="font-size: 14px;color:white"></i>
                                <p id="levelpr2">Cấp 2-1<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul id="level6" class="nav nav-treeview">
                                <li class="nav-item" style="display: block">
                                    <a class="nav-link lev2" style="margin-bottom: 1px;">
                                        <i class="nav-icon fa-solid fa-users" style="font-size: 14px;color:white"></i>
                                        <p id="levelpr2">Cấp 2-1<i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul id="level6" class="nav nav-treeview">
                                        <li class="nav-item" style="display: block">
                                            <a class="nav-link lev2" style="margin-bottom: 1px;">
                                                <i class="nav-icon fa-solid fa-users" style="font-size: 14px;color:white"></i>
                                                <p id="levelpr2">Cấp 2-1<i class="fas fa-angle-left right"></i></p>
                                            </a>
                                            <ul id="level7" class="nav nav-treeview" style="display: none;">
                                                <li class="nav-item">
                                                    <a href="quanlychucnang" class="nav-link lev4" id = "" style="margin-bottom: 1px;">
                                                        <i class="nav-icon fa-solid fa-users" style="font-size: 14px;color:white"></i>
                                                        <p>Cấp 3-1</p>
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul id="level7" class="nav nav-treeview"  style="display: none;">
                                                <li class="nav-item">
                                                    <a href="quanlychucnang"  style="margin-bottom: 1px;" class="nav-link lev4" id = "">
                                                        <i class="nav-icon fa-solid fa-users" style="font-size: 14px;color:white"></i>
                                                        <p>Cấp 3-2</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <ul id="level7" class="nav nav-treeview"  style="display: none;">
                                        <li class="nav-item">
                                            <a href="quanlychucnang"  style="margin-bottom: 1px;" class="nav-link lev3" id = "">
                                                <i class="nav-icon fa-solid fa-users" style="font-size: 14px;color:white"></i>
                                                <p>Cấp 3-2</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </li>
                    </ul>
                </li> --}}
                {!! htmlspecialchars_decode($menu) !!}
            </div>
        </nav>
    </div>
</asides>

<script src="/template/admin/plugins/jquery/jquery.min.js"></script>



