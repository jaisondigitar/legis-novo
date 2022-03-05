<table class="table table-responsive" id="advices-table">
    <thead>
        <th>Date</th>
        <th>Type</th>
        <th>To Id</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($advices as $advice)
        <tr>
            <td>{!! $advice->date !!}</td>
            <td>{!! $advice->type !!}</td>
            <td>{!! $advice->to_id !!}</td>
            <td>
                {!! Form::open(['route' => ['$ROUTES_AS_PREFIX$advices.destroy', $advice->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('advices.show')<a href="{!! route('$ROUTES_AS_PREFIX$advices.show', [$advice->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('advices.edit')<a href="{!! route('$ROUTES_AS_PREFIX$advices.edit', [$advice->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('advices.delete'){!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
