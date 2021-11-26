<table class="table table-responsive" id="lawsStructures-table">
    <thead>
        <th>Name</th>
        <th>Prefix</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsStructures as $lawsStructure)
        <tr>
            <td>{!! $lawsStructure->name !!}</td>
            <td>{!! $lawsStructure->prefix !!}</td>
            <td>
                {!! Form::open(['route' => ['lawsStructures.destroy', $lawsStructure->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawsStructures.show')<a href="{!! route('lawsStructures.show', [$lawsStructure->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('lawsStructures.edit')<a href="{!! route('lawsStructures.edit', [$lawsStructure->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('lawsStructures.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
