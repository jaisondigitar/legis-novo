<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Setor</th>
            <th>Email</th>
            <th>Regras</th>
            <th width="80px">Ativo</th>
            <th width="150px">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            @if($user->hasRole('root') && !Defender::hasRole('root'))   @else
            <tr>
                <td>{!! $user->name !!}</td>
                <td>{!! $user->sector->name !!}</td>
                <td>{!! $user->email !!}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge badge-info">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    @shield('users.edit')<input class="switch" onchange="changeStatus('{!! $user->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal"  type="checkbox" {!! $user->active>0?'checked':'' !!}>@endshield
                </td>
                <td>
                    @is(['admin','root']) <a @popper(Hístorico) href="/users/{!! $user->id !!}/auditing"><i class="fa fa-user-secret icon-rounded btn-sm icon-dark"></i></a>@endis
                    @shield('users.show')<a @popper(Visualizar) href="{!! route('users.show', [$user->id]) !!}" class="btn-default btn-sm"><i class="fas fa-eye"></i></a>@endshield
                    @shield('users.edit')<a @popper(Editar) href="{!! route('users.edit', [$user->id]) !!}" class="btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('users.delete')<a @popper(Deletar) href="{!! route('users.delete', [$user->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"class="btn-danger btn-sm"><i class="fas fa-trash"></i></a>@endshield
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
<script>
    const changeStatus = function(id){
        const url = '/users/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result) {
            console.log(result);
        });
    }
</script>
