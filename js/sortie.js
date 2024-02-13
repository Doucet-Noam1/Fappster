function get_average_rgb(img) {
    var context = document.createElement('canvas').getContext('2d');
    if (typeof img == 'string') {
        var src = img;
        img = new Image();
        img.src = src;
    }
    context.imageSmoothingEnabled = true;
    context.drawImage(img, 0, 0, 1, 1);
    return [...context.getImageData(0, 0, 1, 1).data.slice(0, 3)];
}
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        img = document.querySelector("#banner img");
        if (img.complete) {
            document.querySelector("#banner").style.setProperty("--album-color", `rgb(${get_average_rgb(img).join(",")})`);
        }
    }, 100);
});