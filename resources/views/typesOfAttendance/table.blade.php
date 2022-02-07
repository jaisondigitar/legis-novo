<table class="table table-responsive" id="typesOfAttendance-table">
    <thead>
        <th>Nome</th>
        <th>Ativo</th>
        <th>Manutenção</th>
    </thead>
    <tbody>
    @foreach($typesOfAttendance as $type)
        <tr>
            <td>{!! $type->name !!}</td>
            <td>
                <label>
                    <input
                        type="checkbox"
                        id="active-{{$type->id}}"
                        onchange="statusActive('{!! $type->id !!}')"
                        class='form-control switch'
                        data-on-text='Sim'
                        data-off-text='Não'
                        data-off-color='danger'
                        data-on-color='success'
                        data-size='normal'
                        @if($type->active == 1)
                            checked
                        @endif
                    >
                </label>
            </td>
            <td>
                {!! Form::open(['route' => ['typesOfAttendance.destroy', $type->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('typesOfAttendance.show')
                    <a @popper(Visualizar) href="{!! route('typesOfAttendance.show', [$type->id]) !!}" class='btn btn-default btn-xs'>
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                    @endshield
                    @shield('typesOfAttendance.edit')
                    <a @popper(Editar) href="{!! route('typesOfAttendance.edit', [$type->id]) !!}" class='btn btn-default btn-xs'>
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    @endshield
                    @shield('typesOfAttendance.delete')
                    {!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', [
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-xs',
                        'onclick' => "return confirm('Deseja realmente remover esse registro?')"
                        ])
                    !!}
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
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
