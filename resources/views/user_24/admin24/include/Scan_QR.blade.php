 <!-- Modal nhập quét QR-->
 <div class="modal" style="z-index: 10000;" id="modal_ScanQR">
        <div id = "container_modal_ScanQR" style="vertical-align:middle;background-color: rgba(0,0,0,0.5);height: 100%; ">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-navy card-outline" style="width: 100%; height:auto; padding: 2px; background-color:#fff;">
                        <div class="card-header" style="padding: 0;margin-left: 10px;margin-top: 3px;font-weight: bold;">
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-11">
                                    <span class="">Scan QRcode</span>
                                </div>
                                <div class="col-md-1 col-lg-1 col-1">
                                    <span class="float-right" style="margin-right: 10px"><i onclick="btt_hide_modal_ScanQR()" id='modal_number_go_wish_start_end_close' class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="" style="padding-bottom: 0px;padding-top: 3px; text-align:center;">
                            <div id="camera" style = "width:100%; height: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/template/jsqr/dist/jsQR.js"></script>
<!-- Gọi Quagga từ thư mục public/template -->
<script src="/template/quagga.min.js"></script>