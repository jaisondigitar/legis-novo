<table class="table table-striped table-hover" id="legislatures-table">
    <thead>
        <th>De</th>
        <th>Até</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($legislatures as $legislature)
        <tr>
            <td>{!! $legislature->from !!}</td>
            <td>{!! $legislature->to !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['legislatures.destroy', $legislature->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('legislatures.show')<a @popper(Visualizar) href="{!! route('legislatures.show', [$legislature->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('legislatures.edit')<a @popper(Editar) href="{!! route('legislatures.edit', [$legislature->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('legislatures.delete')
                            <button
                                @popper(Deletar)
                                type = 'submit'
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $legislature->id !!})"
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
        const url = `/legislatures/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
