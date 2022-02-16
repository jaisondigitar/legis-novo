<table class="table table-responsive" id="typesOfAttendance-table">
    <thead>
        <th>Nome</th>
        <th>Manutenção</th>
    </thead>
    <tbody>
    @foreach($typesOfAttendance as $type)
        <tr>
            <td>{!! $type->name !!}</td>
            <td>
                {!! Form::open(['route' => ['typesOfAttendance.destroy', $type->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('typesOfAttendance.show')
                    <a @popper(Visualizar) href="{!! route('typesOfAttendance.show', [$type->id]) !!}" class='btn btn-default btn-xs'>
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                    @endshield
                    @shield('typesOfAttendance.edit')
                    <a @popper(Editar) href="{!! route('typesOfAttendance.edit', [$type->id]) !!}" class='btn btn-default btn-xs'>
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    @endshield
                    @shield('typesOfAttendance.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick="sweet(event, {!! $type->id !!})"
                    >
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/types-of-attendance/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
