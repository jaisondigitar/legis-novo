<?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="assets/images/genesis.ico" type="image/png"/>

    <!-- Bootstrap core CSS -->
    <link href="/front/assets/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/front/assets/css/ionicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"/>

    <style>
        @import url(http://fonts.googleapis.com/css?family=Lato:300,400,700,900);

        .header {
            padding: 20px;
            margin-bottom: 10px;
            text-align: end;
            background: #2F2F2F;
        }

        .login {
            margin-right: 10px;
        }

        body {
            /*background: url('/bck.png') no-repeat fixed;*/
            background-size: 100% 100%;
            position: relative;
            min-height: 100vh;
        }

        .wrapper {
            height: 100%;
            padding-bottom: 15rem;
        }

        footer {
            position: absolute;
            height: 9rem;
            bottom: 0;
            width: 100%;
            margin-top: 50px;
            border-top: 0;
            background: #2f2f2f;
            color: white;
            text-align: center;
        }

        .nav-tabs.centered > li, .nav-pills.centered > li {
            float:none;
            display:inline-block;
            *display:inline; /* ie7 fix */
            zoom:1; /* hasLayout ie7 trigger */
        }

        .nav-tabs.centered, .nav-pills.centered {
            text-align:center;
        }

        * {
            margin: 0;
            padding: 0;
            font-family: 'Lato', sans-serif;
        }

        h2, h3, h4, h5, h6 {
            font-family: 'Lato', sans-serif;
            font-weight: 300;
        }

        h1 {
            font-family: 'Lato', sans-serif;
            font-weight: 600;
            color: #286090;
        }


        p {
            padding: 0;
            margin-bottom: 12px;
            font-family: 'Lato', sans-serif;
            font-weight: 300;
            font-size: 16px;
            line-height: 26px;
            letter-spacing: 1px;
            color: #666;
            margin-top: 10px;
        }

        .centered {text-align: center}

        *,
        *:after,
        *:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        a {
            padding: 0;
            margin: 0;
            text-decoration: none;
            color: #bbb7b7;
        }
        .menu {
            font-weight: 600;
            color: #424242;
        }
        a:hover,
        a:focus {
            text-decoration: none;
            color:#1abc9c;
        }


        /* FORM CONFIGURATION */

        input {
            font-size: 16px;
            min-height: 40px;
            border-radius: 25px;
            line-height: 20px;
            padding: 15px 30px 16px;
            border: 1px solid #b9b9af;
            margin-bottom: 10px;
            background-color: #fff;
            opacity: 0.9;
            -webkit-transition: background-color 0.2s;
            transition: background-color 0.2s;
        }

        ul {
            list-style-type: none;
        }
    </style>
</head>
<body>
@yield('content')

<footer>
    <div class="container">
        <div class="row centered">
{{--            <h2>Gênesis</h2>--}}
            <h5 style="margin: 20px 0">
                <a href="tel: 3423-0055">(67) 3423-0055</a> |
                <a href="tel: 99978-1420">(67) 99978-1420</a> |
                <a href="mailto: comercial@genesis.tec.br">comercial@genesis.tec.br</a>
            </h5>
            <h6 class="mt">© {{ date('Y') }} GPL - Software mantido por
                <a href="https://www.genesis.tec.br/" target="_blank">
                    Gênesis Tecnologia e Inovação
                </a>
            </h6>
        </div><!--/row-->
    </div><!--/container-->
</footer><!--/F-->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="/front/assets/js/bootstrap.min.js"></script>
<script src="/front/assets/js/retina-1.1.0.js"></script>
<script src="/front/assets/js/ie10-viewport-bug-workaround.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

<script src="/jquery.highlight-5.js"></script>
<script src="/front/assets/js/jquery.min.js"></script>
<script src="/front/assets/js/bootstrap.min.js"></script>
<script src="/front/assets/js/retina-1.1.0.js"></script>
</body>
</html>
