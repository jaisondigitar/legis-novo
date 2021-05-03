<ul class="list-group">
    @foreach($roles as $role)
        @if($role->name == 'root' && !Defender::hasRole('root'))   @else
        <li class="list-group-item">
            <i class="fa fa-angle-double-right"></i> {{ $role->name }}
            <span class="pull-right">
                @shield('roles.show')<a href="{!! route('gerencial.roles.permission', [$role->id]) !!}"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-list-ol"></i> Permissões</button></a>@endshield
                @shield('roles.edit')<a href="{!! route('gerencial.roles.edit', [$role->id]) !!}"><button type="button" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Editar</button></a>@endshield
                @shield('roles.delete')<a href="{!! route('gerencial.roles.delete', [$role->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"><button type="button" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Deletar</button></a>@endshield
            </span>
        </li>
        @endif
    @endforeach
</ul>