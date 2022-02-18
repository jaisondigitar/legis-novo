<table class="table table-responsive" id="parties-table">
    <thead>
        <th>Sigla</th>
        <th>Nome</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($parties as $party)
        <tr>
            <td>{!! $party->prefix !!}</td>
            <td>{!! $party->name !!}</td>
            <td>
                {!! Form::open(['route' => ['parties.destroy', $party->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('parties.show')<a @popper(Visualizar) href="{!! route('parties.show', [$party->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('parties.edit')<a @popper(Editar) href="{!! route('parties.edit', [$party->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('parties.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick="sweet(event, {!! $party->id !!})"
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
        const url = `/parties/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
