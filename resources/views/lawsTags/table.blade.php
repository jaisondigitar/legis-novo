<table class="table table-responsive" id="lawsTags-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsTags as $lawsTag)
        <tr>
            <td>{!! $lawsTag->name !!}</td>
            <td>
                {!! Form::open(['route' => ['lawsTags.destroy', $lawsTag->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawsTags.show')<a @popper(Visualizar) href="{!! route('lawsTags.show', [$lawsTag->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('lawsTags.edit')<a @popper(Editar) href="{!! route('lawsTags.edit', [$lawsTag->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('lawsTags.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick="sweet(event, {!! $lawsTag->id !!})"
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
        const url = `/lawsTags/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
