document.querySelectorAll("#likes, #playlists").forEach(function (element) {
    element.addEventListener("wheel", function (event) {
        event.preventDefault()
        if(event.deltaX !== 0) {
            element.scrollLeft += event.deltaY + event.deltaX
        }
    })
})