<style>
    body {
        background: rgb(204,204,204);
    }
    .img{
      padding-top: 30px;
    }
    page {
        padding: 20px;
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
    page[size="A4"] {
        width: 21cm;
        height: 29.7cm;
    }
    @media print {
        body, page {
            margin: 0;
            box-shadow: 0;
        }
    }
    .footer {
        font-family: 'Ubuntu', sans-serif;
        font-size: 12px;
        position: absolute;
        bottom: 100px;
        height: 75px;
        width: 20cm;
        text-align: right;
    }

    /*** *****************************************
     *** CSS FEITO PELO LUCAS FUCKER MAN! ********
     ***************************************** ***/

    .header { color: black;position: relative;font-family: 'Ubuntu', sans-serif; width: 100%; height: 100px; }
    .header .brasao img { position: relative;float: left;height: 90px;width: auto;}
    .header .text {position: relative;}
    .header .text .title {font-size:22px;}

    .header-sub {color: black;position: relative;font-family: 'Ubuntu', sans-serif;width: 100%; margin: 10px;}
    .header-sub h3 {margin:10px;text-transform: uppercase;font-weight: bold;}
    .header-sub .documento-tipo {margin: 10px;}
    .header-sub .documento-origem {margin: 10px;}
    .header-sub .documento-numero {margin: 10px;}

    .content { color: black; margin: 20px}

</style>

<page size="A4">
    <div style="padding: 5px;">
            @include('documents.show_fields_header')
            <hr class="hr">
            @include('documents.show_fields_subheader')
            @include('documents.show_fields_content')

        <section class="footer">
            @include('documents.show_fields_footer')
        </section>
    </div>
</page>



