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
                    @shield('version_pauta.create')<a @popper(Criar) href="{!! route('version_pauta.createStructure', [$versao_pauta->id]) !!}" class='btn btn-default btn-sm' @if($versao_pauta->id == 1) disabled @endif><i class="fa fa-th-list"></i></a>@endshield
                    @shield('version_pauta.show')<a @popper(Visualizar) href="{!! route('version_pauta.show', [$versao_pauta->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('version_pauta.edit')<a @popper(Editar) href="{!! route('version_pauta.edit', [$versao_pauta->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @if($versao_pauta->id > 1)
                    @shield('version_pauta.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
