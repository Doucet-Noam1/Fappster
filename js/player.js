function clickPlayer(tr,file) {
    console.log(file);
    let titre = tr.children[1].innerText;
    let artistes = tr.children[2].innerText;
    artistes = artistes.split(' & ');
    let artistesString = '';
    for (let i = 0; i < artistes.length; i++) {
        artistesString += artistes[i];
        if (i < artistes.length - 1) {
            artistesString += '_';
        }
    }
    document.querySelector('audio').src = `/data/audios/${file}`;
    document.querySelector('audio').play();
    document.querySelector('#titrePlayer').innerText = titre;
    document.querySelector('#artistesPlayers').innerText = artistes.join(' & ');
}