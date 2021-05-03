<table class="table table-responsive" id="legislatures-table">
    <thead>
        <th>De</th>
        <th>Até</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($legislatures as $legislature)
        <tr>
            <td>{!! $legislature->from !!}</td>
            <td>{!! $legislature->to !!}</td>
            <td>
                {!! Form::open(['route' => ['legislatures.destroy', $legislature->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('legislatures.show')<a href="{!! route('legislatures.show', [$legislature->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('legislatures.edit')<a href="{!! route('legislatures.edit', [$legislature->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('legislatures.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>