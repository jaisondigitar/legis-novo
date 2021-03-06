<table class="table table-responsive" id="legislatures-table">
    <thead>
        <th>De</th>
        <th>Até</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($legislatures as $legislature)
        <tr>
            <td>{!! $legislature->from !!}</td>
            <td>{!! $legislature->to !!}</td>
            <td>
                {!! Form::open(['route' => ['legislatures.destroy', $legislature->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('legislatures.show')<a @popper(Visualizar) href="{!! route('legislatures.show', [$legislature->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('legislatures.edit')<a @popper(Editar) href="{!! route('legislatures.edit', [$legislature->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('legislatures.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick="sweet(event, {!! $legislature->id !!})"
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
<script>
    const sweet = (e, id) => {
        const url = `/legislatures/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
