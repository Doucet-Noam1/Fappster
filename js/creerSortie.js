document.addEventListener("DOMContentLoaded", async function () {
    let date = document.querySelector("input#date")
    date.min = new Date().toISOString().split("T")[0]
    date.value = date.min
    let selects = document.querySelectorAll("select#titres, select#genres")
    selects.forEach(function (select) {
        select.addEventListener("change", function () {
            let titre = select.value
            if (titre === "") {
                return
            }
            let li = document.createElement("li")
            let input = document.createElement("input")
            input.readOnly = "readonly"
            input.value = select.querySelector(`option[value="${titre}"]`).innerHTML
            input.classList.add("mini")
            li.appendChild(input)
            let hidden = document.createElement("input")
            hidden.type = "hidden"
            hidden.value = titre
            hidden.name = `${select.id}[]`
            li.appendChild(hidden)
            let suppr = document.createElement("button")
            suppr.innerHTML = "Supprimer"
            let elem = select.querySelector(`option[value="${titre}`)
            elem.disabled = true
            suppr.onclick = function () {
                li.remove()
                elem.disabled = false
            }
            li.appendChild(suppr)
            select.parentElement.before(li)
            select.value = ""
        })
    })
    let selectType = document.querySelector("select[name='type']")
    selectType.addEventListener("change", function () {
        if (selectType.value == "4") {
            document.querySelector("#sortiecommerciale").classList.add("dont-show")
            document.querySelectorAll("#contenu li button").forEach(function (button) {
                button.click() = true
            })
        }else{
            document.querySelector("#sortiecommerciale").classList.remove("dont-show")
        }
    })
})
