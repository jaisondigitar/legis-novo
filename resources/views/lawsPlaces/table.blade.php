<table class="table table-responsive" id="lawsPlaces-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsPlaces as $lawsPlace)
        <tr>
            <td>{!! $lawsPlace->name !!}</td>
            <td>
                {!! Form::open(['route' => ['lawsPlaces.destroy', $lawsPlace->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawsPlaces.show')<a href="{!! route('lawsPlaces.show', [$lawsPlace->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('lawsPlaces.edit')<a href="{!! route('lawsPlaces.edit', [$lawsPlace->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('lawsPlaces.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>