<table class="table table-striped table-hover" id="people-table">
    <thead>
    <th>Nome</th>
    <th>Cpf</th>
    <th>Celular</th>
    <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($people as $p)
        <tr>
            <td>{!! $p->name !!}</td>
            <td>{!! $p->cpf !!}</td>
            <td>{!! $p->celular !!}</td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['people.destroy', $p->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('people.show')
                            <a @popper(Visualizar) href="{!! route('people.show', [$p->id]) !!}" class='btn btn-default btn-sm'>
                                <i class="fa fa-eye"></i>
                            </a>
                            @endshield
                            @shield('people.edit')
                            <a @popper(Editar) href="{!! route('people.edit', [$p->id]) !!}" class='btn btn-default btn-sm'>
                                <i class="fa fa-edit"></i>
                            </a>
                            @endshield
                            @shield('people.delete')
                                <button
                                    @popper(Deletar)
                                    type = 'submit'
                                    class = 'btn btn-danger btn-sm'
                                    onclick="sweet(event, {!! $p->id !!})"
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
        const url = `/people/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
