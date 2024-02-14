document.addEventListener("DOMContentLoaded", function() {
    const openbtns = document.querySelectorAll('#openbtn');
    openbtns.forEach(function(openbtn) {
        openbtn.addEventListener('click', function() {
            console.log('haha');
            const dialog = openbtn.nextElementSibling;
            dialog.toggleAttribute('open');
        });
    });
});