<table class="table table-responsive" id="lawsTypes-table">
    <thead>
        <th>Name</th>
        <th>Ativo</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsTypes as $lawsType)
        <tr>
            <td>{!! $lawsType->name !!}</td>
            <td>

                @is(['root', 'admin'])
                    <input class="switch" onchange="changeActive('{!! $lawsType->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal"  type="checkbox" {!! $lawsType->is_active > 0 ? 'checked' : '' !!}>
                @endis
            </td>
            <td>
                {!! Form::open(['route' => ['lawsTypes.destroy', $lawsType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawsTypes.show')<a @popper(Visualizar) href="{!! route('lawsTypes.show', [$lawsType->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('lawsTypes.edit')<a @popper(Editar) href="{!! route('lawsTypes.edit', [$lawsType->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('lawsTypes.delete')
                    <button
                        @popper(Deletar)
                        type = "submit"
                        class = 'btn btn-danger btn-xs'
                        onclick ="sweet(event, {!! $lawsType->id !!})"
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
    var changeActive = function(id){
        var url = '/lawsTypes-active/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result) {
        });
    };

    const sweet = (e, id) => {
        const url = `/lawsTypes/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
