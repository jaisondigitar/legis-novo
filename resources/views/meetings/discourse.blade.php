@extends('layouts.meeting')
@section('content-meeting')


    <div class="col-md-12"> <h1 class="text-uppercase text-center"> púlpito - selecione parlamentar </h1></div>

    <div class="col-lg-12" style="margin-bottom: 20px;">
        <label>
            <input type="radio" class="pull-left radioBox1" id="contactChoice0" name="assemblyman" value="nenhum" style="margin-right: 5px;" onclick="disable_vote()">
            DESMARCAR PARLAMENTAR
        </label>
    </div>

    <div class="clearfix"></div>
    @foreach($meeting->assemblyman()->orderBy('short_name')->get() as $item)
        <div class="col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <label>
                        <input type="radio" class="pull-left radioBox1" id="contactChoice{{$item->id}}" name="assemblyman" value="{{$item->short_name}}" style="margin-right: 5px;" onclick="enable_vote('{{$item->id}}')"
                        @if(Auth::user()->company->assemblyman_id == $item->id) checked @endif>
                        {{ mb_strtoupper($item->short_name) }}
                    </label>
                </div>
            </div><!-- /.panel panel-default -->
        </div>
    @endforeach

    <script>
        var enable_vote = function (assemblyman_id) {
            if($('#contactChoice'+assemblyman_id).is(':checked')) {
                for(var i = 1 ; i<=3 ; i++) {
                    $('#vote_' + assemblyman_id + '_'+i).attr('disabled', false);
                }

                url = '/setAssemblyman';

                data = {
                    assemblyman_id : assemblyman_id,
                    meeting_id: '{{ $meeting->id }}',
                    _token : '{{csrf_token()}}'
                }

                $.ajax({
                    url : url,
                    data : data,
                    method : 'POST'
                }).success(function (data) {
                    data = JSON.parse(data);
                })
            }
        };

        var disable_vote = function () {
            $('.radioBox').attr('disabled', true);

            url = '/setAssemblyman';
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
                console.log(data)
                if(data.assemblyman_id == 0){
                    toastr.success('Nenhum paralamentar selecionado!');
                }else{
                    toastr.error('Falha ao desmarcar parlamentar');
                }
            })
        }

        {{--var votes = function (t, id) {--}}
            {{--url = '{{route('meetings.registerVote')}}';--}}
            {{--data = {--}}
                {{--meeting_id     : '{{$meeting->id}}',--}}
                {{--voting_id      : '{{$voting->id}}',--}}
                {{--assemblyman_id : id,--}}
                {{--votes          : $('#'+t.id).val(),--}}
                {{--_token         : '{{csrf_token()}}'--}}
            {{--}--}}

            {{--$.ajax({--}}
                {{--url    : url,--}}
                {{--data   : data,--}}
                {{--method : 'POST'--}}
            {{--}).success(function (data) {--}}
                {{--data = JSON.parse(data)--}}
                {{--if(data){--}}
                    {{--toastr.success('Voto efetuado com sucesso!');--}}
                {{--}else{--}}
                    {{--toastr.error('Falha ao registrar voto!');--}}
                {{--}--}}
            {{--})--}}
        {{--}--}}

        $(document).ready(function () {
            @if(isset($voting->closed_at))
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

