<table class="table table-striped table-hover" id="types-table">
    <thead>
        <th>Nome</th>
        <th>Slug</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($versao_pautas as $versao_pauta)
        <tr>
            <td>{!! $versao_pauta->name !!}</td>
            <td>{!! $versao_pauta->slug !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['version_pauta.destroy', $versao_pauta->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('version_pauta.create')<a @popper(Criar) href="{!! route('version_pauta.createStructure', [$versao_pauta->id]) !!}" class='btn btn-default btn-sm' @if($versao_pauta->id == 1) disabled @endif><i class="fa fa-list"></i></a>@endshield
                            @shield('version_pauta.show')<a @popper(Visualizar) href="{!! route('version_pauta.show', [$versao_pauta->id]) !!}" class='btn btn-default btn-sm' @if($versao_pauta->id == 1) disabled @endif><i class="fa fa-eye"></i></a>@endshield
                            @shield('version_pauta.edit')<a @popper(Editar) href="{!! route('version_pauta.edit', [$versao_pauta->id]) !!}" class='btn btn-default btn-sm' @if($versao_pauta->id == 1) disabled @endif><i class="fa fa-edit"></i></a>@endshield
                            @if($versao_pauta->id > 1)
                            @shield('version_pauta.delete')
                                <button
                                    @popper(Deletar)
                                    type = 'submit'
                                    class = 'btn btn-danger btn-sm'
                                    onclick="sweet(event, {!! $versao_pauta->id !!})"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            @endshield
                            @endif
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
        const url = `/version_pauta/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>

