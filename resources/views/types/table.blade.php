<table class="table table-striped table-hover" id="types-table">
    <thead>
        <th>Prefixo</th>
        <th>Nome</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($types as $type)
        <tr>
            <td>{!! $type->prefix !!}</td>
            <td>{!! $type->name !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['types.destroy', $type->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('types.show')<a href="{!! route('types.show', [$type->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                            @shield('types.edit')<a href="{!! route('types.edit', [$type->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                            @shield('types.delete'){!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                        </div>
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
