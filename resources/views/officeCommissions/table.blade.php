<table class="table table-responsive" id="officeCommissions-table">
    <thead>
        <th>Nome</th>
        <th>Sigla</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($officeCommissions as $officeCommission)
        <tr>
            <td>{!! $officeCommission->name !!}</td>
            <td>{!! $officeCommission->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['officeCommissions.destroy', $officeCommission->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('officeCommissions.show')<a @popper(Visualizar) href="{!! route('officeCommissions.show', [$officeCommission->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('officeCommissions.edit')<a @popper(Editar) href="{!! route('officeCommissions.edit', [$officeCommission->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('officeCommissions.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-xs'
                        onclick="sweet(event, {!! $officeCommission->id !!})"
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
        const url = `/officeCommissions/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
