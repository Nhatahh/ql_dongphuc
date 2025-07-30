<div class="container_iconright">
    <button class="btn btn-sm btn-primary mx-1 toggle-btn" style="margin-left: 0.9rem !important;
            margin-bottom: 0.4rem;
            opacity: 0.5;
            border-radius: 30%;" data-toggle="collapse" data-target=".collapse">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div onclick="dangxuat()" class="collapse">
        <div class="text-center">
            <div class="btn btn-sm btn-primary mx-1" style="background-color: rgba(225,0,0); border:0; border-radius: 50%; opacity: 0.7;" data-toggle="collapse" data-target="#logout">
                <i class="fa-solid fa-power-off"></i>
            </div>
            <div class="small" style="color: rgba(225,0,0); font-weight: bold; margin-top:0;">Đăng xuất</div>
        </div>
    </div>

    <div onclick="upload_img({{Auth::guard('loginbygoogles')->id()}})" class="collapse">
        <div class="text-center">
            <div class="btn btn-sm btn-primary mx-1" style="background-color: rgba(0,123,255); border:0; border-radius: 50%; opacity: 0.7;" data-toggle="collapse" data-target="#uploadImg">
                <i class="fa-solid fa-camera"></i>
            </div>
            <div class="small" style="color: rgba(0,123,255); font-weight: bold; margin-top:0;">Hình ảnh</div>
        </div>
    </div>

    <div onclick="videohuongdan()" class="collapse">
        <div class="text-center">
            <div class="btn btn-sm btn-primary mx-1" style="background-color: rgba(0,0,255); border:0; border-radius: 50%; opacity: 0.7;"  data-toggle="collapse" data-target="#videoGuide">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <div class="small" style="color: rgba(0,0,255); font-weight: bold; margin-top:0;">Hướng dẫn</div>
        </div>
    </div>
</div>



<div class="col-12 col-md-12" >
    <div class = "modal" id="upload_img"><i class="fa-solid fa-xmark modal_close" id = "upload_img_close" onclick = "upload_img_close()" role="button"></i>
        <div  style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.5);" >
            <div class="swiper swiper-modal">
                <div class="swiper-wrapper" style="max-height:700px">
                    @foreach ( $img_slider as $img )
                        @if ($img->loaianh > 1)
                            <div class="swiper-slide"  style="position: relative" style="height: 700px">
                                <i id = "upload_img_icon_{{$img->funtion_id}}_{{$img->loaianh}}" class="fa-solid fa-file-arrow-up @if ($img->test == 0) upload_img @else upload_img_yes @endif " role="button" onclick="{{$img->funtion_id}}({{Auth::guard('loginbygoogles')->id()}})"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span  id = "upload_img_text_{{$img->funtion_id}}_{{$img->loaianh}}"  class="@if ($img->test == 0) upload_img_ghichu @else upload_img_ghichu_yes @endif ">{{$img->ghichu}}</span><input id-user = "{{Auth::guard('loginbygoogles')->id()}}" class="upload_img_input" type="file" id="{{$img->funtion_id}}">
                                <div class="swiper-zoom-container" style="height: 700px">
                                    <img id="{{$img->funtion_id}}_{{$img->loaianh}}" src="{{$img->path_img}}" >
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-12" >
    <div class = "modal" id="videohuongdan"><i style="color: white;font-weight:bolder;font-size:20px;" class="fa-solid fa-xmark videohuongdan_close" id = "videohuongdan_close" onclick = "videohuongdan_close()" role="button"></i>
        <div style="vertical-align: middle;text-align:center; background-color: rgba(0,0,0,0.8);min-height:600px;padding-top:20px" >
            <iframe id="youtube_player" class="yt_player_iframe" width="100%" height="600px" src="https://www.youtube.com/embed/o_GcFm8Gd-Y?si=W49jAe6u67Gs8bKU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</div>

