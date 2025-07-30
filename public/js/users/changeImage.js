document.addEventListener("DOMContentLoaded", function () {
    const thumbnails = document.querySelectorAll(".thumbnail");
    const mainImage = document.getElementById("mainImage");
    const modalImage = document.getElementById("modalImage");

    thumbnails.forEach((thumbnail) => {
        thumbnail.addEventListener("click", function () {
            mainImage.src = this.src;
            modalImage.src = this.src;
        });
    });

    // Nếu mainImage đổi bằng cách nào khác, đồng bộ với modalImage
    mainImage.addEventListener("load", function () {
        modalImage.src = this.src;
    });
});

