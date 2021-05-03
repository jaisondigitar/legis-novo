
@extends('panelVoting.panel')
@section('content')
    <style>
        .externa {
            position: absolute;
            width: 100%;
            height: 100%;
            background: #000;
        }

        .interna {
            position: relative;
            padding: 5px;
            top: 50%;
            left: 25%;
            width: 50%;
            text-align: center;
            -webkit-transform: translateY( -50% );
            -moz-transform: translateY( -50% );
            transform: translateY( -50% );
        }
    </style>

    <div class="externa">
        <div class="interna">
            <img src="/uploads/company/{{Auth::user()->company->image}}" width="60%" alt="" class="img-responsive thumbnail">
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            setInterval(function () {
                $.ajax({
                    url: '/get-stage-panel',
                    method: 'GET',
                    async : false
                }).success(function (data) {
                    data = JSON.parse(data);

                    if(data.stage != 'default'){
                        @if(!\App\Models\Parameters::where('slug', 'painel-digital-permitir-multi-sessoes')->first()->value)
                            window.location.href = '/painel-votacao/' + data.stage;
                        @endif
                    }
                });
            }, 1000);
        })
    </script>
@endsection

