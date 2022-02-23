@extends('layouts.meeting')
@section('content-meeting')
    @if($multi_docs_schedule->closet_at)
        <div class="alert alert-danger alert-block fade in alert-dismissable ">
            <strong> <h3 class="text-center">VOTAÇÃO ENCERRADA</h3></strong>
        </div>
        <hr>
    @endif
    <h3 class="text-uppercase">
        Votação:
    </h3>
        @foreach ($files as $file)
            <p>{{ $file->model->label }}</p>
        @endforeach
    <div class="clearfix"></div>
    <hr>
    <div class="col-lg-12" style="margin-bottom: 20px;">
        <label for="active">
            <input
                name="active"
                id="active"
                class="switch"
                data-on-text="Sim"
                data-off-text="Não"
                data-off-color="danger"
                data-on-color="success"
                data-size="normal"
                type="checkbox"
                onchange="enableVotes()"
            >
        </label>
        <span style="text-transform: uppercase; margin-left: 5px">Iniciar votação</span>
    </div>

    <div class="clearfix"></div>
    @foreach($meeting->assemblyman()->orderBy('short_name')->get() as $item)
    <div class="col-sm-3">
        <div class="panel panel-info">
            <div
                class="panel-heading"
                style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 70px;
                "
            >
                <label>
                    {{ mb_strtoupper($item->short_name) }}
                </label>
            </div>
            <div class="panel-body" >
                <ul class="list-group">
                    <li class="list-group-item">
                        <label style="width: 100%;">
                            SIM
                            <span class="pull-right">
                                <input
                                    type="radio"
                                    class="pull-left radioBox"
                                    id="vote_{{$item->id}}_1"
                                    name="{{$item->id}}_vote"
                                    value="yes"
                                    onclick="votes(this, '{{$item->id}}')"
                                    disabled
                                    {{--@if($meeting->voting()
                                            ->get()
                                            ->where('id', $voting->id)
                                            ->first()
                                            ->votes()
                                            ->where('voting_id', $voting->id)
                                            ->where('assemblyman_id', $item->id)
                                            ->where('yes', 1)
                                            ->first()
                                    )
                                        checked
                                    @endif--}}
                                >
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            NÃO
                            <span class="pull-right">
                                <input
                                    type="radio"
                                    class="pull-left radioBox"
                                    id="vote_{{$item->id}}_2"
                                    name="{{$item->id}}_vote"
                                    value="no"
                                    onclick="votes(this, '{{$item->id}}')"
                                    disabled
                                    {{--@if ($meeting->voting()
                                            ->get()
                                            ->where('id', $voting->id)
                                            ->first()
                                            ->votes()
                                            ->where('voting_id', $voting->id)
                                            ->where('assemblyman_id',$item->id)
                                            ->where('no', 1)
                                            ->first()
                                    )
                                        checked
                                    @endif--}}
                                >
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            IMPEDIDO
                            <span class="pull-right">
                                <input
                                    type="radio"
                                    class="pull-left radioBox"
                                    id="vote_{{$item->id}}_3"
                                    name="{{$item->id}}_vote"
                                    value="abstention"
                                    onclick="votes(this, '{{$item->id}}')"
                                    disabled
                                    {{--@if($meeting->voting()
                                            ->get()
                                            ->where('id', $voting->id)
                                            ->first()
                                            ->votes()
                                            ->where('voting_id', $voting->id)
                                            ->where('assemblyman_id',$item->id)
                                            ->where('abstention', 1)
                                            ->first()
                                    )
                                        checked
                                    @endif--}}
                                >
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            AUSENTE
                            <span class="pull-right">
                                <input
                                    type="radio"
                                    class="pull-left radioBox"
                                    id="vote_{{$item->id}}_4"
                                    name="{{$item->id}}_vote"
                                    value="out"
                                    onclick="votes(this, '{{$item->id}}')"
                                    disabled
                                    {{--@if($meeting->voting()
                                            ->get()
                                            ->where('id', $voting->id)
                                            ->first()
                                            ->votes()
                                            ->where('voting_id', $voting->id)
                                            ->where('assemblyman_id',$item->id)
                                            ->where('out', 1)
                                            ->first()
                                    )
                                        checked
                                    @endif--}}
                                >
                            </span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
    <div class="clearfix"></div>
    <hr>
    <div class="col-lg-12">
    @if(! $multi_docs_schedule->closet_at)
        <div class="col-lg-4 pull-right">
            <a href="{{--/meetings/{{$meeting->id}}/voting/{{$voting->id}}/closeVoting--}}" onclick="return confirm('Deseja encerrar votação?')"><button class="btn btn-danger pull-right"> ENCERRAR VOTAÇÃO</button></a>
        </div>
    @endif
    <div class="col-lg-4 pull-right">
        @if($multi_docs_schedule->closet_at)
            <a href="{{--/meetings/{{$meeting->id}}/voting/{{$voting->id}}/cancelVoting--}}" style="margin-right: 15px;" onclick="return confirm('Deseja cancelar votação?')"><button class="btn btn-warning pull-right"> CANCELAR VOTAÇÃO</button></a>
        @endif
    </div>
    </div>

    <script>
        var enable_vote = function (assemblyman_id) {
            if($('#contactChoice'+assemblyman_id).is(':checked')) {
                for(var i = 1 ; i<=4 ; i++) {
                    $('#vote_' + assemblyman_id + '_'+i).attr('disabled', false);
                }

                url = '{{--{{route('meetings.updateAssemblyman',[$meeting->id, $voting->id])}}--}}';

                data = {
                    assemblyman_id : assemblyman_id,
                    _token : '{{csrf_token()}}'
                }

                $.ajax({
                    url : url,
                    data : data,
                    method : 'POST'
                }).success(function (data) {
                    data = JSON.parse(data);
                    if(data){
                        // toastr.success('Paralamentar '+data.short_name+' em votação!');
                    }else{
                        toastr.error('Falha ao selecionar parlamentar');
                    }
                })
            }
        };

        var disable_vote = function () {
            $('.radioBox').attr('disabled', true);

            url = '{{--{{route('meetings.updateAssemblyman',[$meeting->id, $voting->id])}}--}}';
            data = {
                assemblyman_id : null,
                _token : '{{csrf_token()}}'
            }

            $.ajax({
                url : url,
                data : data,
                method : 'POST'
            }).success(function (data) {
                data = JSON.parse(data);
                console.log(data);
                if(data == null){
                    toastr.success('Nenhum paralamentar selecionado!');
                }else{
                    toastr.error('Falha ao desmarcar parlamentar');
                }
            })
        }

        var votes = function (t, id) {
            url = '{{route('meetings.registerVote')}}';
            data = {
                meeting_id     : '{{$meeting->id}}',
                {{--voting_id      : '{{$voting->id}}',--}}
                assemblyman_id : id,
                votes          : $('#'+t.id).val(),
                _token         : '{{csrf_token()}}'
            }

            $.ajax({
                url    : url,
                data   : data,
                method : 'POST'
            }).success(function (data) {
                data = JSON.parse(data)
                if(data){
                    // toastr.success('Voto efetuado com sucesso!');
                }else{
                    toastr.error('Falha ao registrar voto!');
                }
            })
        }

        $(document).ready(function () {
            @if("{{ $multi_docs_schedule->closet_at }}")
                $(".radioBox").attr('disabled', true);
                $(".radioBox1").attr('disabled', true);
            @endif

            setInterval(function (args)
            {

                $.ajax({
                    url : '/voting/getVotes',
                    method : 'GET'
                }).success(function (response) {
                    response = JSON.parse(response);

                    if(response)
                    {
                        $.each(response, function (key, value) {
                            if (value.yes == 1)
                                $('#vote_' + value.assemblyman_id + '_1').attr('checked', true);

                            if (value.no == 1)
                                $('#vote_' + value.assemblyman_id + '_2').attr('checked', true);

                            if (value.abstention == 1)
                                $('#vote_' + value.assemblyman_id + '_3').attr('checked', true);
                            console.log(value);
                        })
                    }
                })

            }, 1000);
        })
    </script>
@endsection

