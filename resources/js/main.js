function showDetailAction() {
  const imgMain = document.querySelector(".product-img__main");
  const imgExtra = document.querySelectorAll(".product-img__extra-item");

  imgExtra.forEach((item) => {
    item.onclick = () => {
      if (imgMain && item) {
        imgMain.src = item.src;
      }
    };
  });
}

document.addEventListener("DOMContentLoaded", function () {});
