<table class="table table-responsive" id="lawSituations-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawSituations as $lawSituation)
        <tr>
            <td>{!! $lawSituation->name !!}</td>
            <td>
                {!! Form::open(['route' => ['lawSituations.destroy', $lawSituation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawSituations.show')<a @popper(Visualizar) href="{!! route('lawSituations.show', [$lawSituation->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('lawSituations.edit')<a @popper(Editar) href="{!! route('lawSituations.edit', [$lawSituation->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('lawSituations.delete')
                        <button
                            @popper(Deletar)
                            type = "submit"
                            class = 'btn btn-danger btn-xs'
                            onclick="sweet(event, {!! $lawSituation->id !!})"
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
        const url = `/lawSituations/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
