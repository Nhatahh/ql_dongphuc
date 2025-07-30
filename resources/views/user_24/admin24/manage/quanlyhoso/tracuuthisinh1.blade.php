<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swiper Example</title>
    <!-- Link to Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <!-- Link to Font Awesome CSS (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('user_24.admin24.include.header')
    <style>

.image-container {
    border: 2px dashed #ccc;
    border-radius: 10px;
    /* width: 80%;
    max-width: 600px;
    padding: 20px;
    text-align: center; */
    position: relative;
}

img {
    /* max-width: 100%;
    cursor: grab; */
    position: absolute;
}

    </style>
</head>
<body>
    <div class="row">
        <div class="col-4">

            <h2>Kéo thả để di chuyển ảnh</h2>
            <div class="image-container">
                <img src="/img/CTUT_logo.png" alt="Sample Image" draggable="true" id="draggable-image">
            </div>



        </div>
    </div>












</body>
</html>

<script>

const img = document.getElementById('draggable-image');
const container = document.querySelector('.image-container');

img.addEventListener('dragstart', dragStart);
container.addEventListener('dragover', dragOver);
container.addEventListener('drop', drop);

function dragStart(e) {
    e.dataTransfer.setData('text/plain', null); // Đảm bảo dữ liệu được chuyển đi
    // img.style.opacity = '0.5';
}

function dragOver(e) {
    e.preventDefault(); // Cho phép thả
    img.style.cursor = 'grabbing';
}

function drop(e) {
    e.preventDefault();
    const rect = container.getBoundingClientRect();
    const offsetX = e.clientX - rect.left - img.clientWidth / 2;
    const offsetY = e.clientY - rect.top - img.clientHeight / 2;

    img.style.left = `${offsetX}px`;
    img.style.top = `${offsetY}px`;
    img.style.opacity = '1';
    img.style.cursor = 'grab';
}
</script>


