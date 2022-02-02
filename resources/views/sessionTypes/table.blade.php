<table class="table table-responsive" id="sessionTypes-table">
    <thead>
        <th>Nome</th>
        <th>Sigla</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($sessionTypes as $sessionType)
        <tr>
            <td>{!! $sessionType->name !!}</td>
            <td>{!! $sessionType->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['sessionTypes.destroy', $sessionType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('sessionTypes.show')<a @popper(Visualizar) href="{!! route('sessionTypes.show', [$sessionType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('sessionTypes.edit')<a @popper(Editar) href="{!! route('sessionTypes.edit', [$sessionType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('sessionTypes.delete')<a @popper(Editar) </a>{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
