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
                    @is(['admin','root']) <a @popper(Hístorico) href="/users/{!! $user->id !!}/auditing"><i class="fa fa-user-secret icon-rounded icon-xs icon-dark"></i></a>@endis
                    @shield('users.show')<a @popper(Visualizar) href="{!! route('users.show', [$user->id]) !!}"><i class="fa fa-eye icon-rounded icon-xs icon-info"></i></a>@endshield
                    @shield('users.edit')<a @popper(Editar) href="{!! route('users.edit', [$user->id]) !!}"><i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i></a>@endshield
                    @shield('users.delete')
                        <a
                            class="pointer"
                            @popper(Deletar)
                            type="submit"
                            onclick="sweet(event, {!! $user->id !!})"
                        >
                            <i class="fa fa-trash icon-rounded icon-xs icon-danger"></i>
                        </a>
                    @endshield
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
<script>
    const sweet = (e, id) => {
        const url = `users/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
