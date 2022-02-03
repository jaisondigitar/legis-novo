<table class="table table-responsive" id="documentSituations-table">
    <thead>
        <th>Nome</th>
        <th>Ativo</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($documentSituations as $documentSituation)
        <tr>
            <td>{!! $documentSituation->name !!}</td>
            <td>{!! $documentSituation->active ? 'Sim' : 'Não' !!}</td>
            <td>
                {!! Form::open(['route' => ['documentSituations.destroy', $documentSituation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('documentSituations.show')<a @popper(Visualizar) href="{!! route('documentSituations.show', [$documentSituation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('documentSituations.edit')<a @popper(Editar) href="{!! route('documentSituations.edit', [$documentSituation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('documentSituations.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
