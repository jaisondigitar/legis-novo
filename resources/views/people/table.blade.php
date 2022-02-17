<table class="table table-responsive" id="people-table">
    <thead>
    <th>Nome</th>
    <th>Cpf</th>
    <th>Celular</th>
    <th>Manutenção</th>
    </thead>
    <tbody>
    @foreach($people as $p)
        <tr>
            <td>{!! $p->name !!}</td>
            <td>{!! $p->cpf !!}</td>
            <td>{!! $p->celular !!}</td>
            <td>
                {!! Form::open(['route' => ['people.destroy', $p->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('people.show')
                    <a @popper(Visualizar) href="{!! route('people.show', [$p->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>
                    @endshield
                    @shield('people.edit')
                    <a @popper(Editar) href="{!! route('people.edit', [$p->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>
                    @endshield
                    @shield('people.delete')
                    <button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
