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
                    @shield('typeVotings.show')<a @popper(Visualizar) href="{!! route('typeVotings.show', [$type->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('typeVotings.edit')<a @popper(Editar) href="{!! route('typeVotings.edit', [$type->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('typeVotings.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
