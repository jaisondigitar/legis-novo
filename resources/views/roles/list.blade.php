<ul class="list-group">
    @foreach($roles as $role)
        @if($role->name == 'root' && !Defender::hasRole('root'))
        @else
        <li class="list-group-item">
            <i class="fa fa-angle-double-right"></i> {{ $role->name }}
            <span class="pull-right">
                @shield('roles.show')
                    <a @popper(Permissões) href="{!! route('gerencial.roles.permission', [$role->id])!!}">
                        <button type="button" class="btn btn-primary btn-sm "><i class="fa fa-list-ol"></i></button>
                    </a>
                @endshield
                @shield('roles.edit')
                    <a @popper(Editar) href="{!! route('roles.edit', [$role->id]) !!}">
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                    </a>
                @endshield
                @shield('roles.delete')
                    <a @popper(deletar)
                       type="submit"
                       onclick="sweet(event, {!! $role->id !!})"
                    >
                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </a>
                @endshield
            </span>
        </li>
        @endif
    @endforeach
</ul>
<script>
    const sweet = (e, id) => {
        const url = `/gerencial/roles/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>

