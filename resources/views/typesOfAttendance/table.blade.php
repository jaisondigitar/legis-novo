<table class="table table-striped table-hover" id="typesOfAttendance-table">
    <thead>
        <th>Nome</th>
        <th>Ativo</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($typesOfAttendance as $type)
        <tr>
            <td>{!! $type->name !!}</td>
            <td>
                <label>
                    <div class="form-check form-switch form-switch-md">
                        <input
                            onchange="statusActive('{!! $type->id !!}')"
                            id="active"
                            name="active"
                            class="form-check-input"
                            type="checkbox"
                            @if($type->active)
                            checked
                            @endif
                        >
                    </div>
                </label>
            </td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['typesOfAttendance.destroy', $type->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('typesOfAttendance.show')
                            <a @popper(Visualizar) href="{!! route('typesOfAttendance.show', [$type->id]) !!}" class='btn btn-default btn-sm'>
                                <i class="fa fa-eye"></i>
                            </a>
                            @endshield
                            @shield('typesOfAttendance.edit')
                            <a @popper(Editar) href="{!! route('typesOfAttendance.edit', [$type->id]) !!}" class='btn btn-default btn-sm'>
                                <i class="fa fa-edit"></i>
                            </a>
                            @endshield
                            @shield('typesOfAttendance.delete')
                            <button
                                @popper(Deletar)
                                type = 'submit'
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $type->id !!})"
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
        const url = `/types-of-attendance/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }

    const statusActive = (id) => {
        const url = `/types-of-attendance/${id}`;

        const data = {
            active: $('#active-'+id).is(':checked'),
            _token : '{{csrf_token()}}'
        }

        $.ajax({
            url: url,
            data : data,
            method: "PUT"
        }).success(() => {
            toastr.success("Tipo de Atencimento alterado com sucesso");
        });
    }
</script>
