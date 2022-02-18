<table class="table table-responsive" id="adviceSituationDocuments-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($adviceSituationDocuments as $adviceSituationDocuments)
        <tr>
            <td>{!! $adviceSituationDocuments->name !!}</td>
            <td>
                {!! Form::open(['route' => ['adviceSituationDocuments.destroy', $adviceSituationDocuments->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('adviceSituationDocuments.show')<a @popper(Visualizar) href="{!! route('adviceSituationDocuments.show', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('adviceSituationDocuments.edit')<a @popper(Editar) href="{!! route('adviceSituationDocuments.edit', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('adviceSituationDocuments.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick = 'sweet(event, {!! $adviceSituationDocuments->id !!})'
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
        const url = `/adviceSituationDocuments/${id}`;

        const data = {
            '_token' : '{{csrf_token()}}'
        };

        sweetDelete(e, url, data)
    }
</script>
