document.addEventListener("DOMContentLoaded", function () {
    const openbtns = document.querySelectorAll('.openbtn');

    openbtns.forEach(function (openbtn) {
      openbtn.addEventListener('click', function (e) {
        e.stopPropagation();
        closeAllDialogs(); // Close any open dialogs
        const dialog = openbtn.nextElementSibling;
        dialog.toggleAttribute('open');
      });
    });

    window.addEventListener('click', function (e) {
      const openDialog = document.querySelector('dialog[open]');
      if (openDialog && !openDialog.contains(e.target) && openDialog.previousSibling !== e.target && this.document) {
        openDialog.toggleAttribute('open');
      }
    });

    function closeAllDialogs() {
      const openDialogs = document.querySelectorAll('dialog[open]');
      openDialogs.forEach(function (dialog) {
        dialog.toggleAttribute('open');
      });
    }
  });