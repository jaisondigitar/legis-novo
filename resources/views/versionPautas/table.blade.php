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
                    @shield('version_pauta.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
