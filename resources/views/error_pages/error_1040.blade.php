<html>
<head>

</head>

<body>


<style>

    #error-page {
        background-color:#53C1C0;;
        position:fixed !important;
        position:absolute;
        text-align:center;
        top:0;
        right:0;
        bottom:0;
        left:0;
        z-index:99999;
    }
    #error-inner {
        margin: auto;
    }
    #error-inner h1 {
        text-transform:uppercase;color:white;margin-top:20px;font-size:20px;
    }
    .pesan-eror{
        width:600px;
        height:200px;
        margin:0 auto 40px;
        background:#ffc754;
        color:#fff;
        font-size:100px;
        line-height:200px;
        -moz-border-radius-topleft: 75px;
        -moz-border-radius-topright:75px;
        -webkit-border-top-left-radius:75px;
        -webkit-border-top-right-radius:75px;
        border-top-left-radius:95px;
        border-top-right-radius:95px;
        border-bottom-left-radius:14px;
        border-bottom-right-radius:14px;
        position:relative;
        animation-name: floating;
        -webkit-animation-name: floating;

        animation-duration: 1.5s;
        -webkit-animation-duration: 1.5s;

        animation-iteration-count: infinite;
        -webkit-animation-iteration-count: infinite;
    }

    @keyframes floating {
        0% {
            transform: translateY(0%);
        }
        50% {
            transform: translateY(8%);
        }
        100% {
            transform: translateY(0%);
        }
    }

    @-webkit-keyframes floating {
        0% {
            -webkit-transform: translateY(0%);
        }
        50% {
            -webkit-transform: translateY(8%);
        }
        100% {
            -webkit-transform: translateY(0%);
        }
    }
    .pesan-eror::after {
        content:" ";
        width:0;
        height:0;
        bottom:-17px;
        border-color:#ffc754 transparent transparent;
        border-style:solid;
        border-width:20px 20px 0;
        position:absolute;
        left:40%;
    }
    .balik-home {
        position:relative;
        margin:20px auto;
        display:block;
        padding:10px 15px 10px 15px;
        font-family:"Helvetica Neue", Helvetica;
        font-size:30px;
        background:#f26964;
        border:0;
        color:#fff;
        border-radius:3px;
        outline:none;
        width:600px;
        height:40px;
        cursor:pointer;

    }

    .balik-home:hover {
        background:none;
    }

    .balik-home:after,.balik-home:before {
        position:absolute;
        background:#285677;
        content:"";
        width:0%;
        height:100%;
        bottom:0px;
        left:0;
        z-index:-999999999;
        border-radius:3px;
    }

    .balik-home:before {
        background:#f26964;
        width:100%;
    }

    .balik-home:hover:after {
        width:100%;
        -webkit-transition: all 1s ease-in-out;
        -moz-transition: all 1s ease-in-out;
        transition: all 1s ease-in-out;
    }
    .balik-home a{color:white;text-decoration:none}


</style>


<div id='error-page'>
    <div id='error-inner'>
        <h1>The Website is currently down for</h1>
        <div class="pesan-eror">Maintainance</div>
        <p class="balik-home"><a href="#">We apologize for any inconveniences caused. We are almost done.</a></p><br/>
    </div>
</div>

</body>


</html>
