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
                    @shield('advicePublicationDocuments.show')<a @popper(Visualizar) href="{!! route('advicePublicationDocuments.show', [$advicePublicationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('advicePublicationDocuments.edit')<a @popper(Editar) href="{!! route('advicePublicationDocuments.edit', [$advicePublicationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('advicePublicationDocuments.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick = 'sweet(event, {!! $advicePublicationDocuments->id !!})'
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
        const url = `/advicePublicationDocuments/${id}`;

        const data = {
            '_token' : '{{csrf_token()}}'
        };

        sweetDelete(e, url, data)
    }
</script>

