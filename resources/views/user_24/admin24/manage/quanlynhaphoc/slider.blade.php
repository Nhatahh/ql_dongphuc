{{-- <span class=""  style="margin-left:10px;"><strong>Minh chứng hồ sơ</strong></span>  --}}
<div class="swiper swiper-slider card card-body">
    <div class="swiper-wrapper" style="max-height:580px" id= "slider">
        <div class="swiper-slide" style="position: relative; height: 580px;">
            <div class="swiper-zoom-container" style="height: 580px;">
                <img src="/img/test.png">
            </div>

        </div>

    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-scrollbar"></div>
</div>
<script src="/template/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/swiper/swiper.js"></script>
<script>
    var swiper = new Swiper('.swiper-slider', { // Update the class to match your HTML
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        scrollbar: {
            el: '.swiper-scrollbar',
        },
        zoom: true, // Bật tính năng zoom
    });
</script>

<style>
    .swiper-slide img {
    max-width: 100%; /* Đảm bảo hình ảnh không lớn hơn container */
    max-height: 100%; /* Đảm bảo hình ảnh không cao hơn container */
    width: auto; /* Đảm bảo tỷ lệ khung hình được giữ */
    height: auto; /* Đảm bảo tỷ lệ khung hình được giữ */
    display: block; /* Đảm bảo hình ảnh được hiển thị là một khối block */
    margin: auto; /* Căn giữa hình ảnh */
}

</style>
