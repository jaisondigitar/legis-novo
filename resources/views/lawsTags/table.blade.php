<table class="table table-responsive" id="lawsTags-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsTags as $lawsTag)
        <tr>
            <td>{!! $lawsTag->name !!}</td>
            <td>
                {!! Form::open(['route' => ['lawsTags.destroy', $lawsTag->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawsTags.show')<a @popper(Visualizar) href="{!! route('lawsTags.show', [$lawsTag->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('lawsTags.edit')<a @popper(Editar) href="{!! route('lawsTags.edit', [$lawsTag->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('lawsTags.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
