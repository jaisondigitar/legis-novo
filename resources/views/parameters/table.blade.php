<table class="table" id="parameters-table">
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
                    @shield('parameters.show')
                    <a
                        @popper(Visualizar)
                        href="{!! route('parameters.show', [$parameters->id]) !!}"
                        class='btn btn-default btn-sm'
                    >
                        <i class="fas fa-eye"></i>
                    </a>
                    @endshield
                    @shield('parameters.edit')
                    <a
                        @popper(Editar)
                        href="{!! route('parameters.edit', [$parameters->id]) !!}"
                        class='btn btn-default btn-sm'
                    >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    @endshield
                    @shield('parameters.delete')
                        {!! Form::button('<i @popper(Deletar) class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
