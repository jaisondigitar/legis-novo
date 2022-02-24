<table class="table table-striped table-hover" id="comissionSituations-table">
    <thead>
        <th>Name</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($comissionSituations as $comissionSituation)
        <tr>
            <td>{!! $comissionSituation->name !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['comissionSituations.destroy', $comissionSituation->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('comissionSituations.show')<a @popper(Visualizar) href="{!! route('comissionSituations.show', [$comissionSituation->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('comissionSituations.edit')<a @popper(Editar) href="{!! route('comissionSituations.edit', [$comissionSituation->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('comissionSituations.delete')
                            <button
                                @popper(Deletar)
                                type = 'submit'
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $comissionSituation->id !!})"
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
        const url = `/comissionSituations/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
