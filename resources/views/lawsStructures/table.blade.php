<table class="table table-responsive" id="lawsStructures-table">
    <thead>
        <th>Name</th>
        <th>Prefix</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsStructures as $lawsStructure)
        <tr>
            <td>{!! $lawsStructure->name !!}</td>
            <td>{!! $lawsStructure->prefix !!}</td>
            <td>
                {!! Form::open(['route' => ['lawsStructures.destroy', $lawsStructure->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawsStructures.show')<a @popper(Visualizar) href="{!! route('lawsStructures.show', [$lawsStructure->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('lawsStructures.edit')<a @popper(Editar) href="{!! route('lawsStructures.edit', [$lawsStructure->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('lawsStructures.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick="sweet(event, {!! $lawsStructure->id !!})"
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
        const url = `/lawsStructures/${id}`;

        const data = null

        const method = 'DELETE'

        sweetDelete(e, url, data, method)
    }
</script>
