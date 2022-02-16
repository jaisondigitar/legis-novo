@extends('panelVoting.panel')
@section('content')
<div class="container-fluid">
    <div class="py-2">
        <div class="row ">
            <div class="col-md-12">
                <h1 class="text-center bg-dark text-uppercase py-3 text-white " id="resume_voting"></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="info"> </div>
            <div class="col-md-12">
                <div class="row" style="padding-left: 0px; padding-right: 0px;">
                    <div class="col-md-6">
                        <div id="graf" class="bg-white p-3">
                            <canvas id="myChart" class=""></canvas>
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <ul id="list" class="list-group"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="/assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>

    var timeResume = null;

    $(document).ready(function () {
        setInterval(function () {
            $.ajax({
                url: '/get-stage-panel',
                method: 'GET',
                async : false
            }).success(function (data) {
                data = JSON.parse(data);

                @if(\App\Models\Parameters::where('slug', 'painel-digital-permitir-multi-sessoes')->first()->value)
                    getResume()
                @else
                if(data.stage != 'resume'){
                    window.location.href = '/painel-votacao/' + data.stage;
                }else{
                    getResume()
                }
                @endif
            });
        }, 3000);
    })

    var getResume = function () {
        url = '/generate-charts';

        // $('#info').empty();
        var yes = no = abstention = 0;
        $.ajax({
            url : '/generate-charts',
            method : 'GET'
        }).success(function (response) {
            response = JSON.parse(response);

            if(!response){
                $('#info').empty();
                $('#info').append('<h1 class=" text-center bg-warning text-uppercase py-3 text-white "> votacão em andamento </h1>');
                $('#list').empty();
                $('#resume_voting').text('-');

                $('#myChart').remove();
                $('#graf').append('<canvas id="myChart" class=""></canvas>')
                chart(0, 0, 0);

            }else {
                $('#info').empty();
                $('#resume_voting').text('RESUMO DA VOTAÇÃO - ' + response[0]);

                var str='';
                $.each(response, function (index, value) {
                    if(index > 0) {
                        yes = yes + value.yes;
                        no = no + value.no;
                        abstention = abstention + value.abstention;

                        str += '<li class="list-group-item text-uppercase">' + value.assemblyman.short_name;
                        if (value.yes) {
                            vote = 'SIM';
                            str += ' <span style="float: right;" class="text-success">' + vote + '</span></li>';
                        }

                        if (value.no) {
                            vote = 'NÃO';
                            str += ' <span style="float: right;" class="text-danger">' + vote + '</span></li>';
                        }

                        if (value.abstention) {
                            vote = 'ABSTENÇÃO'
                            str += ' <span style="float: right;" class="text-muted">' + vote + '</span></li>';
                        }

                        if (value.out) {
                            vote = 'AUSENTE'
                            str += ' <span style="float: right;" class="text-muted">' + vote + '</span></li>';
                        }
                    }
                });
                chart(yes, no, abstention);
                $('#list').empty();
                $('#list').append(str);
            }
        })
    }

    var chart = function (yes, no, abstention) {
        var ctx = document.getElementById('myChart');

        var data = {
            labels : ["SIM", "NÃO", "ABSTENÇÃO"],
            datasets : [
                {
                    label : "Votos",
                    data : [yes, no, abstention],
                    backgroundColor : [
                        'green', 'red', 'gray'
                    ],
                    borderColor : [
                        "#111",
                        "#111",
                        "#111"
                    ],
                    borderWidth : 1
                }
            ]
        };


        if(yes == 0 && no == 0 && abstention == 0) {
            voting = 'VOTAÇÃO'
        }else if(yes > no){
            voting = 'VOTAÇÃO APROVADA'
        } else {
            voting = 'VOTAÇÃO REPROVADA'
        }

        var options = {
            animation: false,
            title : {
                display : true,
                position : "top",
                text : voting,
                fontSize : 20,
                fontColor : "#111"
            },
            legend : {
                display : false
            },
            scales : {
                yAxes : [{
                    ticks : {
                        min : 0
                    }
                }]
            }
        };

        new Chart( ctx, {
            type : "bar",
            data : data,
            options : options
        });
    }

</script>
