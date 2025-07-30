<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swiper Example</title>
    <!-- Link to Swiper CSS -->

    @include('user_24.admin24.include.header')
    <style>

/* .swiper-slide{
    width: 100%;
} */

.swiper-zoom-container {
    position: relative;
    overflow: hidden;
    /* width: 200%; */
}

.swiper-zoom-container img{
    transition: transform 0.3s ease-in-out;
}

/* Styles for the control buttons container */
.controls {
    position: absolute;
    top: 10px;
    left: 10px;
    display: flex;
    gap: 10px;
    z-index: 10;
}

/* Styles for each control button */
.controls i {
    font-size: 20px;
    color: #333;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 5px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.controls i:hover {
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
}

/* Additional styles to enhance the user experience */
.controls i:active {
    transform: scale(0.9);
}

/* Add this if you want a subtle shadow for the buttons */
.controls i {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
    </style>
</head>
<body>
    <div class="row">

        <div class="col-4">
        </div>
        <div class="col-4">
            <div class="swiper swiper-slider card card-body" style="height: 600px">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="swiper-zoom-container">
                            <img src="/img/CTUT_logo.png" style="position: absolute;" alt="Sample Image"  draggable="true" id="draggable-image">
                            <div class="controls">
                                <i class="fas fa-search-plus zoom-in"></i>
                                <i class="fas fa-search-minus zoom-out"></i>
                                <i class="fas fa-undo rotate-left"></i>
                                <i class="fas fa-redo rotate-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide"  style="height: 700px">
                        <div class="swiper-zoom-container" >
                            <img src="/img/CTUT_logo.png" style="position: absolute;" alt="Sample Image"  draggable="true" id="draggable-image">
                            <div class="controls">
                                <i class="fas fa-search-plus zoom-in"></i>
                                <i class="fas fa-search-minus zoom-out"></i>
                                <i class="fas fa-undo rotate-left"></i>
                                <i class="fas fa-redo rotate-right"></i>
                            </div>
                        </div>

                    </div>
                    <div class="swiper-slide"  style="height: 700px">
                        <div class="swiper-zoom-container" >
                            <img src="/img/CTUT_logo.png" style="position: absolute;" alt="Sample Image"  draggable="true" id="draggable-image">
                            <div class="controls">
                                <i class="fas fa-search-plus zoom-in"></i>
                                <i class="fas fa-search-minus zoom-out"></i>
                                <i class="fas fa-undo rotate-left"></i>
                                <i class="fas fa-redo rotate-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

    </div>
</body>

</html>

@include('user_24.admin24.include.footer')
<script>


const swiper = new Swiper('.swiper-slider', {
    slidesPerView: 1,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

});

document.querySelectorAll('.swiper-slide').forEach(slide => {
    swiper.allowTouchMove = false;
    let currentZoom = 1;
    let rotation = 0;
    let initialX = 0, initialY = 0;
    const zoomInBtn = slide.querySelector('.zoom-in');
    const zoomOutBtn = slide.querySelector('.zoom-out');
    const rotateLeftBtn = slide.querySelector('.rotate-left');
    const rotateRightBtn = slide.querySelector('.rotate-right');
    const img = slide.querySelector('img');
    var zleft = 0;
    var ztop = 0;
    var mouseX = 0;
    var mouseY = 0;
    var mouse_thaX = 0;
    var mouse_thaY = 0;
    var solanzoom = 0;
    img.addEventListener('dragstart', dragStart);
    img.addEventListener('dragover', dragOver);
    img.addEventListener('drop', drop);
    img.addEventListener('dblclick', dblclicka);

    zoomInBtn.addEventListener('click', () => {
        if( solanzoom < 4){
            solanzoom ++;
            currentZoom += 0.3;
            updateTransform();
        }
    });

    zoomOutBtn.addEventListener('click', () => {
        if(solanzoom <= 4 && solanzoom >0){
            solanzoom--;
            currentZoom = Math.max(1, currentZoom - 0.3); // Prevent zoom out below original size
            updateTransform();
        }
    });

    rotateLeftBtn.addEventListener('click', () => {
        rotation -= 90;
        updateTransform();
    });

    rotateRightBtn.addEventListener('click', () => {
        rotation += 90;
        updateTransform();
    });

    function updateTransform() {
        img.style.transform = `translate(${initialX}px, ${initialY}px) scale(${currentZoom}) rotate(${rotation}deg)`;
    }
    function dragStart(e) {
        e.dataTransfer.setData('text/plain', null); // Đảm bảo dữ liệu được chuyển đi
        mouseX = e.pageX;
        mouseY = e.pageY;
        zleft = img.offsetLeft
        ztop = img.offsetTop
    }

    function dragOver(e) {
        e.preventDefault(); // Cho phép thả
        img.style.cursor = 'grabbing';
    }
    function drop(e) {
        e.preventDefault();
        if(currentZoom>1){
            mouse_thaX = e.clientX;
            mouse_thaY = e.clientY;
            img.style.left = zleft + (mouse_thaX - mouseX) +'px'
            img.style.top = ztop + (mouse_thaY - mouseY) +'px'
            img.style.opacity = '1';
            img.style.cursor = 'grab';
        }
    }

    function dblclicka(){
        currentZoom = 1;
        rotation = 0;
        updateTransform();
    }
})





</script>


