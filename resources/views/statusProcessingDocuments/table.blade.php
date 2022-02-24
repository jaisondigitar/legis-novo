<table class="table table-striped table-hover" id="statusProcessingDocuments-table">
    <thead>
        <th>Name</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($statusProcessingDocuments as $statusProcessingDocument)
        <tr>
            <td>{!! $statusProcessingDocument->name !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['statusProcessingDocuments.destroy', $statusProcessingDocument->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @shield('statusProcessingDocuments.show')<a @popper(Visualizar) href="{!! route('statusProcessingDocuments.show', [$statusProcessingDocument->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                        @shield('statusProcessingDocuments.edit')<a @popper(Editar) href="{!! route('statusProcessingDocuments.edit', [$statusProcessingDocument->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                        @shield('statusProcessingDocuments.delete')
                        <button
                            @popper(Deletar)
                            type = 'submit'
                            class = 'btn btn-danger btn-sm'
                            onclick = "sweet(event, {!! $statusProcessingDocument->id !!})"
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
        const url = `/statusProcessingDocuments/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>

