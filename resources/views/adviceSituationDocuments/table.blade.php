<table class="table table-striped table-hover" id="adviceSituationDocuments-table">
    <thead>
        <th>Name</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($adviceSituationDocuments as $adviceSituationDocuments)
        <tr>
            <td>{!! $adviceSituationDocuments->name !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['adviceSituationDocuments.destroy', $adviceSituationDocuments->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('adviceSituationDocuments.show')<a @popper(Visualizar) href="{!! route('adviceSituationDocuments.show', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('adviceSituationDocuments.edit')<a @popper(Editar) href="{!! route('adviceSituationDocuments.edit', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('adviceSituationDocuments.delete')
                            <button
                                @popper(Deletar)
                                type = 'submit'
                                class = 'btn btn-danger btn-sm'
                                onclick = 'sweet(event, {!! $adviceSituationDocuments->id !!})'
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
        const url = `/adviceSituationDocuments/${id}`;

        const data = {
            '_token' : '{{csrf_token()}}'
        };

        sweetDelete(e, url, data)
    }
</script>
