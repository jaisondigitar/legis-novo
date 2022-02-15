<table class="table table-responsive" id="types-table">
    <thead>
        <th>Nome</th>
        <th>Slug</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($versao_pautas as $versao_pauta)
        <tr>
            <td>{!! $versao_pauta->name !!}</td>
            <td>{!! $versao_pauta->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['version_pauta.destroy', $versao_pauta->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('version_pauta.create')<a @popper(Criar) href="{!! route('version_pauta.createStructure', [$versao_pauta->id]) !!}" class='btn btn-default btn-xs' @if($versao_pauta->id == 1) disabled @endif><i class="glyphicon glyphicon-th-list"></i></a>@endshield
                    @shield('version_pauta.show')<a @popper(Visualizar) href="{!! route('version_pauta.show', [$versao_pauta->id]) !!}" class='btn btn-default btn-xs' @if($versao_pauta->id == 1) disabled @endif><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('version_pauta.edit')<a @popper(Editar) href="{!! route('version_pauta.edit', [$versao_pauta->id]) !!}" class='btn btn-default btn-xs' @if($versao_pauta->id == 1) disabled @endif><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @if($versao_pauta->id > 1)
                    @shield('version_pauta.delete')
                        <button
                            @popper(Deletar)
                            type = 'submit'
                            class = 'btn btn-danger btn-xs'
                            onclick="sweet(event, {!! $versao_pauta->id !!})"
                        >
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    @endshield
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/version_pauta/${id}`;

        const data = null

        const method = 'DELETE'

        sweetDelete(e, url, data, method)
    }
</script>

