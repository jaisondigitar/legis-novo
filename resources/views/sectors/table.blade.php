<table class="table table-responsive" id="sectors-table">
    <thead>
        <th>Nome</th>
        <th>Externo</th>
        <th>Slug</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($sectors as $sector)
        <tr>
            <td>{!! $sector->name !!}</td>
            <td>
                @if($sector->external == true)
                    Sim
                @else
                    Não
                @endif
            </td>
            <td>{!! $sector->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['sectors.destroy', $sector->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('sectors.show')<a href="{!! route('sectors.show', [$sector->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('sectors.edit')<a href="{!! route('sectors.edit', [$sector->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('sectors.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
