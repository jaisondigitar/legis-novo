<table class="table table-responsive" id="protocolTypes-table">
    <thead>
        <th>Nome</th>
        <th>Sigla</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($protocolTypes as $protocolType)
        <tr>
            <td>{!! $protocolType->name !!}</td>
            <td>{!! $protocolType->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['protocolTypes.destroy', $protocolType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('protocolTypes.show')<a href="{!! route('protocolTypes.show', [$protocolType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('protocolTypes.edit')<a href="{!! route('protocolTypes.edit', [$protocolType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('protocolTypes.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>