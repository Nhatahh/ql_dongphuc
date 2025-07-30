<div class="swiper swiper-slider card card-body">
    <div class="swiper-wrapper" style="max-height:700px">
        @foreach ( $img_slider_right as $img )
            <div class="swiper-slide"  style="position: relative" style="height: 700px">
                <div class="swiper-zoom-container" style="height: 700px">
                    <img src="{{$img->path_img}}" >
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-scrollbar"></div>
</div>
