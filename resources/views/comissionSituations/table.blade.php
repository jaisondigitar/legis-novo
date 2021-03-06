<table class="table table-responsive" id="comissionSituations-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($comissionSituations as $comissionSituation)
        <tr>
            <td>{!! $comissionSituation->name !!}</td>
            <td>
                {!! Form::open(['route' => ['comissionSituations.destroy', $comissionSituation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('comissionSituations.show')<a @popper(Visualizar) href="{!! route('comissionSituations.show', [$comissionSituation->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('comissionSituations.edit')<a @popper(Editar) href="{!! route('comissionSituations.edit', [$comissionSituation->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('comissionSituations.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick="sweet(event, {!! $comissionSituation->id !!})"
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
        const url = `/comissionSituations/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
