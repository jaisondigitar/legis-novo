<table class="table table-striped table-hover" id="parameters-table">
    <thead>
        <th>Tipo</th>
        <th>Nome</th>
        <th>Sigla</th>
        <th>Valor</th>
        <th>Ações</th>
    </thead>
    <tbody>
    @foreach($parameters as $parameters)
        <tr>
            <td>{!! $parameters->type == 1 ? 'Checkbox' : 'Input' !!}</td>
            <td>{!! $parameters->name !!}</td>
            <td>{!! $parameters->slug !!}</td>
            <td>{!! (isset($parameters) && $parameters->type == 1) ? ($parameters->value == 1 ? 'Sim' : 'Não') : $parameters->value!!}</td>
            <td>
                {!! Form::open(['route' => ['parameters.destroy', $parameters->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('parameters.show')<a @popper(Visualizar) href="{!! route('parameters.show', [$parameters->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                    @shield('parameters.edit')<a @popper(Editar) href="{!! route('parameters.edit', [$parameters->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                    @shield('parameters.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-sm'
                        onclick="sweet(event, {!! $parameters->id !!})"
                    >
                        <i class="fa fa-trash"></i>
                    </button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/config/parameters/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
