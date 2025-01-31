<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 13-Jun-20
 * Time: 10:49 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<html>
<head>

    <title>Generate Hash</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->

    <style>

        #snackbar {
            visibility: hidden; /* Hidden by default. Visible on click */
            min-width: 250px; /* Set a default minimum width */
            margin-left: -325px; /* Divide value of min-width by 2 */
            background-color: #333; /* Black background color */
            color: #fff; /* White text color */
            text-align: center; /* Centered text */
            border-radius: 2px; /* Rounded borders */
            padding: 16px; /* Padding */
            position: fixed; /* Sit on top of the screen */
            z-index: 1; /* Add a z-index if needed */
            left: 50%; /* Center the snackbar */
            bottom: 30px; /* 30px from the bottom */
        }

        /* Show the snackbar when clicking on a button (class added with JavaScript) */
        #snackbar.show {
            visibility: visible; /* Show the snackbar */
            /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
            However, delay the fade out process for 2.5 seconds */
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }

        .hide {
            display: none;
        }

    </style>

    <script>
        $(function () {

            $('form').on('submit', function (e) {

                e.preventDefault();

                $.ajax({
                    type: 'post',
                    url: 'generate_password_hash.php',
                    data: $('form').serialize(),
                    success: function (data) {
                        let values = data.split(';');

                        $("#success").removeClass("hide");

                        let hash = values[1];
                        $("#success").html(hash);

                    }
                });

            });

        });


        function showSnackBar(text) {
            // Get the snackbar DIV
            let shackBar = document.getElementById('snackbar');

            shackBar.innerText = text + ' Copied';

            // Add the '_show' class to DIV
            shackBar.className = 'show';

            // After 3 seconds, remove the _show class from DIV
            setTimeout(function(){
                shackBar.className = shackBar.className.replace('show', '');
                // shackBar.removeClass("show");
            }, 3000);
        }

        function copyThis(item) {

            // let text = item.innerHTML;
            // let text1 = text.replace('<span>', '');
            // let copyText = text.replace('</span>', '');

            let copyText = item.innerHTML;

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

    </script>

</head>
<body style="width: 100%; height: 100%">

<h2 style="text-align: center; padding-top: 22px">Generate Hash</h2>

<div class="container" style="margin: auto; padding: 16px">

    <form id="entry_form" method="post" action="./generate_password_hash.php">

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" class="form-control" id="password" placeholder="Password" name="password">
        </div>

        <input type="hidden" name="hash">
        <button type="submit" class="btn btn-primary">Submit</button>
        <h4 id="success" style="background-color: green; color: white; padding: 16px" class="hide" onclick='copyThis(this)'></h4>
    </form>

</div>
<div id="snackbar"></div>
</body>
</html>
