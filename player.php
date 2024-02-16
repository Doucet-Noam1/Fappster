<?php

?>


<link rel="stylesheet" href="css/player.css">
<footer>
    <div id='divAudio'>
        <h2 id='titrePlayer'></h2>
        <audio controls src=""></audio>
        <h2 id='artistesPlayers'></h2>
    </div>
</footer>
<script>
    function clickPlayer(tr) {
        let titre = tr.children[1].innerText;
        let artistes = tr.children[2].innerText;
        console.log(titre);
        console.log(artistes);
        artistes = artistes.split(' & ');
        console.log(artistes);
        let artistesString = '';
        for (let i = 0; i < artistes.length; i++) {
            artistesString += artistes[i];
            if (i < artistes.length - 1) {
                artistesString += '_';
            }
        }
        document.querySelector('audio').src = '/data/audios/' + titre +"_"+artistesString+ '.mp3';
        document.querySelector('#titrePlayer').innerText = titre;
        document.querySelector('#artistesPlayers').innerText = artistes.join(' & ');
    }
        
</script>