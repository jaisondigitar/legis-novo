<?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/front/assets/img/favicon.ico">

    <title>MakerLegis - Consulta</title>

    <!-- Bootstrap core CSS -->
    <link href="/front/assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/front/assets/css/ionicons.min.css" rel="stylesheet">
    <link href="/front/assets/css/style.css" rel="stylesheet">


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/front/assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="/front/assets/js/jquery.min.js"></script>
</head>

<body>

@yield('content')



<div id="f">
    <div class="container">
        <div class="row centered">
            <h2>{{ \App\Models\Company::first()->shortName }}</h2>
            <h5>{{ \App\Models\Company::first()->phone1 }} | {{ \App\Models\Company::first()->email }}</h5>
            <h6 class="mt">© {{ date('Y') }} MakerLegis - Software mantido por <a href="http://www.digitar.info" target="_blank">Digitar Informática</a> </h6>
        </div><!--/row-->
    </div><!--/container-->
</div><!--/F-->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="/front/assets/js/bootstrap.min.js"></script>
<script src="/front/assets/js/retina-1.1.0.js"></script>


</body>
</html>
