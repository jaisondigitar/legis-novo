<!DOCTYPE HTML>
<html>
<head>
    <title>MakerLegis</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/structure.css') }}">
    <style>
        body {
            background: url('{{ asset('/assets/images/pixels.jpg')}}') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        #main {
            background-color: rgba(0, 0, 0, 0.6);
            margin-bottom: -10px !important;
            padding: 10px;
            color: white;
        }
        .banner {
            z-index: 5;
        }
        .banner .bg {
            position: absolute;
            z-index: -1;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: url('{{ asset('/assets/images/pixels.jpg')}}') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            filter: blur(2px);
        }
        .button-submit {
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.6);
            color:#fff;
            margin-left:12px;
            float:right;
            padding:7px 21px;
        }
        .button-submit:hover,
        .button-submit:focus,
        .button-submit:active{
            background: rgba(0, 0, 0, 0.4);
        }
        .box.login {
            height: auto;
        }
    </style>
</head>

<body class="banner">
<div class="bg"></div>
<form class="box login banner" action="/auth/login" method="post">
    <div class="logo">
        <img src="/assets/images/genesis-black.png" style="max-width: 250px;" class="img-responsive" alt="Logo">
    </div>
    <fieldset class="boxBody">
        @if($errors->any())
            <ul class="alert alert-danger" style="list-style-type: none">
                @foreach($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        @endif
        {!! Form::token() !!}
        <label>E-mail:</label>
        <input type="text" name="email" tabindex="1" placeholder="email" required>
        <label><a href="#" class="rLink" tabindex="5">Esqueci a senha?</a>Senha:</label>
        <input type="password" name="password" placeholder="senha" tabindex="2" required>
    </fieldset>
    <footer>
        <button type="submit" class="button-submit"> ENTRAR </button>
    </footer>
</form>
<footer id="main">
    <a href="https://www.genesis.tec.br/"
       onMouseOver="this.style.color='blue'"
       onMouseOut="this.style.color='white'"
       style="color: white;">
        Gênesis Tecnologia e Inovação
    </a> | &copy; {{ date("Y") }} Todos os Direitos Reservados
</footer>
</body>
</html>

