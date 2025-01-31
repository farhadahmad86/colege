<!-- js -->
<script src={{asset("public/vendors/scripts/script.js")}}></script>

{{--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}

{{--<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">--}}
<script src={{asset("public/tableHeadFixer.js")}}></script>

<script src={{asset("public/src/plugins/highcharts-6.0.7/code/highcharts.js")}}></script>
<script src={{asset("public/src/plugins/highcharts-6.0.7/code/highcharts-more.js")}}></script>
<script src={{asset("public/sidebar_js/script.js")}}></script>

@php
    $company_info = Session::get('company_info');
if(isset($company_info) || !empty($company_info)){
$logo=$company_info->ci_logo;
$name=$company_info->ci_name;
$ptcl=$company_info->ci_ptcl_number;
$mobile=$company_info->ci_mobile_numer;
$whatsapp=$company_info->ci_whatsapp_number;
$fax=$company_info->ci_fax_number;
$email=$company_info->ci_email;
$address=$company_info->ci_address;
}else{
$logo='';
$name='';
$ptcl='';
$mobile='';
$whatsapp='';
$fax='';
$email='';
$address='';
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
        var img = '{{$logo}}';
        var org = '{{$name}}';
        var phone = '{{$ptcl}}';
        var mobile = '{{$mobile}}';
        var whatsapp = '{{$whatsapp}}';
        var fax = '{{$fax}}';
        var email = '{{$email}}';
        var address = '{{$address}}';
        var copyright = 'copyright Softagics.com 2019';
        // var printContents = document.getElementById('printTable').innerHTML;
        var printContents = document.getElementById('printTable').innerHTML;
        var header = '' +
            '<!doctype html>\n' +
            '<html lang="en">\n' +
            '<head>\n' +
            '    <meta charset="UTF-8">\n' +
            '    <meta name="viewport"\n' +
            '          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">\n' +
            '    <meta http-equiv="X-UA-Compatible" content="ie=edge">\n' +
            '    <title>Print</title>\n' +
            '\n' +
            '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">\n' +
            '    <style>\n' +
            '        * {\n' +
            '            margin: 0 0 !important;\n' +
            '            padding: 0 0 !important;\n' +
            '        }\n' +
            '\n' +
            '        body {\n' +
            '           background-color: white !important;' +
            '            box-sizing: border-box !important;\n' +
            '        }\n' +
            '\n' +
            '        header {\n' +
            '            height: 100px !important;\n' +
            '        }\n' +
            '        .header {\n' +
            '            position: relative !important;' +
            // '            top: 0 !important;' +
            // '            right: 0 !important;' +
            // '            left: 0 !important;' +
            // '            height: 100px !important;' +
            '            display: flex !important;\n' +
            '            background-color: #EAEAEA !important;\n' +
            '        }\n' +
            '        .logo,\n' +
            '        .org,\n' +
            '        .header .contact {\n' +
            '           color: #242424 !important;' +
            '            flex: 1 !important;\n' +
            '        }\n' +
            '\n' +
            '        .logo img {\n' +
            '            width: 250px !important;\n' +
            '            height: 100% !important;\n' +
            '        }\n' +
            '        .org {\n' +
            '            text-align: center !important;\n' +
            '            font-size: 45px !important;\n' +
            '            font-weight: bold !important;\n' +
            '            padding-top: 15px !important;\n' +
            '        }\n' +
            '        .header .contact {\n' +
            '            text-align: right !important;\n' +
            '        }\n' +
            '        .header .contact p {\n' +
            '            display: block !important;\n' +
            '            padding: 8px 15px 3px 0 !important;\n' +
            '            line-height: 10px !important;\n' +
            '        }\n' +
            '        .header .contact span {\n' +
            '            font-size: 18px !important;\n' +
            '            font-weight: bold !important;\n' +
            '            padding: 0 18px 3px 0 !important;\n' +
            '        }\n' +
            '        /* content */\n' +
            '        .content {\n' +
            '            margin: 20px !important;\n' +
            '            background-color: white !important;\n' +
            // '           max-height: 200px !important; ' +
            // '           height: 200px !important; ' +
            // '           margin-top: 120px !important; ' +
            '        }\n' +
            '       .content .hide_column {\n' +
            '           display: none !important;\n' +
            '       }\n' +
            '       .content td {\n' +
            '           padding-left: 5px !important;\n' +
            '           padding-right: 5px !important;\n' +
            '       }\n' +
            '       .table-bordered {\n' +
            '           border: 2px solid #131e22 !important; ' +
            '       }\n' +
            '       \n' +
            '       .table-bordered th,\n' +
            '       .table-bordered td {\n' +
            '           border: 2px solid #131e22 !important; ' +
            '        }' +
            '\n' +
            'footer {\n' +
            '            position: relative !important;\n' +
            // '            bottom: 0 !important;\n' +
            // '            right: 0 !important;\n' +
            // '            left: 0 !important;\n' +
            '            height: 100px !important;\n' +
            '        }\n' +
            '        .footer {\n' +
            '            display: flex !important;\n' +
            '            padding: 5px !important;\n' +
            '            background-color: #EAEAEA !important;\n' +
            '        }\n' +
            '        .left,\n' +
            '        .center,\n' +
            '        .right {\n' +
            '            flex: 1;\n' +
            '        }\n' +
            '\n' +
            '        .center {\n' +
            '            text-align: center !important;\n' +
            '        }\n' +
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
            '        .footer .date {\n' +
            '            position: absolute !important;\n' +
            '            bottom: 10px !important;\n' +
            '            right: 15px !important;\n' +
            '            font-size: 18px !important;\n' +
            '            font-weight: bold !important;\n' +
            '        }' +
            'table { page-break-inside:auto !important }\n' +
            '   tr    { page-break-inside:avoid !important; page-break-after:auto !important }' +
            '@media print {\n' +
            '  pre, blockquote {page-break-inside: avoid !important;}\n' +
            '}' +
            '    </style>\n' +
            '\n' +
            '</head>\n' +
            '<body>\n' +
            '\n' +
            '    <div class="app">\n' +
            '        <header class="header">\n' +
            '            <div class="logo">\n' +
            '                <img src="' + img + '" alt="">\n' +
            '            </div>\n' +
            '            <div class="org">' + org + '</div>\n' +
            '            <div class="contact">\n' + '';
        if (phone != '') {
            header += '' + '<p>Phone No. <span>' + phone + '</span></p>\n' + '';
        }
        if (mobile != '') {
            header += '' + '<p>Mobile No. <span>' + mobile + '</span></p>\n' + '';
        }
        if (whatsapp != '') {
            header += '' + '<p>Whatsapp No. <span>' + whatsapp + '</span></p>\n' + '';
        }
        if (fax != '') {
            header += '' + '<p>Fax No. <span>' + fax + '</span></p>\n' + '';
        }
        header += '' +
            '            </div>\n' +
            '        </header>\n' +
            '\n' +
            '        <div class="content">' +
            '';
        var footer = '' +
            '</div>\n' +
            '\n' +
            '        <footer class="footer">\n' +
            '            <div class="left"></div>\n' +
            '            <div class="center">\n' +
            '                <div class="address">' + address + '</div>\n' +
            '                <div class="contact">' + email + '</div>\n' +
            '                <div class="copyright">&copy; ' + copyright + '</div>\n' +
            '            </div>\n' +
            '            <div class="right">\n' +
            '                <div class="date">\n' +
            '                    {{ now() }}\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </footer>\n' +
            '    </div>\n' +
            '\n' +
            '</body>\n' +
            '</html>' +
            '';
        document.body.innerHTML = header + printContents + footer;
        window.print();
        // var htmlToPrint = header + printContents.innerHTML + footer;
        // newWin = window.open("");
        // newWin.document.write(document.body.innerHTML = header + printContents + footer);
        // // newWin.document.body.innerHTML = htmlToPrint;
        // newWin.print();
        // newWin.close();
        jQuery('.hide_column').show();
    });
    var url = window.url;
    window.onafterprint = function () {
        if(url == 'http://www.jadeedbazar.com/financials_laravel/account_ledger'){
            jQuery("#ledger").submit();
        }else{
            window.location.href = url;
        }
    }
</script>
<style>
    #parent {
        height: 400px;
    }
</style>