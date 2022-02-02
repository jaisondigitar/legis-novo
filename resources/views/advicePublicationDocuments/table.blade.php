<table class="table table-responsive" id="advicePublicationDocuments-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($advicePublicationDocuments as $advicePublicationDocuments)
        <tr>
            <td>{!! $advicePublicationDocuments->name !!}</td>
            <td>
                {!! Form::open(['route' => ['advicePublicationDocuments.destroy', $advicePublicationDocuments->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('advicePublicationDocuments.show')<a @popper(Visualizar) href="{!! route('advicePublicationDocuments.show', [$advicePublicationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('advicePublicationDocuments.edit')<a @popper(Editar) href="{!! route('advicePublicationDocuments.edit', [$advicePublicationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('advicePublicationDocuments.delete')<a @popper(Deletar) </a>{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
