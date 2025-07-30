<div class="container">
    {{-- @if (empty($bieudonguyenvong)) ""  @else {{$bieudonguyenvong}} @endif --}}
    <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-10 sm-res-mg-t-10 dk-res-mg-t-10">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">
                            @if (empty($chitieu))
                                0 @else{{ $chitieu }}
                            @endif
                        </span></h2>
                    <p>Chỉ tiêu</p>
                </div>
                <div class="sparkline-bar-stats1">9,4,8,6,5,6,4,8,3,5,9,5</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-10 tb-res-mg-t-10 dk-res-mg-t-10">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ $slnguyenvong }}</span>/<span
                            class="counter">{{ $slthisinh }}</span></h2>
                    <p>NV/ThS</p>
                </div>
                <div class="sparkline-bar-stats1">9,4,8,6,5,6,4,8,3,5,9,5</div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-10 sm-res-mg-t-10 dk-res-mg-t-10">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ $slkhoanguyenvong }}</span></h2>
                    <p>Đăng ký</p>
                </div>
                <div class="sparkline-bar-stats3">4,2,8,2,5,6,3,8,3,5,9,5</div>
            </div>
        </div>




    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-10 sm-res-mg-t-10 dk-res-mg-t-10">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ $nv1 }}</span>/<span class="counter">{{ $nv2 }}</span>/<span class="counter">{{ $nv3 }}</span>
                    </h2>
                    <p>NV1/NV2/NV3</p>
                </div>
                <div class="sparkline-bar-stats2">1,4,8,3,5,6,4,8,3,3,9,5</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-10 sm-res-mg-t-10 dk-res-mg-t-10">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ $tongtien }}</span></h2>
                    <p>Lệ phí</p>
                </div>
                <div class="sparkline-bar-stats4">2,4,8,4,5,7,4,7,3,5,7,5</div>
            </div>
        </div>

    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="wb-traffic-inner notika-shadow sm-res-mg-t-10 sm-res-mg-t-10 dk-res-mg-t-10">
            <div class="website-traffic-ctn">
                <h2><span class="counter">{{ $tongtien }}</span>/<span class="counter">{{ $slthisinhlephi }}</span>
                </h2>
                <p>Tạm</p>
            </div>
            <div class="sparkline-bar-stats4">2,4,8,4,5,7,4,7,3,5,7,5</div>
        </div>
    </div>
</div>
{{-- <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"></div> --}}
</div>
</div>
