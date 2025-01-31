<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>

    <style>
        * {
            margin: 0 0 !important;
            padding: 0 0 !important;
        }

        body {
            box-sizing: border-box !important;
        }

        header {
            height: 100px !important;
        }
        .header {
            display: flex !important;
            background-color: lightgreen !important;
        }
        .logo,
        .org,
        .header .contact {
            flex: 1 !important;
        }

        .logo img {
            width: 250px !important;
            height: 100% !important;
            padding-left: 15px !important;
        }
        .org {
            text-align: center !important;
            font-size: 45px !important;
            font-weight: bold !important;
        }
        .header .contact {
            text-align: right !important;
        }
        .header .contact p {
            display: block !important;
            padding: 8px 15px 3px 0 !important;
            line-height: 10px !important;
        }
        .header .contact span {
            font-size: 18px !important;
            font-weight: bold !important;
            padding: 0 18px 3px 0 !important;
        }
        /* content */
        .content {
            margin: 20px !important;
            background-color: lightcoral !important;
        }

            /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0;
            right: 0;
            left: 0;
            height: 100px !important;
        }
        .footer {
            display: flex !important;
            padding: 5px !important;
            background-color: lightgreen !important;
        }
        .left,
        .center,
        .right {
            flex: 1;
        }

        .center {
            text-align: center !important;
        }
        .center .address,
        .center .copyright,
        .footer .center .contact {
            display: block !important;
            padding: 3px !important;
        }

        .footer .right {
            text-align: right;
        }
        .footer .date {
            position: fixed;
            bottom: 5%;
            right: 15px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>

</head>
<body>

    <div class="app">
        <header class="header">
            <div class="logo">
                <img src="https://via.placeholder.com/200x200" alt="">
            </div>
            <div class="org">Organization</div>
            <div class="contact">
                <p>Phone No. <span>5465645644</span></p>
                <p>Mobile No. <span>5465645644</span></p>
                <p>Whatsapp No. <span>5465645644</span></p>
                <p>Fax No. <span>5465645644</span></p>
            </div>
        </header>

        <div class="content">

        </div>

        <footer class="footer">
            <div class="left"></div>
            <div class="center">
                <div class="address">softagics ghar ka address</div>
                <div class="contact">emailaddress@softagics.com</div>
                <div class="copyright">&copy; copyright Softagics.com 2019</div>
            </div>
            <div class="right">
                <div class="date">
                    {{ now() }}
                </div>
            </div>
        </footer>
    </div>

</body>
</html>

