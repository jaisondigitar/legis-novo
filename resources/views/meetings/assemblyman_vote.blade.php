@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('meetings.show') !!}
@endsection
@section('content')
    <style>
        .menu{
            text-decoration: none; color: #999;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="the-box">
                    <h1 class="text-uppercase text-center bg-dark py-2 my-3 text-white name_voting text_reset" style="font-size: 27px;"> - </h1>
                    <h3 class="session"> SESSÃO - </h3>
                    <small class="type"> TIPO - </small>
                    <h3 id="assemblyman_voting" class="text-uppercase"> PARLAMENTAR - </h3>

                    <hr>

                    <h1 class="text-uppercase text-center"> SELECIONE SEU VOTO </h1>
                    <br>

                    <div class="col-lg-4 col-md-12" >
                        <div class="the-box btn-primary assemblyman_vote" id="yes" style="display: table; width: 100%; height: 300px;" onclick="voting(this)">
                            <h1 class="text-center" style="display: table-cell; text-align: center; vertical-align: middle; font-size: 50px;" > SIM </h1>
                        </div><!-- /.the-box .bg-primary .no-border-->
                    </div>

                    <div class="col-lg-4 col-md-12" >
                        <div class="the-box btn-warning assemblyman_vote" id="abstention" style="display: table; width: 100%; height: 300px;" onclick="voting(this)">
                            <h1 class="text-center" style="display: table-cell; text-align: center; vertical-align: middle; font-size: 40px; width: 100%" > ABSTENÇÃO </h1>
                        </div><!-- /.the-box .bg-primary .no-border-->
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="the-box btn btn-danger assemblyman_vote" id="no" style="display: table; width: 100%; height: 300px;" onclick="voting(this)">
                            <h1 class="text-center" style="display: table-cell; text-align: center; vertical-align: middle; font-size: 50px;"> NÃO </h1>
                        </div><!-- /.the-box .bg-primary .no-border-->
                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    <button type="button" class="btn btn-default pull-right" onclick="javascript:history.go(-1)"> VOLTAR </button>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <script>

        var myInterval ;

        $(document).ready(function () {
            var refresh_time = 1000;

            $('.assemblyman_vote').attr('disabled', true);
            $('.assemblyman_vote').css("pointer-events", "none");


            clear_painel();
        });

        var clear_painel = function () {
            clearInterval(myInterval);
            myInterval = setInterval(function (args) {
                getData("/painel-votacao-parlamentar/{{$id}}/data");
            }, 1000);
        }

        var voting_painel = function () {
            clearInterval(myInterval);
            myInterval = setInterval(function (args) {
                getData("/painel-votacao-parlamentar/{{$id}}/data");
            }, 5000);
        }

        var getData = function(){
            $.ajax({
                url: "/painel-votacao-parlamentar/{{$id}}/data",
                method: "GET"
            }).success(function (response) {
                response = JSON.parse(response);

                if(response.status)
                {
                    setData(response);
                }
                else
                {
                    resetPainel();
                    clear_painel();
                }
            });
        };

        var setData = function (data)
        {
            $('.name_voting').html(data.name);
            $('.session').html(data.meeting.session);
            $('.type').html(data.meeting.type);
            $('#assemblyman_voting').html(data.assemblyman.name);
            var assemblyan = '{{$id}}';
            console.log(data);

            if(assemblyan == data.assemblyman.id){
                $('.assemblyman_vote').attr('disabled', true);
                $('.assemblyman_vote').css("pointer-events", "none");
            }else{
                $('.assemblyman_vote').attr('disabled', false);
                $('.assemblyman_vote').css("pointer-events", "auto");
            }

            if(!data.active){
                $('.assemblyman_vote').attr('disabled', true);
                $('.assemblyman_vote').css("pointer-events", "none");
            }else{
                if(assemblyan == data.assemblyman.id){
                    $('.assemblyman_vote').attr('disabled', true);
                    $('.assemblyman_vote').css("pointer-events", "none");
                }else{
                    $('.assemblyman_vote').attr('disabled', false);
                    $('.assemblyman_vote').css("pointer-events", "auto");
                }
            }

            voting_painel();
        };

        var resetPainel = function ()
        {
            $('.assemblyman_vote').attr('disabled', true);
            $('.assemblyman_vote').css("pointer-events", "none");
            $('.text_reset').html("-");
            $('.session').html('SESSÃO - ');
            $('.type').html('TIPO - ');
            $('#assemblyman_voting').html('PARLAMENTAR  - ');

        };
    </script>

    <script>

        var voting = function(element){

            var url = '/voting/assemblyman/computeVoting';


                data = {
                votes           : $(element).attr('id'),
                assemblyman_id : '{{$id}}',
                _token         : '{{csrf_token()}}'
            }

            $.ajax({
                url : url,
                data : data,
                method : 'POST'
            }).success(function (data) {
                data = JSON.parse(data);
                if(data){
                    toastr.success('Voto computado com sucesso!');
                    clear_painel();
                } else {
                    toastr.error('Falha ao computar voto!');
                }
            })

        }
    </script>



@endsection

