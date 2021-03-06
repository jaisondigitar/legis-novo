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
                    @shield('documentSituations.show')<a @popper(Visualizar) href="{!! route('documentSituations.show', [$documentSituation->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('documentSituations.edit')<a @popper(Editar) href="{!! route('documentSituations.edit', [$documentSituation->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('documentSituations.delete')
                       <button
                           @popper(Deletar)
                           type='submit'
                           class='btn btn-danger btn-xs'
                           onclick="sweet(event, {!! $documentSituation->id !!})"
                       >
                           <i class="fa fa-trash"></i>
                       </button>
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/documentSituations/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
