<ul class="list-group">
    @foreach($roles as $role)
        @if($role->name == 'root' && !Defender::hasRole('root'))
        @else
        <li class="list-group-item">
            <i class="fa fa-angle-double-right"></i> {{ $role->name }}
            <span class="pull-right">
                @shield('roles.show')
                    <a @popper(Permissões) href="{!! route('gerencial.roles.permission', [$role->id])!!}">
                        <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-list-ol"></i></button>
                    </a>
                @endshield
                @shield('roles.edit')
                    <a @popper(Editar) href="{!! route('roles.edit', [$role->id]) !!}">
                        <button type="button" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></button>
                    </a>
                @endshield
                @shield('roles.delete')
                    <a @popper(Deletar) href="{!! route('gerencial.roles.delete', [$role->id])!!}" onclick="return confirm('Deseja deletar este registro?')">
                        <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </a>
                @endshield
            </span>
        </li>
        @endif
    @endforeach
</ul>
