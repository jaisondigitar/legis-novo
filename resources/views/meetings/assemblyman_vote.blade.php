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
                    <button
                        type="button"
                        class="btn btn-default pull-left"
                        onclick="javascript:history.go(-1)"
                    >VOLTAR</button>

                    <div class="clearfix"></div>

                    @if ($voting)
                        <h1
                            class="text-uppercase text-center bg-dark py-2 my-3 text-white
                                name_voting
                                text_reset"
                            style="font-size: 27px;"
                        > - </h1>

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
                                <h1 class="text-center" style="display: table-cell; text-align: center; vertical-align: middle; font-size: 40px; width: 100%" > IMPEDIDO </h1>
                            </div><!-- /.the-box .bg-primary .no-border-->
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="the-box btn btn-danger assemblyman_vote" id="no" style="display: table; width: 100%; height: 300px;" onclick="voting(this)">
                                <h1 class="text-center" style="display: table-cell; text-align: center; vertical-align: middle; font-size: 50px;"> NÃO </h1>
                            </div><!-- /.the-box .bg-primary .no-border-->
                        </div>

                        <div class="clearfix"></div>
                        <hr>
                    @else
                        <h1
                            class="text-uppercase text-center bg-dark py-2 my-3 text-white"
                            style="font-size: 27px;"
                        > Não há votação em aberto </h1>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>

        var myInterval ;

        $(document).ready(function () {
            $('.assemblyman_vote').attr('disabled', true);
            $('.assemblyman_vote').css("pointer-events", "none");

            if ("{{ $voting }}") {
                clear_painel();
            }
        });

        var clear_painel = function () {
            clearInterval(myInterval);
            myInterval = setInterval(function () {
                getData("/painel-votacao-parlamentar/{{$id}}/data");
            }, 1000);
        }

        var voting_painel = function () {
            clearInterval(myInterval);
            myInterval = setInterval(function () {
                getData("/painel-votacao-parlamentar/{{$id}}/data");
            }, 5000);
        }

        const getData = async () => {
            if ("{{ $meeting->multi_voting }}") {
                const resp = await fetch(
                    "/painel-votacao-parlamentar/{{$id}}/data",
                    {method: 'GET'}
                ).catch(error => {
                    toastr.success('Erro ao obter os dados da votação')
                    console.error(error.message)
                })

                const data = await resp.json()

                if (data) {
                    setData(data);
                } else {
                    resetPainel();
                    clear_painel();
                }
            } else {
                $.ajax({
                    url: "/painel-votacao-parlamentar/{{$id}}/data",
                    method: "GET"
                }).success(function (response) {
                    response = JSON.parse(response);

                    if (response.status) {
                        setData(response);
                    } else {
                        resetPainel();
                        clear_painel();
                    }
                });
            }
        };

        var setData = function (data)
        {
            if (typeof data.name !== 'string') {
                const nameVoting = document.querySelector('.name_voting')

                nameVoting.innerHTML = ''

                data.name.forEach(item => {
                    console.log(item)
                    const paragraph = document.createElement('p')

                    paragraph.innerText = item

                    nameVoting.append(paragraph)
                })
            } else {
                $('.name_voting').html(data.name);
            }

            $('.session').html(data.meeting.session);
            $('.type').html(data.meeting.type);
            $('#assemblyman_voting').html(data.assemblyman.name);
            var assemblyan = '{{$id}}';

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
                    $('.assemblyman_vote').attr('disabled', false);
                    $('.assemblyman_vote').css("pointer-events", "auto");
                }else{
                    $('.assemblyman_vote').attr('disabled', true);
                    $('.assemblyman_vote').css("pointer-events", "none");
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

        const voting = (element) => {
            $.ajax({
                url : '/voting/assemblyman/computeVoting',
                data : {
                    voting: '{{ $voting->id }}',
                    votes : $(element).attr('id'),
                    assemblyman_id : '{{$id}}',
                    _token : '{{csrf_token()}}'
                },
                method : 'POST'
            }).success(function (data) {
                data = JSON.parse(data);
                if(data){
                    console.log(data)
                    toastr.success('Voto computado com sucesso!');
                    clear_painel();
                } else {
                    toastr.error('Falha ao computar voto!');
                }
            })

        }
    </script>



@endsection

