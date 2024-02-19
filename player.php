<?php

?>

<script src="js/player.js"></script>
<link rel="stylesheet" href="css/player.css">
<footer>
    <div id='divAudio'>
        <h2 id='titrePlayer'></h2>
        <audio controls src=""></audio>
        <h2 id='artistesPlayers'></h2>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        let player = document.querySelector('footer');
        // let player = document.createElement('footer');
        document.body.appendChild(player);
    })
</script>