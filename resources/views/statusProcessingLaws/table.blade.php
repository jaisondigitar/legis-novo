<table class="table table-striped table-hover" id="statusProcessingLaws-table">
    <thead>
        <th>Name</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($statusProcessingLaws as $statusProcessingLaw)
        <tr>
            <td>{!! $statusProcessingLaw->name !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['statusProcessingLaws.destroy', $statusProcessingLaw->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('statusProcessingLaws.show')<a @popper(Visualizar) href="{!! route('statusProcessingLaws.show', [$statusProcessingLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('statusProcessingLaws.edit')<a @popper(Editar) href="{!! route('statusProcessingLaws.edit', [$statusProcessingLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('statusProcessingLaws.delete')
                            <button
                                @popper(Deletar)
                                type = "submit"
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $statusProcessingLaw->id !!})"
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
        const url = `/statusProcessingLaws/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
