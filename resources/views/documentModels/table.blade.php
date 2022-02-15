<table class="table table-responsive" id="documentModels-table">
    <thead>
        <th>Tipo Documento</th>
        <th>Nome</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($documentModels as $documentModel)
        <tr>
            <td>{!! $documentModel->document_type->name !!}</td>
            <td>{!! $documentModel->name !!}</td>
            <td>
                {!! Form::open(['route' => ['documentModels.destroy', $documentModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('documentModels.show')<a @popper(Visualizar) href="{!! route('documentModels.show', [$documentModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('documentModels.edit')<a @popper(Editar) href="{!! route('documentModels.edit', [$documentModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('documentModels.delete')
                        <button
                            @popper(Deletar)
                            type='submit'
                            class='btn btn-danger btn-xs'
                            onclick="sweet(event, {!! $documentModel->id !!})"
                        >
                            <i class="glyphicon glyphicon-trash"></i>
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
        const url = `/documentModels/${id}`;

        const data = null

        const method = 'DELETE'

        sweetDelete(e, url, data, method)
    }
</script>

