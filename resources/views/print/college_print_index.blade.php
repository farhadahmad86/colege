 @if( $type !== 'download_excel')
    <!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href='{{asset("public/vendors/styles/print_main_style.css")}}' media="screen, print">
    <link rel="stylesheet" href='{{asset("public/vendors/styles/table_styles.css")}}' media="screen, print">

    <title> @yield('print_title') </title>

    {{-- <style type="text/css"> --}}
        @yield('print_styles') 
    {{-- </style> --}}
    <style>


        *, *::before, *::after {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        *, *:after, *:before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            margin-bottom: 0.5px;
            font-family: inherit;
            font-weight: 500;
            line-height: 1.2;
            color: inherit;
        }

        h2, .h2 {
            font-size: 2px;
        }

        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: 0.5px;
        }

        b, strong {
            font-weight: bolder;
        }

        table {
            border-collapse: collapse;
        }

        .border-0 {
            border: 0 !important;
        }

        table,
        .table {
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 0;
            background-color: transparent;
        }

        .bg-transparent td {
            vertical-align: top;
        }

        .bg-transparent {
            background-color: transparent !important;
        }

        .table th, .table td {
            padding: .5px .3px;
            line-height: 17px;
            vertical-align: middle;
            font-size: 14px;
        }

        .table-sm th, .table-sm td {
            padding: .2px .2px;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #000;
            /* background-color: rgba(48,90,114,1); */
            /* color: #fff; */
        }

        .table th {
            font-weight: 600;
        }

        .btn-group, .btn-group-vertical {
            position: relative;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            /* vertical-align: middle; */
            vertical-align: top;
        }

        input, button, select, optgroup, textarea {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        button, input {
            overflow: visible;
        }

        button, select {
            text-transform: none;
        }

        a, input, button {
            outline: none !important;
        }

        .btn {
            letter-spacing: 0.035em;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375px 0.75px;
            font-size: 1px;
            line-height: 1.5;
            border-radius: 0.25px;
            -webkit-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        }

        button, html [type="button"], [type="reset"], [type="submit"] {
            -webkit-appearance: button;
        }

        .btn-group > .btn, .btn-group-vertical > .btn {
            position: relative;
            -webkit-box-flex: 0;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
        }

        .btn:not(:disabled):not(.disabled) {
            cursor: pointer;
        }

        .btn-group > .btn:first-child {
            margin-left: 0;
        }

        .btn-group > .btn:not(:last-child):not(.dropdown-toggle), .btn-group > .btn-group:not(:last-child) > .btn {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .btn-group > .btn:hover, .btn-group-vertical > .btn:hover {
            z-index: 1;
        }

        .btn-group > .btn:focus, .btn-group > .btn:active, .btn-group > .btn.active, .btn-group-vertical > .btn:focus, .btn-group-vertical > .btn:active, .btn-group-vertical > .btn.active {
            z-index: 1;
        }

        .btn-group .btn + .btn, .btn-group .btn + .btn-group, .btn-group .btn-group + .btn, .btn-group .btn-group + .btn-group, .btn-group-vertical .btn + .btn, .btn-group-vertical .btn + .btn-group, .btn-group-vertical .btn-group + .btn, .btn-group-vertical .btn-group + .btn-group {
            margin-left: -1px;
        }

        .btn-group > .btn:not(:first-child), .btn-group > .btn-group:not(:first-child) > .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .btn:not(:disabled):not(.disabled):active, .btn:not(:disabled):not(.disabled).active {
            background-image: none;
        }

        .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #0062cc;
            border-color: #005cbf;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn:hover, .btn:focus {
            text-decoration: none;
        }

        .grp_btn {
            display: inline-block;
            background-color: rgba(48, 90, 114, 1);
            border-radius: 0;
            font-size: 14px;
            color: #fff;
            min-height: 28px;
            height: auto;
            line-height: 26px;
            padding: 0 10px 0 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
            -moz-box-shadow: 0 0 0 transparent;
            -webkit-box-shadow: 0 0 0 transparent;
            box-shadow: 0 0 0 transparent;
            border: 1px solid rgba(48, 122, 165, 1);
            cursor: pointer;
            transition: all ease-in-out 300ms;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            -webkit-clip-path: inset(50%);
            clip-path: inset(50%);
            border: 0;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }

        .dropdown-toggle::after {
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }

        .dropdown-toggle::after {
            content: '';
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 8px solid #fff;
            font-family: "FontAwesome";
            vertical-align: unset;
            width: auto;
            height: auto;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 10px;
            padding: 0.5px 0;
            margin: 0.125px 0 0;
            font-size: 1px;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.25px;
        }

        .dropdown-menu {
            border-color: #cccccc;
            border: 0;
            padding: 0;
            border-radius: 4px;
            -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 7px 15px;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }

        .dropdown-item {
            font-size: 15px;
            font-weight: 400;
            padding: 5px 10px;
            color: #667f87;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .dropdown-item {
            font-size: 14px;
        }

        .dropdown-menu.show {
            display: block;
        }


        .m-0 {
            margin: 0 !important;
        }

        .mt-0,
        .my-0 {
            margin-top: 0 !important;
        }

        .mr-0,
        .mx-0 {
            margin-right: 0 !important;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .ml-0,
        .mx-0 {
            margin-left: 0 !important;
        }

        .m-1 {
            margin: 0.25px !important;
        }

        .mt-1,
        .my-1 {
            margin-top: 0.25px !important;
        }

        .mr-1,
        .mx-1 {
            margin-right: 0.25px !important;
        }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25px !important;
        }

        .ml-1,
        .mx-1 {
            margin-left: 0.25px !important;
        }

        .m-2 {
            margin: 0.5px !important;
        }

        .mt-2,
        .my-2 {
            margin-top: 0.5px !important;
        }

        .mr-2,
        .mx-2 {
            margin-right: 0.5px !important;
        }

        .mb-2,
        .my-2 {
            margin-bottom: 0.5px !important;
        }

        .ml-2,
        .mx-2 {
            margin-left: 0.5px !important;
        }

        .m-3 {
            margin: 1px !important;
        }

        .mt-3,
        .my-3 {
            margin-top: 1px !important;
        }

        .mr-3,
        .mx-3 {
            margin-right: 1px !important;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1px !important;
        }

        .ml-3,
        .mx-3 {
            margin-left: 1px !important;
        }

        .m-4 {
            margin: 1.5px !important;
        }

        .mt-4,
        .my-4 {
            margin-top: 1.5px !important;
        }

        .mr-4,
        .mx-4 {
            margin-right: 1.5px !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5px !important;
        }

        .ml-4,
        .mx-4 {
            margin-left: 1.5px !important;
        }

        .m-5 {
            margin: 3px !important;
        }

        .mt-5,
        .my-5 {
            margin-top: 3px !important;
        }

        .mr-5,
        .mx-5 {
            margin-right: 3px !important;
        }

        .mb-5,
        .my-5 {
            margin-bottom: 3px !important;
        }

        .ml-5,
        .mx-5 {
            margin-left: 3px !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        .pt-0,
        .py-0 {
            padding-top: 0 !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pb-0,
        .py-0 {
            padding-bottom: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .p-1 {
            padding: 0.25px !important;
        }

        .pt-1,
        .py-1 {
            padding-top: 0.25px !important;
        }

        .pr-1,
        .px-1 {
            padding-right: 0.25px !important;
        }

        .pb-1,
        .py-1 {
            padding-bottom: 0.25px !important;
        }

        .pl-1,
        .px-1 {
            padding-left: 0.25px !important;
        }

        .p-2 {
            padding: 0.5px !important;
        }

        .pt-2,
        .py-2 {
            padding-top: 0.5px !important;
        }

        .pr-2,
        .px-2 {
            padding-right: 0.5px !important;
        }

        .pb-2,
        .py-2 {
            padding-bottom: 0.5px !important;
        }

        .pl-2,
        .px-2 {
            padding-left: 0.5px !important;
        }

        .p-3 {
            padding: 1px !important;
        }

        .pt-3,
        .py-3 {
            padding-top: 1px !important;
        }

        .pr-3,
        .px-3 {
            padding-right: 1px !important;
        }

        .pb-3,
        .py-3 {
            padding-bottom: 1px !important;
        }

        .pl-3,
        .px-3 {
            padding-left: 1px !important;
        }

        .p-4 {
            padding: 1.5px !important;
        }

        .pt-4,
        .py-4 {
            padding-top: 1.5px !important;
        }

        .pr-4,
        .px-4 {
            padding-right: 1.5px !important;
        }

        .pb-4,
        .py-4 {
            padding-bottom: 1.5px !important;
        }

        .pl-4,
        .px-4 {
            padding-left: 1.5px !important;
        }

        .p-5 {
            padding: 3px !important;
        }

        .pt-5,
        .py-5 {
            padding-top: 5px !important;
        }

        .pr-5,
        .px-5 {
            padding-right: 3px !important;
        }

        .pb-5,
        .py-5 {
            padding-bottom: 3px !important;
        }

        .pl-5,
        .px-5 {
            padding-left: 3px !important;
        }

        .m-auto {
            margin: auto !important;
        }

        .mt-auto,
        .my-auto {
            margin-top: auto !important;
        }

        .mr-auto,
        .mx-auto {
            margin-right: auto !important;
        }

        .mb-auto,
        .my-auto {
            margin-bottom: auto !important;
        }

        .ml-auto,
        .mx-auto {
            margin-left: auto !important;
        }


        .text-justify {
            text-align: justify !important;
        }

        .text-nowrap {
            white-space: nowrap !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }


        .wdth_40_prcnt {
            width: 40%;
        }

        .wdth_50_prcnt {
            width: 50%;
        }

        .invoice_hdng {
            font-weight: bolder;
            font-size: 22px;
        }

        .invoice_para {
            padding: 0px 5px 0;
        }

        /*.invoice_para.adrs{*/
        /*    max-width: 425px;*/
        /*    width: 100%;*/
        /*    white-space: nowrap;*/
        /*    overflow: hidden;*/
        /*    text-overflow: ellipsis;*/
        /*}*/

        .invoice_para.adrs {
            max-width: 565px;
            width: 100%;
            /*white-space: nowrap;*/
            overflow: hidden;
            word-break: break-all;
            text-overflow: ellipsis;
        }

        .invoice_sub_hdng {
            padding: 5px;
            font-size: 14px;
            line-height: 14px;
            font-weight: bolder;
            background: #a5a5a5;
            color: #000;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .wrds_con {
            position: relative;
            border: 1px solid;
            margin: 30px 0;
            width: 100%;
            display: block;
            float: left;
        }

        .wrds_bx {
            position: relative;
            padding: 10px 15px;
            width: 70%;
            display: block;
            float: left;
            border-right: 1px solid;
            text-transform: uppercase;
        }

        .wrds_bx.wrds_bx_two {
            width: 30%;
            border-right: 0px solid;
        }

        .wrds_hdng {
            position: absolute;
            top: -10px;
            background-color: #fff;
            padding: 0 10px;
            left: 5px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .sign_con {
            position: relative;
            margin: 0px 0;
            width: 100%;
            float: left;
            text-align: center;
            display: flex;
            justify-content: center;
        }

        .sign_bx {
            position: relative;
            padding: 30px 15px 0;
            width: 24%;
            display: block;
            float: left;
            text-transform: uppercase;
            text-align: center;
        }

        .sign_itm {
            position: relative;
            padding: 0 10px;
            font-weight: bold;
            text-transform: capitalize;
            border-top: 2px solid;
            width: 90%;
            display: block;
            font-size: 12px;
        }

        .border-bottom-3 {
            border-bottom: 3px double #000 !important;
        }

        .border-top-2 {
            border-top: 2px solid #000 !important;
        }

        .modal-header {
            padding: 5px 1rem;
        }

        .modal-title {
            font-size: 18px;
        }

        .vi_tbl_hdng {
            /*background: #a5a5a5;*/
            color: #000;
        }

    </style>
    <style>
        /*================== table serial width ===========================*/


        .tbl_srl_2{
            width: 2%;
        }

        .tbl_srl_3{
            width: 3%;
        }

        .tbl_srl_4{
            width: 4%;
        }

        .tbl_srl_5{
            width: 5%;
        }

        .tbl_srl_6{
            width: 6%;
        }

        .tbl_srl_7{
            width: 7%;
        }

        .tbl_srl_8{
            width: 8%;
        }

        .tbl_srl_9{
            width: 9%;
        }

        .tbl_srl_10{
            width: 10%;
        }

        .tbl_srl_11{
            width: 11%;
        }

        .tbl_srl_12{
            width: 12%;
        }

        .tbl_srl_100{
            width: 100%;
        }


        /*================== table amount width ===========================*/


        .tbl_amnt_3{
            width: 3%;
        }

        .tbl_amnt_4{
            width: 4%;
        }

        .tbl_amnt_5{
            width: 5%;
        }

        .tbl_amnt_6{
            width: 6%;
        }

        .tbl_amnt_7{
            width: 7%;
        }

        .tbl_amnt_8{
            width: 8%;
        }

        .tbl_amnt_9{
            width: 9%;
        }

        .tbl_amnt_10{
            width: 10%;
        }

        .tbl_amnt_11{
            width: 11%;
        }

        .tbl_amnt_12{
            width: 12%;
        }

        .tbl_amnt_13{
            width: 13%;
        }

        .tbl_amnt_14{
            width: 14%;
        }

        .tbl_amnt_15{
            width: 15%;
        }

        .tbl_amnt_16{
            width: 16%;
        }

        .tbl_amnt_17{
            width: 17%;
        }

        .tbl_amnt_18{
            width: 18%;
        }

        .tbl_amnt_19{
            width: 19%;
        }

        .tbl_amnt_20{
            width: 20%;
        }

        .tbl_amnt_21{
            width: 21%;
        }

        .tbl_amnt_22{
            width: 22%;
        }

        .tbl_amnt_23{
            width: 23%;
        }

        .tbl_amnt_24{
            width: 24%;
        }

        .tbl_amnt_25{
            width: 25%;
        }


        /*================== table text width ===========================*/


        .tbl_txt_6p{
            width: 6.5%;
        }

        .tbl_txt_6{
            width: 6%;
        }

        .tbl_txt_7{
            width: 7%;
        }

        .tbl_txt_8{
            width: 8%;
        }

        .tbl_txt_9{
            width: 9%;
        }

        .tbl_txt_10{
            width: 10%;
        }

        .tbl_txt_10{
            width: 10%;
        }

        .tbl_txt_11{
            width: 11%;
        }

        .tbl_txt_12{
            width: 12%;
        }

        .tbl_txt_13{
            width: 13%;
        }

        .tbl_txt_14{
            width: 14%;
        }

        .tbl_txt_15{
            width: 15%;
        }

        .tbl_txt_16{
            width: 16%;
        }

        .tbl_txt_17{
            width: 17%;
        }

        .tbl_txt_18{
            width: 18%;
        }

        .tbl_txt_19{
            width: 19%;
        }

        .tbl_txt_20{
            width: 20%;
        }

        .tbl_txt_22{
            width: 22%;
        }

        .tbl_txt_24{
            width: 24%;
        }

        .tbl_txt_25{
            width: 25%;
        }

        .tbl_txt_26{
            width: 26%;
        }

        .tbl_txt_27{
            width: 27%;
        }

        .tbl_txt_28{
            width: 28%;
        }

        .tbl_txt_29{
            width: 29%;
        }

        .tbl_txt_30{
            width: 30%;
        }

        .tbl_txt_31{
            width: 31%;
        }

        .tbl_txt_32{
            width: 32%;
        }

        .tbl_txt_33{
            width: 33%;
        }

        .tbl_txt_34{
            width: 34%;
        }

        .tbl_txt_35{
            width: 35%;
        }

        .tbl_txt_36{
            width: 36%;
        }

        .tbl_txt_38{
            width: 38%;
        }

        .tbl_txt_40{
            width: 40%;
        }

        .tbl_txt_41{
            width: 41%;
        }

        .tbl_txt_41{
            width: 41%;
        }

        .tbl_txt_43{
            width: 42%;
        }

        .tbl_txt_44{
            width: 44%;
        }

        .tbl_txt_45{
            width: 45%;
        }

        .tbl_txt_46{
            width: 46%;
        }

        .tbl_txt_47{
            width: 47%;
        }

        .tbl_txt_48{
            width: 48%;
        }

        .tbl_txt_49{
            width: 49%;
        }

        .tbl_txt_50{
            width: 50%;
        }

        .tbl_txt_51{
            width: 51%;
        }

        .tbl_txt_52{
            width: 52%;
        }

        .tbl_txt_53{
            width: 53%;
        }

        .tbl_txt_54{
            width: 54%;
        }

        .tbl_txt_55{
            width: 55%;
        }

        .tbl_txt_56{
            width: 56%;
        }

        .tbl_txt_57{
            width: 57%;
        }

        .tbl_txt_58{
            width: 58%;
        }

        .tbl_txt_59{
            width: 59%;
        }

        .tbl_txt_60{
            width: 60%;
        }

        .tbl_txt_61{
            width: 61%;
        }

        .tbl_txt_62{
            width: 62%;
        }

        .tbl_txt_63{
            width: 63%;
        }

        .tbl_txt_64{
            width: 64%;
        }

        .tbl_txt_65{
            width: 65%;
        }

        .tbl_txt_66{
            width: 66%;
        }

        .tbl_txt_67{
            width: 67%;
        }

        .tbl_txt_68{
            width: 68%;
        }

        .tbl_txt_69{
            width: 69%;
        }

        .tbl_txt_70{
            width: 70%;
        }

        .tbl_txt_71{
            width: 71%;
        }

        .tbl_txt_72{
            width: 72%;
        }

        .tbl_txt_73{
            width: 73%;
        }

        .tbl_txt_74{
            width: 74%;
        }

        .tbl_txt_75{
            width: 75%;
        }

        .tbl_txt_76{
            width: 76%;
        }

        .tbl_txt_77{
            width: 77%;
        }

        .tbl_txt_78{
            width: 78%;
        }

        .tbl_txt_79{
            width: 79%;
        }
        .tbl_txt_80{
            width: 80%;
        }
        .tbl_txt_84{
            width: 84%;
        }



        .rjct_acpt_btn.btn-sm {
            padding: 0.15rem 0.15rem;
            font-size: 0.775rem;
            line-height: 1.2;
        }
        .signature, p{
        display: inline
}

        /*.table th, .table td {*/
        /*    border: 1px solid rgba(0,0,0,1);*/
        /*    padding: .2rem .2rem;*/
        /*    !*word-break: break-all;*!*/
        /*    position: relative;*/
        /*    overflow: hidden;*/

        /*}*/


        .table td, .table th {
            border: 1px solid #dee2e6;
        }
    </style>

</head>

<body>
   
     @include('print._partials.pdf_college_header') 
    @endif
    @yield('print_cntnt')

    @if( isset($type) && $type !== 'download_excel')
    <table class="table border-0 m-0 p-0">
        <tfoot>
        <tr class="bg-transparent">
            <td colspan="4" class="border-0 m-0 p-0">
                <div class="page-footer-space"></div>
            </td>
        </tr>
        </tfoot>
    </table>

    @if($type === 'print')
        <!-- Split button -->
        <div class="btns_bx">
            <div class="btn-group">
                <button type="button" class="btn btn-primary grp_btn" onclick="prnt_cus('print')"></button>
                <button type="button" class="btn btn-primary dropdown-toggle grp_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right print_act_drp hide_column" x-placement="bottom-end">
                    <button type="button" class="dropdown-item" id="" onclick="prnt_cus()">
                        <i class="fa fa-print"></i> PDF
                    </button>
                    <button type="button" class="dropdown-item" id="excelTable">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </button>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            function prnt_cus(str) {
                window.focus();
                if (str === 'print') {
                    window.print();
                }
            }

        </script>
    @endif


    @yield('print_scrpt')

</body>
</html>
@endif 
