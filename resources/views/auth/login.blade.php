<!DOCTYPE HTML>
<html>
<head>
    <title>MakerLegis</title>
    <link rel="shortcut icon" href="assets/images/genesis.ico" type="image/png"/>

    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"/>
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

        form {
            width: 23rem;
        }

        label {
            color: white;
            font-size: 25px;
        }

        input {
            margin-top: 10px;
            margin-bottom: 3rem;
            width: 100%;
            font-size: 16px;
            border-radius: 10px;
            line-height: 20px;
            padding: 10px;
            border: 1px solid #b9b9af;
            background-color: #fff;
            opacity: 0.9;
            -webkit-transition: background-color 0.2s;
            transition: background-color 0.2s;
        }

        input:invalid {
            margin-top: 10px;
            margin-bottom: 3rem;
            width: 100%;
            font-size: 16px;
            border-radius: 10px;
            line-height: 20px;
            padding: 10px;
            border: 1px solid #b9b9af;
            background-color: #fff;
            opacity: 0.9;
            -webkit-transition: background-color 0.2s;
            transition: background-color 0.2s;
        }

        button {
            border-radius: 5px;
            background: rgb(47, 47, 47);
            color: #fff;
            padding: 10px 20px;
            font-size: 15px;
        }

        button:hover,
        button:focus,
        button:active {
            background:#1abc9c;
            color: #000000;
        }

        .align {
            position: absolute;
            width: min-content;
            top: 33%;
            left: 60%;
        }

        #main {
            background-color: rgba(47, 47, 47, 1);
            margin-bottom: -10px !important;
            padding: 10px;
            color: white;
        }

        .banner {
            z-index: 5;
        }

        .backLogin {
            width: 100vw;
            height: 100vh;
            display: flex;
        }

        .banner .backLogin {
            z-index: -1;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: url('/bck.png') no-repeat fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .logoType {
            position: absolute;
            top: 5%;
            left: 5%;
        }

        @media screen and (min-width: 1100px) {
            .backFormat {
                border-bottom: 100vh solid #2f2f2f;
                border-left: 35rem solid transparent;
                margin-left: 15rem;
                width: 100vw;
            }
        }


        @media screen and (max-width: 1100px) {
            .backFormat {
                border-bottom: 100vh solid #2f2f2f;
                border-left: 45rem solid transparent;
                width: 100vw;
            }
        }

        .forgot {
            display: flex;
            justify-content: space-between;
        }

        .forgot a {
            font-size: 16px;
        }
    </style>
</head>

<body class="banner">
<div class="backLogin">
    <div class="logoType">
        <img
            src="/assets/images/genesis-black.png"
            class="img-responsive"
            alt="Logo"
        >
    </div>
    <div class="backFormat">
        <div class="align">
            <form action="login" method="post">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                @endif
                @csrf

                <label>
                    E-mail
                    <input type="text" name="email" tabindex="1" placeholder="email" required>
                </label>

                <label>
                    Senha
                    <input type="password" name="password" placeholder="senha" tabindex="2" required>
                </label>

                <div class="forgot">
                    <button type="submit"> ENTRAR</button>

                    <a href="#" tabindex="5">Esqueci a senha?</a>
                </div>
            </form>
        </div>
    </div>
</div>

<footer id="main">
    &copy; {{Date('Y')}}
    <a href="https://www.genesis.tec.br/"
       onMouseOver="this.style.color='#1abc9c'"
       onMouseOut="this.style.color='white'"
       style="color: white;"
    >
        Gênesis Tecnologia e Inovação
    </a>. Todos os Direitos Reservados
</footer>
</body>
</html>

