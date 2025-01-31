

    function showSnackBar(text) {
        // Get the snackbar DIV
        let shackBar = document.getElementById('snackbar');

        shackBar.innerText = text + ' Copied';

        // Add the '_show' class to DIV
        shackBar.className = 'show';

        // After 3 seconds, remove the _show class from DIV
        setTimeout(function(){ shackBar.className = shackBar.className.replace('show', ''); }, 3000);
    }

    function copyThis(item) {

        let text = item.innerHTML.trim();
//        let text1 = text.replace('<span>', '');
        let copyText = text.replace('</span>', '');

        // Create new element
        let el = document.createElement('textarea');

        // Set value (string to be copied)
        el.value = copyText;

        // Set non-editable to avoid focus and move outside of view
        el.setAttribute('readonly', '');
        el.style = {position: 'absolute', left: '-9999px'};
        document.body.appendChild(el);

        // Select text inside element
        el.select();

        // Copy text to clipboard
        document.execCommand('copy');

        // Remove temporary element
        document.body.removeChild(el);

        showSnackBar(copyText);
    }
