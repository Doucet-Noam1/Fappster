let list, input;
function add() {
    if (input.value === "") {
        input.placeholder = "Artiste vide !"
        input.style.border = "1px solid red"
        return
    }
    var li = document.createElement('li');
    var nouvelArtiste = document.createElement('input');
    nouvelArtiste.readOnly = "readonly";
    nouvelArtiste.value = input.value;
    nouvelArtiste.name = "feats[]";
    nouvelArtiste.classList.add("mini")
    li.appendChild(nouvelArtiste);
    if (document.location.pathname.includes("Sortie.php")) {
        var type = document.querySelector("select[name='type']").value
        if (type != "4") {
            var role = document.createElement('select');
            role.name = "roles[]";
            role.classList.add("mini")
            var option = document.createElement('option');
            option.value = "artiste";
            option.innerHTML = "Artiste";
            role.appendChild(option);
            option = document.createElement('option');
            option.value = "credit";
            option.innerHTML = "Credit (Prod, Mix, Master, etc...)";
            role.appendChild(option);
            li.appendChild(role);
        }
    }
    var suppr = document.createElement('button');
    suppr.innerHTML = "Supprimer";
    suppr.onclick = function () {
        li.remove()
    }
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
    let datalist = document.querySelector("datalist#dataArtistes")
    list = document.querySelector("#artistes")
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