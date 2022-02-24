<table class="table table-striped table-hover" id="parties-table">
    <thead>
        <th>Sigla</th>
        <th>Nome</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($parties as $party)
        <tr>
            <td>{!! $party->prefix !!}</td>
            <td>{!! $party->name !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['parties.destroy', $party->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('parties.show')<a @popper(Visualizar) href="{!! route('parties.show', [$party->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('parties.edit')<a @popper(Editar) href="{!! route('parties.edit', [$party->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('parties.delete')
                            <button
                                @popper(Deletar)
                                type = 'submit'
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $party->id !!})"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                            @endshield
                        </div>
                    {!! Form::close() !!}
                </div>
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
