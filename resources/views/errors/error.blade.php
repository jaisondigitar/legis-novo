<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Page Not Found</title>

    <!-- Styles -->
    <style>

        *,
        *::before,
        *::after {
            border-width: 0;
            border-style: solid;
            border-color: #dae1e7;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-family: Nunito, sans-serif;
        }

        button {
            background-color: transparent;
            color: #3d4852;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: .75rem 1.5rem;
            border-width: 2px;
            border-color: #dae1e7;
            border-radius: .5rem;
        }

        button:hover {
            border-color: #b8c2cc;
        }

        button,
        [role=button] {
            cursor: pointer;
        }


        .flex {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .code {
            font-size: 9rem;
            color: #013B84;
            font-weight: 900;
        }

        .margin {
            max-width: 30rem;
            margin: 2rem;
        }

        .min-h-screen {
            min-height: 90vh;
            text-align: center;
        }

        .message {
            color: #606f7b;
            font-weight: 300;
            margin-bottom: 2rem;
            line-height: 1.5;
            font-size: 1.875rem;
        }

        .body-image {
            margin-left: 10rem;
        }

        .image {
            position: absolute;
            background-repeat: no-repeat;
            background-size: cover;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 12rem;
            margin: auto auto auto 20rem;
        }

        .text {
            background-color: #fff;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .font-weight {
            font-weight: 700;
        }

    </style>
</head>
<body>
    <div class="flex min-h-screen">
        @yield('image')

        <div class="text">
            <div class="margin">
                <div class="code">
                    @yield('code')
                </div>

                <p class="message font-weight">
                    @yield('name')
                </p>

                <p class="message">
                    @yield('message')
                </p>

                <a href="{{ app('router')->has('home') ? route('home') : url('/') }}">
                    <button>
                        {{ __('Voltar') }}
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
