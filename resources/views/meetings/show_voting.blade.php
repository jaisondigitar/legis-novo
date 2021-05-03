@extends('layouts.meeting')
@section('content-meeting')
    <h3 class="text-uppercase">
        Votação - {{$voting->getName()}}
    </h3>
    <div class="clearfix"></div>
    <hr>

    <div class="col-lg-12" style="margin-bottom: 20px;">
        <label>
            <input type="radio" class="pull-left" id="contactChoice0" name="assemblyman" value="nenhum" style="margin-right: 5px;" onclick="disable_vote()">
            DESMARCAR PARLAMENTAR
        </label>
    </div>

    <div class="clearfix"></div>
    @foreach($meeting->assemblyman()->orderBy('short_name')->get() as $item)
    <div class="col-sm-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <label>
                    <input type="radio" class="pull-left" id="contactChoice{{$item->id}}" name="assemblyman" value="{{$item->short_name}}" style="margin-right: 5px;" onclick="enable_vote('{{$item->id}}')">
                    {{ mb_strtoupper($item->short_name) }}
                </label>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label style="width: 100%;">
                            SIM
                            <span class="pull-right">
                                <input type="radio" class="pull-left radioBox" id="vote_{{$item->id}}_1" name="{{$item->id}}_vote" value="yes" onclick="votes(this, '{{$item->id}}')" disabled @if($voting->votes()->where('assemblyman_id',$item->id)->where('yes', 1)->first()) checked @endif>
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            NÃO
                            <span class="pull-right">
                                <input type="radio" class="pull-left radioBox" id="vote_{{$item->id}}_2" name="{{$item->id}}_vote" value="no" onclick="votes(this, '{{$item->id}}')" disabled @if($voting->votes()->where('assemblyman_id',$item->id)->where('no', 1)->first()) checked @endif>
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            ABSTENÇÃO
                            <span class="pull-right">
                                <input type="radio" class="pull-left radioBox" id="vote_{{$item->id}}_3" name="{{$item->id}}_vote" value="abstention" onclick="votes(this, '{{$item->id}}')" disabled @if($voting->votes()->where('assemblyman_id',$item->id)->where('abstention', 1)->first()) checked @endif>
                            </span>
                        </label>
                    </li>
                </ul>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-default -->
    </div>
    @endforeach
    <div class="clearfix"></div>
    <hr>
    <a href="/meetings/{{$meeting->id}}/voting/{{$voting->id}}/closeVoting"><button class="btn btn-danger pull-right"> ENCERRAR VOTAÇÃO</button></a>

    <script>
        var enable_vote = function (assemblyman_id) {
            if($('#contactChoice'+assemblyman_id).is(':checked')) {
                for(var i = 1 ; i<=3 ; i++) {
                    $('#vote_' + assemblyman_id + '_'+i).attr('disabled', false);
                }

                url = '{{route('meetings.updateAssemblyman',[$meeting->id, $voting->id])}}';

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
                        toastr.success('Paralamentar '+data.short_name+' em votação!');
                    }else{
                        toastr.error('Falha ao selecionar parlamentar');
                    }
                })
            }
        };

        var disable_vote = function () {
            $('.radioBox').attr('disabled', true);

            url = '{{route('meetings.updateAssemblyman',[$meeting->id, $voting->id])}}';
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
                voting_id      : '{{$voting->id}}',
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
                    toastr.success('Voto efetuado com sucesso!');
                }else{
                    toastr.error('Falha ao registrar voto!');
                }
            })


        }
    </script>
@endsection

