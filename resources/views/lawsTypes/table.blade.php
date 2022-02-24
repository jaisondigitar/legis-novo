<table class="table table-striped table-hover" id="lawsTypes-table">
    <thead>
        <th>Name</th>
        <th>Ativo</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsTypes as $lawsType)
        <tr>
            <td>{!! $lawsType->name !!}</td>
            <td>

                @is(['root', 'admin'])
                <div class="form-check form-switch form-switch-md">
                    <input
                        onchange="changeActive('{!! $lawsType->id !!}')"
                        id="active"
                        name="active"
                        class="form-check-input"
                        type="checkbox"
                        @if($lawsType->is_active)
                        checked
                        @endif
                    >
                </div>
                @endis
            </td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['lawsTypes.destroy', $lawsType->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('lawsTypes.show')<a @popper(Visualizar) href="{!! route('lawsTypes.show', [$lawsType->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('lawsTypes.edit')<a @popper(Editar) href="{!! route('lawsTypes.edit', [$lawsType->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('lawsTypes.delete')
                            <button
                                @popper(Deletar)
                                type = "submit"
                                class = 'btn btn-danger btn-sm'
                                onclick ="sweet(event, {!! $lawsType->id !!})"
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
