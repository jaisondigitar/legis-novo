<table class="table table-responsive" id="sessionPlaces-table">
    <thead>
        <th>Name</th>
        <th>Slug</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($sessionPlaces as $sessionPlace)
        <tr>
            <td>{!! $sessionPlace->name !!}</td>
            <td>{!! $sessionPlace->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['sessionPlaces.destroy', $sessionPlace->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('sessionPlaces.show')<a href="{!! route('sessionPlaces.show', [$sessionPlace->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('sessionPlaces.edit')<a href="{!! route('sessionPlaces.edit', [$sessionPlace->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('sessionPlaces.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>