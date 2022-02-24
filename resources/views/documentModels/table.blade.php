<table class="table table-striped table-hover" id="documentModels-table">
    <thead>
        <th>Tipo Documento</th>
        <th>Nome</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($documentModels as $documentModel)
        <tr>
            <td>{!! $documentModel->document_type->name !!}</td>
            <td>{!! $documentModel->name !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['documentModels.destroy', $documentModel->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @shield('documentModels.show')<a @popper(Visualizar) href="{!! route('documentModels.show', [$documentModel->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                        @shield('documentModels.edit')<a @popper(Editar) href="{!! route('documentModels.edit', [$documentModel->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                        @shield('documentModels.delete')
                            <button
                                @popper(Deletar)
                                type='submit'
                                class='btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $documentModel->id !!})"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                        @endshield
                    </div>
                        {!! Form::close() !!}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/documentModels/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>

