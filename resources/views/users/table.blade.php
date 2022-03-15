<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Setor</th>
            <th>Email</th>
            <th>Regras</th>
            <th width="80px">Ativo</th>
            <th style="width: 11.25rem">Ação</th>
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
                    @shield('users.edit')
                    <div class="form-check form-switch form-switch-md">
                        <input
                            onchange="changeStatus('{!! $user->id !!}')"
                            id="active"
                            name="active"
                            class="form-check-input"
                            type="checkbox"
                            @if($user->active)
                            checked
                            @endif
                        >
                    </div>
                    @endshield
                </td>
                <td>
                    @is(['admin','root']) <a @popper(Hístorico) href="/users/{!! $user->id !!}/auditing" class="btn btn-default btn-sm"><i class="fa fa-user-secret"></i></a>@endis
                    @shield('users.show')<a @popper(Visualizar) href="{!! route('users.show', [$user->id]) !!}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>@endshield
                    @shield('users.edit')<a @popper(Editar) href="{!! route('users.edit', [$user->id]) !!}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>@endshield
                    @shield('users.delete')
                        <a
                            class="btn btn-danger btn-sm"
                            @popper(Deletar)
                            type="submit"
                            onclick="sweet(event, {!! $user->id !!})"
                        >
                            <i class="fa fa-trash"></i>
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
