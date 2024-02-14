let list, input;
function add() {
    if(input.value === "") {
        input.placeholder = "Artiste vide !"
        input.style.border = "1px solid red"
        return
    }
    var li = document.createElement('li');
    var nouvelArtiste = document.createElement('input');
    nouvelArtiste.readonly = true;
    nouvelArtiste.value = input.value;
    nouvelArtiste.name = "feats[]";
    nouvelArtiste.classList.add("mini")
    var suppr = document.createElement('button');
    suppr.innerHTML = "Supprimer";
    suppr.onclick = function () {
        li.remove()
    }
    li.appendChild(nouvelArtiste);
    li.appendChild(suppr);
    list.insertBefore(li, list.querySelector("li:last-child"))
    input.value = ""
}
function cancelForm(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        add();
    }
}
document.addEventListener("DOMContentLoaded", async function () {
    input = document.querySelector("input#inputArtistes")
    let datalist = document.querySelector("datalist[id=artistes]")
    list = document.querySelector("#liste")
    console.log(list)
    let feats = []
    feats.push(list.querySelector("li p").innerHTML)
    input.addEventListener("input", async (event) => {
        input.placeholder = "Artiste"
        input.style.border = ""
        let url = `http://localhost:8080/api.php?id=${input.value}`
        let response = await fetch(url)
        let json = await response.json()
        datalist.innerHTML = ""
        json.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item.pseudo;
            datalist.appendChild(option);
        });
    })
})