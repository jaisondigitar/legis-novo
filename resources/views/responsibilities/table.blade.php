<table class="table table-responsive" id="responsibilities-table">
    <thead>
        <th>Nome</th>
        <th>Ordem</th>
        <th>Ignora mesa diretora</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($responsibilities as $responsibility)
        <tr>
            <td>{!! $responsibility->name !!}</td>
            <td>{!! $responsibility->order !!}</td>
            <td>{!! $responsibility->skip_board ? 'Sim' : 'Não' !!}</td>
            <td>
                {!! Form::open(['route' => ['responsibilities.destroy', $responsibility->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('responsibilities.show')<a @popper(Visualizar) href="{!! route('responsibilities.show', [$responsibility->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('responsibilities.edit')<a @popper(Editar) href="{!! route('responsibilities.edit', [$responsibility->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('responsibilities.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
