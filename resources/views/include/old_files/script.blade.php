<!-- js -->
<script src={{asset("public/vendors/scripts/script.js")}}></script>

{{--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}

{{--<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">--}}
<script src={{asset("public/tableHeadFixer.js")}}></script>

<script src={{asset("public/src/plugins/highcharts-6.0.7/code/highcharts.js")}}></script>
<script src={{asset("public/src/plugins/highcharts-6.0.7/code/highcharts-more.js")}}></script>
<script src={{asset("public/sidebar_js/script.js")}}></script>
<script src={{asset("public/excel_js/jquery.table2excel.js")}}></script>

<style>

table a{
    color: #0099ff !important;
}
</style>


@php
    $company_info = Session::get('company_info');
if(isset($company_info) || !empty($company_info)){
$print_logo = $company_info->ci_logo;
$print_name = $company_info->ci_name;
$print_ptcl = $company_info->ci_ptcl_number;
$print_mobile = $company_info->ci_mobile_numer;
$print_whatsapp = $company_info->ci_whatsapp_number;
$print_fax = $company_info->ci_fax_number;
$print_email = $company_info->ci_email;
$print_address = $company_info->ci_address;
}else{
$print_logo = '';
$print_name = '';
$print_ptcl = '';
$print_mobile = '';
$print_whatsapp = '';
$print_fax = '';
$print_email = '';
$print_address = '';
}
@endphp

<script>
    $(document).ready(function () {
        $("#fixTable").tableHeadFixer();
    });
</script>
<script type="text/javascript">
    jQuery(function () {
        jQuery('.datepicker1').datepicker({
            language: 'en', dateFormat: 'dd-M-yyyy'
        });
    });

    var print_img = '{{$print_logo}}';
    var print_org = '{{$print_name}}';
    var print_phone = '{{$print_ptcl}}';
    var print_mobile = '{{$print_mobile}}';
    var print_whatsapp = '{{$print_whatsapp}}';
    var print_fax = '{{$print_fax}}';
    var print_email = '{{$print_email}}';
    var print_address = '{{$print_address}}';
    var print_copyright = 'copyright Softagics.com 2019';

    var printContents ='';

    jQuery("#print").click(function () {
        // jQuery('.hide_column').hide();
        // var divToPrint = document.getElementById('printTable');
        // var htmlToPrint = '' +
        //     '<style type="text/css">' +
        //     'table th, table td {' +
        //     'border:0.5px solid #000;' +
        //     'padding:0.5em;' +
        //     '}' +
        //     '</style>';
        // // var htmlToPrint = '';
        // htmlToPrint += divToPrint.outerHTML;
        // newWin = window.open("");
        // newWin.document.write(htmlToPrint);
        // newWin.print();
        // newWin.close();
        // jQuery('.hide_column').show();

        var company_info_check_box = $("#company_info_check_box").prop("checked");

        if(company_info_check_box == true){

            jQuery('.hide_column').hide();
            // var img = 'http://www.jadeedbazar.com/financials_laravel/public/vendors/images/my_logo.png';
            // var org = 'Softagics';
            // var phone = '061-6549871';
            // var mobile = '0300-1234567';
            // var whatsapp = '+92300-3216547';
            // var fax = '061-6549871';
            // var email = 'emailaddress@softagics.com';
            // var address = 'Softagics address';
            // var copyright = 'copyright Softagics.com 2019';

             printContents = document.getElementById('printTable').innerHTML;


            var header = '' +
                '<!DOCTYPE html>\n' +
                '<html>\n' +
                '\n' +
                '<head>\n' +
                '\n' +
                '    <style>\n' +
                '        /* Styles go here */\n' +
                '\n' +
                '        body {\n' +
                '           background-color: white !important;' +
                // '            box-sizing: border-box !important;\n' +
                '        }\n' +
                '        .page-header, .page-header-space {\n' +
                '            height: 100px;\n' +
                '        }\n' +
                '\n' +
                '        .page-footer, .page-footer-space {\n' +
                '            height: 100px;\n' +
                '\n' +
                '        }\n' +
                '\n' +
                '        .page-footer {\n' +
                '            position: fixed;\n' +
                '            bottom: 0;\n' +
                '            width: 100%;\n' +
                '            border-top: 1px solid black; /* for demo */\n' +
                '            background: #EAEAEA; /* for demo */\n' +
                '        }\n' +
                '\n' +
                '        .page-header {\n' +
                '            position: fixed;\n' +
                '            top: 0mm;\n' +
                '            width: 100%;\n' +
                '            border-bottom: 1px solid black; /* for demo */\n' +
                '            background: #EAEAEA; /* for demo */\n' +
                '        }\n' +
                '\n' +
                '\n' +
                '        header {\n' +
                '            height: 100px !important;\n' +
                '        }\n' +
                '\n' +
                '\n' +
                '        .header {\n' +
                '            position: relative !important;\n' +
                '            display: flex !important;\n' +
                '            background-color: #EAEAEA !important;\n' +
                '        }\n' +
                '\n' +
                '        .logo,\n' +
                '        .org,\n' +
                '        .header .contact {\n' +
                '            color: #242424 !important;\n' +
                '            flex: 1 !important;\n' +
                '        }\n' +
                '\n' +
                '        .logo {\n' +
                '            text-align: left !important;\n' +
                '        }\n' +
                '\n' +
                '        .logo img {\n' +
                '            width: 250px !important;\n' +
                '            height: 100% !important;\n' +
                '        }\n' +
                '\n' +
                '        .org {\n' +
                '            text-align: center !important;\n' +
                '            font-size: 45px !important;\n' +
                '            font-weight: bold !important;\n' +
                '            padding-top: 15px !important;\n' +
                '        }\n' +
                '\n' +
                '        .header .contact {\n' +
                '            text-align: right !important;\n' +
                '        }\n' +
                '\n' +
                '        .header .contact p {\n' +
                '            display: block !important;\n' +
                '            padding: 8px 15px 3px 0 !important;\n' +
                '            line-height: 10px !important;\n' +
                '        }\n' +
                '\n' +
                '        .header .contact span {\n' +
                '            font-size: 18px !important;\n' +
                '            font-weight: bold !important;\n' +
                '            padding: 0 18px 3px 0 !important;\n' +
                '        }\n' +
                '\n' +
                '        p {\n' +
                '            margin: 0;\n' +
                '        }\n' +
                '        table {\n' +
                '            width: 100% !important;\n' +
                '        }\n' +
                '       #fixTable {' +
                '           width: 100% !important;' +
                '           margin: 0 !important;' +
                '           font-size: 15px !important;' +
                '       }' +
                '       #fixTable a {' +
                '           color: black !important;' +
                '       }' +
                '       .table-bordered {\n' +
                '           border: 1px solid #131e22 !important; ' +
                '       }\n' +
                '       \n' +
                '       .table-bordered th,\n' +
                '       .table-bordered td {\n' +
                '           border: 1px solid #131e22 !important; ' +
                '        }' +
                '\n' +
                '        footer {\n' +
                '            position: relative !important;\n' +
                '            height: 100px !important;\n' +
                '        }\n' +
                '\n' +
                '        .footer {\n' +
                '            display: flex !important;\n' +
                '            padding: 5px !important;\n' +
                '            background-color: #EAEAEA !important;\n' +
                '        }\n' +
                '\n' +
                '        .left,\n' +
                '        .center,\n' +
                '        .right {\n' +
                '            flex: 1;\n' +
                '        }\n' +
                '\n' +
                '        .center {\n' +
                '            text-align: center !important;\n' +
                '        }\n' +
                '\n' +
                '        .center .address,\n' +
                '        .center .copyright,\n' +
                '        .footer .center .contact {\n' +
                '            display: block !important;\n' +
                '            padding: 3px !important;\n' +
                '        }\n' +
                '\n' +
                '        .footer .right {\n' +
                '            text-align: right !important;\n' +
                '        }\n' +
                '\n' +
                '        .footer .date {\n' +
                '            position: absolute !important;\n' +
                '            bottom: 10px !important;\n' +
                '            right: 15px !important;\n' +
                '            font-size: 18px !important;\n' +
                '            font-weight: bold !important;\n' +
                '        }\n' +
                '\n' +
                '\n' +
                '        .page {\n' +
                '            page-break-after: always;\n' +
                '        }\n' +
                '\n' +
                '        @page {\n' +
                '            margin: 20mm\n' +
                '        }\n' +
                '\n' +
                '        @media print {\n' +
                '            thead {\n' +
                '                display: table-header-group;\n' +
                '            }\n' +
                '\n' +
                '            tfoot {\n' +
                '                display: table-footer-group;\n' +
                '            }\n' +
                '\n' +
                '            button {\n' +
                '                display: none;\n' +
                '            }\n' +
                '\n' +
                '            body {\n' +
                '                margin: 0;\n' +
                '            }\n' +
                '        }\n' +
                '    </style>\n' +
                '</head>\n' +
                '\n' +
                '<body>\n' +
                '\n' +
                '<div class="page-header" style="text-align: center">\n' +
                '    <header class="header">\n' +
                '        <div class="logo">\n' +
                '            <img src="' + print_img + '" alt="">\n' +
                '        </div>\n' +
                '        <div class="org">' + print_org + '</div>\n' +
                '        <div class="contact">\n';
            if (print_phone != '') {
                header += '' + '<p>Phone No. <span>' + print_phone + '</span></p>\n' + '';
            }
            if (print_mobile != '') {
                header += '' + '<p>Mobile No. <span>' + print_mobile + '</span></p>\n' + '';
            }
            if (print_whatsapp != '') {
                header += '' + '<p>Whatsapp No. <span>' + print_whatsapp + '</span></p>\n' + '';
            }
            if (print_fax != '') {
                header += '' + '<p>Fax No. <span>' + print_fax + '</span></p>\n' + '';
            }
            header += '        </div>\n' +
                '    </header>\n' +
                '</div>\n' +
                '\n' +
                '<div class="page-footer">\n' +
                '    <footer class="footer">\n' +
                '        <div class="left"></div>\n' +
                '        <div class="center">\n' +
                '            <div class="address">' + print_address + '</div>\n' +
                '            <div class="contact">' + print_email + '</div>\n' +
                '            <div class="copyright">&copy; ' + print_copyright + '</div>\n' +
                '        </div>\n' +
                '        <div class="right">\n' +
                '            <div class="date">\n' +
                '                {{ date('g:ia \o\n l jS F Y') }}\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </footer>\n' +
                '</div>\n' +
                '\n' +
                '<table>\n' +
                '\n' +
                '    <thead>\n' +
                '    <tr>\n' +
                '        <td>\n' +
                '            <!--place holder for the fixed-position header-->\n' +
                '            <div class="page-header-space"></div>\n' +
                '        </td>\n' +
                '    </tr>\n' +
                '    </thead>\n' +
                '\n' +
                '    <tbody>\n' +
                '    <tr>\n' +
                '        <td>\n' +
                '            <!--*** CONTENT GOES HERE ***-->\n' +
                '\n' +
                '            <div class="page">' +
                '';
            var footer = '' +
                '</div>\n' +
                '        </td>\n' +
                '    </tr>\n' +
                '    </tbody>\n' +
                '\n' +
                '    <tfoot>\n' +
                '    <tr>\n' +
                '        <td>\n' +
                '            <!--place holder for the fixed-position footer-->\n' +
                '            <div class="page-footer-space"></div>\n' +
                '        </td>\n' +
                '    </tr>\n' +
                '    </tfoot>\n' +
                '\n' +
                '</table>\n' +
                '\n' +
                '</body>\n' +
                '\n' +
                '</html>' +
                '';

            document.body.innerHTML = header + printContents + footer;

            setTimeout(function() {
                window.print();
                jQuery('.hide_column').show();
            }, 250);
        }else{
            jQuery('.hide_column').hide();

            var htmlToPrint = '' +
                '<style type="text/css">' +
                '   body {' +
                '        background-color: white !important;' +
                '   }' +
                '       #fixTable a {' +
                '           color: black !important;' +
                '       }' +
                '       .table-bordered {\n' +
                '           border: 1px solid #131e22 !important; ' +
                '       }\n' +
                '       \n' +
                '       .table-bordered th,\n' +
                '       .table-bordered td {\n' +
                '           border: 1px solid #131e22 !important; ' +
                '        }' +
                '</style>';

             printContents = document.getElementById('printTable').innerHTML;

            document.body.innerHTML = htmlToPrint + printContents;

            setTimeout(function() {
                window.print();
                jQuery('.hide_column').show();
            }, 250);
        }


        // window.print();
        // var htmlToPrint = header + printContents.innerHTML + footer;
        // newWin = window.open("");
        // newWin.document.write(document.body.innerHTML = header + printContents + footer);
        // // newWin.document.body.innerHTML = htmlToPrint;
        // newWin.print();
        // newWin.close();
        // jQuery('.hide_column').show();
    });
    var url = window.url;
    window.onafterprint = function () {

        var account_ledger = url.toString().split('/').pop().trim();

        if(account_ledger == 'account_ledger'){
            jQuery("#ledger").submit();
        }else{
            window.location.href = url;
        }
    }
</script>


<script>
    $("#excelTable").click(function(){

        jQuery('.hide_column').remove();
        var file_name =$(".file_name").html();

        $("#printTable").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Worksheet Name",
            filename: file_name, //do not include extension
            fileext: ".xls", // file extension
        });

        var account_ledger = url.toString().split('/').pop().trim();

        if(account_ledger == 'account_ledger'){
            jQuery("#ledger").submit();
        }else{
            window.location.href = url;
        }
    });

</script>
<style>
    #parent {
        height: 400px;
    }
</style>