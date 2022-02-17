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
                    @shield('adviceSituationDocuments.show')<a @popper(Visualizar) href="{!! route('adviceSituationDocuments.show', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('adviceSituationDocuments.edit')<a @popper(Editar) href="{!! route('adviceSituationDocuments.edit', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('adviceSituationDocuments.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-sm'
                        onclick = "return confirm('Are you sure?')"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
