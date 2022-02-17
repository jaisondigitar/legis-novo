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
                    @shield('lawsStructures.show')<a @popper(Visualizar) href="{!! route('lawsStructures.show', [$lawsStructure->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('lawsStructures.edit')<a @popper(Editar) href="{!! route('lawsStructures.edit', [$lawsStructure->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('lawsStructures.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
