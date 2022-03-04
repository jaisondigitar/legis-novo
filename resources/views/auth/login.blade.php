<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>GPL</title>
    <link rel="shortcut icon" href="assets/images/logoLegis.ico" type="image/png"/>

    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/structure.css') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/js/jquery.min.js"></script>

    <style>
        form {
            width: 20rem;
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
            border: 1px transparent;
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
            border: 1px transparent;
            background-color: #fff;
            opacity: 0.9;
            -webkit-transition: background-color 0.2s;
            transition: background-color 0.2s;
        }

        button {
            border-radius: 5px;
            background: #208bd2;
            color: #fff;
            padding: 10px 20px;
            font-size: 15px;
        }

        button:hover,
        button:focus,
        button:active {
            background: #ececec;
            color: #000000;
        }

        #forgot {
            color: white !important;
        }

        #forgot:hover,
        #forgot:focus,
        #forgot:active {
            color: black !important;
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
                border-bottom: 100vh solid rgb(32, 139, 210);
                border-left: 35rem solid transparent;
                margin-left: 15rem;
                width: 100vw;
            }
        }


        @media screen and (max-width: 1100px) {
            .backFormat {
                border-bottom: 100vh solid rgb(32, 139, 210);
                border-left: 45rem solid transparent;
                width: 100vw;
            }
        }

        @media screen and (max-width: 750px) {
            .align {
                position: absolute;
                width: min-content;
                top: 30%;
                left: 25%;
            }

            .logoType {
                position: absolute;
                top: auto;
                left: 25%;
            }

            .backFormat {
                border-bottom: 70vh solid rgb(32, 139, 210);
                border-left: 0 solid transparent;
                /*width: 100vw;*/
            }
        }

        .forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .forgot a {
            font-size: 16px;
        }

        .errorLogin {
            padding-bottom: 3rem;
            font-size: 15px;
            color: black;
        }
    </style>
</head>

<body class="banner">
    <div class="backLogin">
        <div class="logoType">
            <img
                src="/assets/images/gpl.png"
                class="img-responsive"
                style="max-width: 75%; height: 50%;"
                alt="Logo"
            >
        </div>
        <div class="backFormat">
            <div class="align">
                <form action="login" method="post">
                    <div class="errorLogin">
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div id="error"></div>
                            @endforeach
                        @endif
                        @csrf
                    </div>

                    <label>
                        E-mail:
                        <input type="email" name="email" tabindex="1" placeholder="email">
                    </label>


                    <label>
                        Senha:
                        <input type="password" name="password" required placeholder="senha" tabindex="2">
                    </label>

                    <div class="forgot">
                        <button type="submit">ENTRAR</button>

                        <a href="#" tabindex="5" id="forgot">Esqueceu a senha?</a>
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
<script>
    $(document).ready(() => {
        if($('#error').is(":visible")) {
            Swal.fire({
                icon: 'error',
                title: 'E-mail e/ou senha incorretos',
                text: 'Verifique seu e-mail e senha',
            })
        }
    });
</script>
