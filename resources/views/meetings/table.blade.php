<table class="table table-responsive" id="meetings-table">
    <thead>
        <th>Tipo Sessão</th>
        <th>Local Sessão</th>
        <th>Número</th>
        <th>Data Início</th>
        <th>Data Encerramento</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($meetings as $meeting)
        <tr>
            <td>{!! $meeting->session_type->name !!}</td>
            <td>{!! $meeting->session_place->name !!}</td>
            <td>{!! $meeting->number !!}</td>
            <td>{!! $meeting->date_start !!}</td>
            <td>{!! $meeting->date_end !!}</td>
            <td>
                {!! Form::open(['route' => ['meetings.destroy', $meeting->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('meetings.show')<a @popper(Visualizar) href="{!! route('meetings.show', [$meeting->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('meetings.edit')<a @popper(Anexos) href="{!! route('meetings.attachament', [$meeting->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-paperclip"></i></a>@endshield
                    @shield('meetings.edit')<a @popper(Editar) href="{!! route('meetings.edit', [$meeting->id]) !!}" class='btn btn-warning btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('meetings.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Clique em OK para excluir a sessão?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $meetings->appends(request()->input())->render() !!}
