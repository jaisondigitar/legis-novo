<!DOCTYPE HTML>
<html>
<head>
    <title>MakerLegis</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/structure.css') }}">
    <style>
        body {
            background: url('{{ asset('/assets/img/bg2.jpg')}}') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .box.login {
            height: 345px;
        }
        </style
</head>

<body>
<form class="box login" action="/auth/login" method="post">
    <div class="logo"><img src="/assets/images/maker_legis2.png" style="max-width: 300px" class="img-responsive" alt="Logo"></div>
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

        <input type="submit" class="btnLogin" value="ENTRAR" tabindex="4">
    </footer>
</form>
<footer id="main">
    <a href="http://wwww.blitsoft.com.br">Blit Softwares</a> | &copy; {{ date("Y") }} Todos os Direitos Reservados
</footer>
</body>
</html>

