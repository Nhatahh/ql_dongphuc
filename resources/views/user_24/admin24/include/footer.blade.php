

<footer class="main-footer">
    <strong>Trường Đại học Kỹ thuật - Công nghệ Cần Thơ &copy; since 2013 <a href="https://ctuet.edu.vn">CTUT</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
    <b>Phiên bản</b> 1.2.0 (tháng 03/2022)
    </div>
</footer>
{{-- <div id="sidebar-overlay"></div> --}}

<!-- jQuery -->
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/template/admin/dist/js/adminlte.min.js"></script>



<script src="/template/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> --}}
<!-- ChartJS -->
<script src="/template/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/template/admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/template/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/template/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/template/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/template/admin/plugins/moment/moment.min.js"></script>
<script src="/template/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/template/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
{{-- <!-- Summernote -->
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script> --}}
<!-- overlayScrollbars -->
<script src="/template/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="/template/admin/dist/js/pages/dashboard.js"></script> --}}

<!-- Select2 -->
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>

<!-- Summernote -->
<script src="/template/admin/plugins/summernote/summernote-bs4.min.js"></script>





<!-- Datatable -->
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/jszip/jszip.min.js"></script>
<script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<!-- Toastr-->
<script src="/template/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="/template/admin/plugins/toastr/toastr.min.js"></script>


<script src="/chart/chart.js"></script>
<script src="/chart/config.js"></script>

<script src="/admin/admin24/js/main.js"></script>

<script src="/swiper/swiper.js"></script>

{{-- đồng phục --}}
{{--

<script src="/admin/admin24/js/quanlydongphuc/quanlyhoadon.js"></script> --}}


<script>
var capmenu = 4;
nav_open(capmenu)
// nav_close()


// $('asides').on('click',function(){
//     nav_open(capmenu)
// });

function nav_close(){
    $('.nav-link').css('padding-left', '0');
}

function nav_open(capmenu){
    var opt = 0.24;
    for(let i = 0; i< capmenu; i++){
       var lev = document.getElementsByClassName('lev'+i)
       for(let j = 0; j<lev.length; j++){
            $(lev[j]).css('padding-left', i*8+"px",'background-color', 'rgba(255, 255, 255,'+opt+')');
            $(lev[j]).css('background-color', 'rgba(255, 255, 255,'+opt+')');
       }
       opt = opt - 0.06;
    }
}


var targetNode = $('asides')[0]// Hoặc phần tử mà bạn muốn theo dõi
    var observerOptions = {
        attributes: true, // Lắng nghe sự thay đổi của attribute
        attributeFilter: ['style'], // Chỉ lắng nghe sự thay đổi của class
    };
    var observer = new MutationObserver(function(mutationsList) {
        mutationsList.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                if ($(mutation.target).hasClass('sidebar-collapse')) {
                    nav_close()
                } else {
                    nav_open(capmenu)
                }
            }
        });
    });
    observer.observe(targetNode, observerOptions);
</script>
