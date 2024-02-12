function get_average_rgb(img) {
    var context = document.createElement('canvas').getContext('2d');
    if (typeof img == 'string') {
        var src = img;
        img = new Image;
        img.setAttribute('crossOrigin', ''); 
        img.src = src;
    }
    context.imageSmoothingEnabled = true;
    context.drawImage(img, 0, 0, 1, 1);
    return [...context.getImageData(0, 0, 1, 1).data.slice(0,3)];
}
img = document.querySelector("#banner img");
img.addEventListener("load", function () {
    console.log(get_average_rgb(img));
    document.querySelector("#banner").style.setProperty("--album-color",`rgb(${get_average_rgb(img).join(",")})`);
});
// document.addEventListener("DOMContentLoaded", function () {
//     document.querySelector("#banner").style.backgroundColor = get_average_rgb(img);
// });