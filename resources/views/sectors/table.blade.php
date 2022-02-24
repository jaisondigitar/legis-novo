<table class="table table-striped table-hover" id="sectors-table">
    <thead>
        <th>Nome</th>
        <th>Externo</th>
        <th>Slug</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($sectors as $sector)
        <tr>
            <td>{!! $sector->name !!}</td>
            <td>
                <label>
                    <div class="form-check form-switch form-switch-md">
                        <input
                            type="checkbox"
                            id="external-{{$sector->id}}"
                            onchange="statusExternal('{!! $sector->id !!}')"
                            name="active"
                            class="form-check-input"
                            @if($sector->external)
                            checked
                            @endif
                        >
                    </div>
                </label>
            </td>
            <td>{!! $sector->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['sectors.destroy', $sector->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('sectors.show')<a @popper(Visualizar) href="{!! route('sectors.show', [$sector->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                    @shield('sectors.edit')<a @popper(Editar) href="{!! route('sectors.edit', [$sector->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                    @shield('sectors.delete')
                    <button
                        @popper(Deletar)
                        type = 'submit'
                        class = 'btn btn-danger btn-sm'
                        onclick="sweet(event, {!! $sector->id !!})"
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
        const url = `/sectors/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }

    const statusExternal = (id) => {
        const url = `/sectors/${id}`;

        const data = {
            external: $('#external-'+id).is(':checked'),
            _token : '{{csrf_token()}}'
        }

        $.ajax({
            url: url,
            data : data,
            method: "PATCH"
        }).success(() => {
            toastr.success("Setor alterado com secesso");
        });
    }
</script>
