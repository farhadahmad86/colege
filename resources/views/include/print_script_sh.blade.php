


function prnt_cus(str){
    var slug = JSON.stringify( $(".prnt_lst_frm").serializeArray() ),
        url = base+'?array='+encodeURIComponent( slug )+'&str='+str;

    if( str === 'download_pdf' || str === 'download_excel') {
        download_pdf_excl(url);
    }

    if( str === 'pdf') {
        pdf_preView(url);
    }
}


function download_pdf_excl(url){
    var a = document.createElement('a');
    a.href = url;
    a.download = base.toString().split('/').pop();
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function pdf_preView(url){
    var w = 900,
    h = 400,
    left = (screen.width/2)-(w/2),
    top = (screen.height/2)-(h/2);

    var WinPrint = window.open(url, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    WinPrint.document.close();
    WinPrint.onload = function() {
    WinPrint.focus();
    // WinPrint.print();
    // setTimeout(function () { WinPrint.close(); }, 1500);
    };
}

