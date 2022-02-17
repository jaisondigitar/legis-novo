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
                    @shield('lawSituations.show')<a @popper(Visualizar) href="{!! route('lawSituations.show', [$lawSituation->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('lawSituations.edit')<a @popper(Editar) href="{!! route('lawSituations.edit', [$lawSituation->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('lawSituations.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
