<table class="table table-striped table-hover" id="configs-table">
    <thead>
        <th>Name</th>
        <th>Type</th>
        <th>Slug</th>
        <th>Value</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($configs as $config)
        <tr>
            <td>{!! $config->name !!}</td>
            <td>{!! $config->type !!}</td>
            <td>{!! $config->slug !!}</td>
            <td>{!! $config->value !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['$ROUTES_AS_PREFIX$configs.destroy', $config->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('configs.show')<a @popper(Visualizar) href="{!! route('$ROUTES_AS_PREFIX$configs.show', [$config->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                            @shield('configs.edit')<a @popper(Editar) href="{!! route('$ROUTES_AS_PREFIX$configs.edit', [$config->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                            @shield('configs.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                        </div>
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
