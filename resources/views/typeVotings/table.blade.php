<table class="table table-responsive" id="types-table">
    <thead>
        <th>Nome</th>
        <th>Anônimo</th>
        <th>Ativo</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($type_voting as $type)
        <tr>
            <td>{!! $type->name !!}</td>
            <td>{!! $type->anonymous ? 'Sim' : 'Não' !!}</td>
            <td>{!! $type->active ? 'Sim' : 'Não' !!}</td>
            <td>
                {!! Form::open(['route' => ['typeVotings.destroy', $type->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('typeVotings.show')<a @popper(Visualizar) href="{!! route('typeVotings.show', [$type->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('typeVotings.edit')<a @popper(Editar) href="{!! route('typeVotings.edit', [$type->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('typeVotings.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
