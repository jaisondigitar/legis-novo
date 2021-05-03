<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <th width="50px">UF</th>
        <th>Nome</th>
        <th width="80px">Ação</th>
    </thead>
    <tbody>
    @foreach($states as $state)
        <tr>
            <td>{!! $state->uf !!}</td>
			<td>{!! $state->name !!}</td>
            <td>
                <a href="{!! route('states.edit', [$state->id]) !!}"><i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i></a>
                <a href="{!! route('states.delete', [$state->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"><i class="glyphicon glyphicon-remove icon-rounded icon-xs icon-danger"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
