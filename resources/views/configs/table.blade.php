<table class="table table-responsive" id="configs-table">
    <thead>
        <th>Name</th>
        <th>Type</th>
        <th>Slug</th>
        <th>Value</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($configs as $config)
        <tr>
            <td>{!! $config->name !!}</td>
            <td>{!! $config->type !!}</td>
            <td>{!! $config->slug !!}</td>
            <td>{!! $config->value !!}</td>
            <td>
                {!! Form::open(['route' => ['$ROUTES_AS_PREFIX$configs.destroy', $config->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('configs.show')<a @popper(Visualizar) href="{!! route('$ROUTES_AS_PREFIX$configs.show', [$config->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('configs.edit')<a @popper(Editar) href="{!! route('$ROUTES_AS_PREFIX$configs.edit', [$config->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('configs.delete')<a @popper(Deletar) </a>{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
