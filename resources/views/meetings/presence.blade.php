@extends('layouts.meeting')
@section('content-meeting')
    <div class="">
        <h2>LISTA DE PRESENÇA</h2>
        <div class="the-box rounded">
            <div class="col-md-6">
                <p><i class="fa fa-check-circle"></i> {!! $meeting->session_type->name !!}</p>
                <p><i class="fa fa-check-circle"></i> Sessão Nº: {!! $meeting->number !!}</p>
                <p><i class="fa fa-check-circle"></i> Data: {!! $meeting->date_start !!}</p>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4>VEREADORES</h4>
                </div>
                <div class="col-md-6">
                    <span class="pull-right">
                    <input type="checkbox" id="check_all" onclick="selectAll();"> SELECIONAR TODOS
                    </span>
                </div>

            </div>


            <form action="/meetings/presences/save" method="post">
                {!! Form::token() !!}
                <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                <div class="col-md-12">
                    @foreach($assemblyman as $item)
                        <div class="col-sm-4">
                            <div class="panel panel-default panel-block-color">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <input type="checkbox" class="all" name="assemblymen_id[]" value="{{$item->id}}" @if($item->meeting()->where('meeting_id', $meeting->id)->first()) checked @endif style="margin-right:5px; ">
                                        <strong>{{mb_strtoupper($item->short_name)}}</strong>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                        {{$item->responsibility_assemblyman->last()->responsibility->name}}
                                </div><!-- /.panel-body -->
                            </div><!-- /.panel panel-default panel-block-color -->
                        </div>
                    @endforeach
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="col-md-12 " >
                    <button type="submit" class="btn btn-success pull-right"> Salvar</button>
                </div>
            </form>
            <div class="clearfix"></div>
        </div>

    </div>
    <script>
        var selectAll = function () {
            if(!$('#check_all').is(":checked")){
                $('.all').prop('checked',false);
            }else{
                $('.all').prop('checked',true);

            }
        }
    </script>
@endsection
