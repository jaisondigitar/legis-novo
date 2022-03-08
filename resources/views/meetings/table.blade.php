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
                    @shield('meetings.show')<a @popper(Visualizar) href="{!! route('meetings.show', [$meeting->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                    @shield('meetings.edit')<a @popper(Anexos) href="{!! route('meetings.attachament', [$meeting->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-paperclip"></i></a>@endshield
                    @shield('meetings.edit')<a @popper(Editar) href="{!! route('meetings.edit', [$meeting->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                    @shield('meetings.delete')
                        <button
                            @popper(Deletar)
                            type = 'submit'
                            class = 'btn btn-danger btn-sm'
                            onclick="sweet(event, {!! $meeting->id !!})"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $meetings->appends(request()->input())->render() !!}
<script>
    const sweet = (e, id) => {
        const url = `/meetings/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
