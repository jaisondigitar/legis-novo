<table class="table table-responsive" id="parameters-table">
    <thead>
        <th>Tipo</th>
        <th>Nome</th>
        <th>Sigla</th>
        <th>Valor</th>
        <th colspan="3">Manutenção</th>
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
                    @shield('parameters.show')<a @popper(Visualizar) href="{!! route('parameters.show', [$parameters->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('parameters.edit')<a @popper(Editar) href="{!! route('parameters.edit', [$parameters->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('parameters.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
