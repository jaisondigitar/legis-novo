<table class="table table-responsive" id="sectors-table">
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
                    <input
                        type="checkbox"
                        id="external-{{$sector->id}}"
                        onchange="statusExternal('{!! $sector->id !!}')"
                        class='form-control switch'
                        data-on-text='Sim'
                        data-off-text='Não'
                        data-off-color='danger'
                        data-on-color='success'
                        data-size='normal'
                        @if($sector->external == 1)
                            checked
                        @endif
                    >
                </label>
            </td>
            <td>{!! $sector->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['sectors.destroy', $sector->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('sectors.show')<a @popper(Visualizar) href="{!! route('sectors.show', [$sector->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('sectors.edit')<a @popper(Editar) href="{!! route('sectors.edit', [$sector->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('sectors.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
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
