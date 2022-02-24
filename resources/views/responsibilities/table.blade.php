<table class="table table-striped table-hover" id="responsibilities-table">
    <thead>
        <th>Nome</th>
        <th>Ordem</th>
        <th>Ignora mesa diretora</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($responsibilities as $responsibility)
        <tr>
            <td>{!! $responsibility->name !!}</td>
            <td>{!! $responsibility->order !!}</td>
            <td>{!! $responsibility->skip_board ? 'Sim' : 'Não' !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['responsibilities.destroy', $responsibility->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('responsibilities.show')<a @popper(Visualizar) href="{!! route('responsibilities.show', [$responsibility->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('responsibilities.edit')<a @popper(Editar) href="{!! route('responsibilities.edit', [$responsibility->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('responsibilities.delete')
                            <button
                                @popper(Deletar)
                                type = 'submit'
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $responsibility->id !!})"
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
        const url = `/responsibilities/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
