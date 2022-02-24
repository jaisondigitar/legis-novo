<table class="table table-bordered table-striped table-hover display nowrap">
    <thead>
        <tr>
            <th style="width: 80px">Nome</th>
            <th style="width: 75rem">Email</th>
            <th style="width: 120px">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($destinations as $destination)
            <tr>
                <td>{!! str_pad($destination->name, 4, "0", STR_PAD_LEFT) !!}</td>
                <td>{!! $destination->email !!}</td>
                <td>
                    {!! Form::open([
                        'route' => ['destinations.destroy', $destination->id],
                        'method' => 'delete'
                    ]) !!}
                    @shield('destination.show')
                        <a @popper(Visualizar) href="{!! route('destinations.show', [$destination->id]) !!}"
                            class="btn btn-default btn-sm">
                            <i class="fa fa-eye"></i>
                        </a>
                    @endshield
                    @shield('destination.edit')
                        <a @popper(Editar) href="{!! route('destinations.edit', [$destination->id]) !!}"
                            class="btn btn-default btn-sm">
                            <i class="fa fa-pencil"></i>
                        </a>
                    @endshield
                    @shield('destination.delete')
                    <button
                        @popper(Deletar)
                        class="btn btn-danger btn-sm"
                        type = "submit"
                        onclick="sweet(event, {!! $destination->id !!})"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    @endshield
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/destinations/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>

