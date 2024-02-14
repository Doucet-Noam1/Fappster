<?php
require 'Classes/autoloader.php';
Autoloader::register();
use onzeur\Type\BD;

?>
<html>

<body>
    <!-- <input type="text">
    <select>
        <option name="test1" value="test1">test1</option>
        <option name="test2" value="test2">test2</option>
    </select> -->
    <p>Artistes participants</p>
    <ul id="liste">
        <li>Toi</li>
    </ul>
    <form action="javascript:add()">
    <input type="text" name="feats" list="artistes" autocomplete="off">
    <button type="submit">Ajouter</button>
    <datalist id="artistes"></datalist>
    </form>
    <script>
        let input = document.querySelector("input[name=feats]")
        let datalist = document.querySelector("datalist[id=artistes]")
        let list = document.querySelector("#liste")
        let feats = []
        input.addEventListener("input", async (event) => {
            let url = `http://localhost:8080/api.php?id=${input.value}`
            console.log(url)
            let response = await fetch(url)
            let json = await response.json()
            datalist.innerHTML = ""
            console.log(datalist.childNodes)
            json.forEach(function (item) {
                var option = document.createElement('option');
                option.value = item.pseudo;
                datalist.appendChild(option);
            });
        })
        function add(){
            var li = document.createElement('li');
            li.innerHTML=input.value
            list.appendChild(li)
            input.value=""
        }
        console.log(datalist)
        console.log(input)
    </script>

</body>

</html>