<title>Dengvaxia Form</title>
<style>
    .body{
        font-size:x-small;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    @page {
        margin: 15px;
    }
    .page_break{
        page-break-before: always;
    }
    .page_number:after{
        content: counter(page)
    }
    .table1{
        width: 100%;
    }
    .border{
        border:1px solid #000;
    }
    .box{
        border:1px solid #000;
        width: 15px;
        height: 15px;
    }
    .footer {
        width: 100%;
        text-align: center;
        position: fixed;
        bottom: 10px;
    }
    span{
        font-family : DejaVu Sans;
        font-size: 12pt;
    }
    #fetch_data {
        font-size: 8pt;
        text-transform: capitalize;
        font-weight: bold;
    }
</style>
<div class="body">
    <table class="table1" border="0">
        <tr>
            <td class="align" id="no-border-right no-border-top"><img src="{{ realpath(__DIR__ . '/../../..').'/resources/img/doh.png' }}" width="70"></td>
            <td width="100%" id="no-border-left no-border-right no-border-top">
                <center>
                    <b style="font-size: 14pt">DOH - Center for Health Development VII</b><br>
                    <b style="font-size: 12pt">Epidemiology Bureau</b><br><br><br><br><br>
                    <b style="font-size: 12pt"><i>Dengvaxia Vaccinee Health Profile</i></b>
                </center>
            </td>
            <td class="align" id="no-border-left no-border-top"><img src="{{ realpath(__DIR__ . '/../../..').'/resources/img/f1.jpg' }}" width="70"></td>
        </tr>
    </table><br>
    @include("dengvaxiav2.pdf.pdf_page1")
    {{--@include("dengvaxiav2.pdf.pdf_page2")
    @include("dengvaxiav2.pdf.pdf_page3")
    @include("dengvaxiav2.pdf.pdf_page4")
--}}
</div>
