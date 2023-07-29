$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    $('#printOrderBtn').click(function(){
        var prtContent = document.getElementById("printOrder");
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        WinPrint.document.write('<link rel="stylesheet" type="text/css" href="'+base_url+'assets/bootstrap/dist/css/bootstrap.min.css">');
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    });

});