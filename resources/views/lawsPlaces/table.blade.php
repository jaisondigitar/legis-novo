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
                    @shield('lawsPlaces.show')<a @popper(Visualizar) href="{!! route('lawsPlaces.show', [$lawsPlace->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('lawsPlaces.edit')<a @popper(Editar) href="{!! route('lawsPlaces.edit', [$lawsPlace->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('lawsPlaces.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
