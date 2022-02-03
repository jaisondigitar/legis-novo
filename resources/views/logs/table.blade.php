<table class="table table-responsive" id="logs-table">
    <thead>
        <th>Usuario</th>
        <th>Tipo</th>
        <th>Namespace</th>
        <th>Quando?</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td><span class="badge badge-primary">{!! $log->user['name'] !!}</span></td>
            <td>
                <span class="badge badge-{!! $log->getColor() !!}">{!! $log->event !!}</span>
            </td>
            <td>{!! $log->auditable_type !!}</td>
            <td>{!! $log->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['logs.destroy', $log->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('logs.show') <button @popper(Visualizar) id="advice_{{$log->id}}" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" onclick="getLog({{$log}})"><i class="glyphicon glyphicon-eye-open"></i></button>@endshield

                    {{--@shield('logs.show')<a href="{!! route('logs.show', [$log->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield--}}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{!! $logs->appends(request()->input())->render()  !!}

<div class="container">
    <!-- Modal -->
    <div class="modal fade " id="myModal" role="dialog">
        <div class="modal-dialog  modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detalhes do Log</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">

                        <!-- Created At Field -->
                        <div class="form-group col-md-6">
                            {!! Form::label('created_at', 'Data:', ['class'=>'text-uppercase']) !!}
                            <p id="log_created_at"></p>
                        </div>

                        <!-- User Id Field -->
                        <div class="form-group col-md-3">
                            {!! Form::label('user_id', 'Usuário:', ['class'=>'text-uppercase']) !!}
                            <p id="log_user"> </p>
                        </div>

                        <!-- User Id Field -->
                        <div class="form-group col-md-6">
                            {!! Form::label('email', 'E-mail:', ['class'=>'text-uppercase']) !!}
                            <p id="log_email"> </p>
                        </div>

                        <!-- Owner Type Field -->
                        <div class="form-group col-md-6">
                            {!! Form::label('auditable_type', 'Tabela:', ['class'=>'text-uppercase']) !!}
                            <p id="log_owner_type"></p>
                        </div>

                        <!-- Owner Id Field -->
                        <div class="form-group col-md-6">
                            {!! Form::label('auditable_id', 'Id do registro:', ['class'=>'text-uppercase']) !!}
                            <p id="log_owner_id"></p>
                        </div>

                        <!-- Type Field -->
                        <div class="form-group col-md-6">
                            {!! Form::label('event', 'Tipo:', ['class'=>'text-uppercase']) !!}
                            <p id="log_type"></p>
                        </div>

                        <!-- Old Value Field -->
                        <div class="form-group col-md-12">
                            {!! Form::label('old_values', 'Valor antigo:',
                            ['class'=>'text-uppercase']) !!}
                            <p id="log_old_value"></p>
                        </div>

                        <!-- New Value Field -->
                        <div class="form-group col-md-12">
                            {!! Form::label('new_values', 'Valor novo:',
                            ['class'=>'text-uppercase']) !!}
                            <p id="log_new_value"></p>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var getLog = function (log) {
        // $('#log_id').html(log.id);
        $('#log_user').html(log.user.name);
        $('#log_email').html(log.user.email);
        $('#log_owner_type').html(log.auditable_type);
        $('#log_owner_id').html(log.auditable_id);
        $('#log_old_value').html(log.old_values);
        $('#log_new_value').html(log.new_values);
        $('#log_type').html(log.event);
        $('#log_created_at').html(log.created_at);
        $('#log_updated_at').html(log.updated_at);
    }
</script>
