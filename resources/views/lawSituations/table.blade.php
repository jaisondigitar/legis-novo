<table class="table table-responsive" id="lawSituations-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawSituations as $lawSituation)
        <tr>
            <td>{!! $lawSituation->name !!}</td>
            <td>
                {!! Form::open(['route' => ['lawSituations.destroy', $lawSituation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawSituations.show')<a href="{!! route('lawSituations.show', [$lawSituation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('lawSituations.edit')<a href="{!! route('lawSituations.edit', [$lawSituation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('lawSituations.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>