<table class="table table-striped table-hover" id="logs-table">
    <thead>
        <th>Usuario</th>
        <th>Tipo</th>
        <th>Diretório</th>
        <th>Data</th>
        <th colspan="3">Ações</th>
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
                    @shield('logs.show') <button @popper(Visualizar) id="advice_{{$log->id}}" type="button" class="btn btn-default btn-sm" data-bs-toggle="modal" data-bs-target="#myModal" onclick="getLog({{$log}})"><i class="fa fa-eye"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
{!! $logs->appends(request()->input())->render()  !!}
    <div class="container">
        <div id="myModal" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detalhes do Log</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group col-md-6">
                                {!! Form::label('created_at', 'Data:', ['class'=>'text-uppercase']) !!}
                                <p id="log_created_at"></p>
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('user_id', 'Usuário:', ['class'=>'text-uppercase']) !!}
                                <p id="log_user"> </p>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('email', 'E-mail:', ['class'=>'text-uppercase']) !!}
                                <p id="log_email"> </p>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('auditable_type', 'Tabela:', ['class'=>'text-uppercase']) !!}
                                <p id="log_owner_type"></p>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('auditable_id', 'Id do registro:', ['class'=>'text-uppercase']) !!}
                                <p id="log_owner_id"></p>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('event', 'Tipo:', ['class'=>'text-uppercase']) !!}
                                <p id="log_type"></p>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('old_values', 'Valor antigo:',
                                ['class'=>'text-uppercase']) !!}
                                <p id="log_old_value"></p>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('new_values', 'Valor novo:',
                                ['class'=>'text-uppercase']) !!}
                                <p id="log_new_value"></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const getLog = () => {
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
