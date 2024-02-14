document.addEventListener("DOMContentLoaded",function(){
    const dialog = document.querySelector('#dialog');
    console.log(dialog);
    const openbtn = document.querySelector('#openbtn');
    console.log(openbtn);
    openbtn.addEventListener('click', function() {
        console.log('haha');
        dialog.toggleAttribute('open');
        });
         
}
);