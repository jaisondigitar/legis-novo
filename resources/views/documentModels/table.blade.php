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
                    @shield('documentModels.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
