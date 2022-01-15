@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group">
                    <a href="{!! route('roles.index') !!}">
                        <button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Voltar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr class="hr">

    <h2>Permissões de <b>{{ $roles->name }}</b></h2>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 10px">
        @foreach($list as $group_name)
            <div>
                <?php $count = 0; ?>

                @foreach($perms as $index => $permission)
                    <?php
                        $checked = ((bool) $roles->permissions->pluck('name')->search($permission->name)) ?
                            'checked' : '';

                        if (explode('.', $permission->name)[0] === $group_name) {
                            if ($count === 0) {
                                echo '<li class="list-group-item active">
                                    <span
                                        style="margin-right: 10px;
                                        font-size: 20px"
                                        aria-hidden="true"
                                    >
                                        '.$permission->readable_name.'
                                    </span>
                                </li>';
                            }

                            echo '<li class="list-group-item ">
                                <span class="pull-left" style="margin-right: 10px">
                                    <input
                                        id="perm_'.$permission->name.'"
                                        onchange="togglePerm(\''.$roles->name.'\',\''.$permission->id.'\')"
                                        type="checkbox" '.$checked.'
                                    >
                                </span>
                                <label for="perm_'.$permission->name.'">
                                    '.$permission->readable_name.'
                                </label>
                            </li>';

                            $count++;
                        }
                    ?>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<script>
    const togglePerm = (role, perm) => {
        $.ajax({
            method: 'GET',
            url: '/gerencial/roles/toggle/permission/'+role+'/'+perm,
            dataType: 'json'
        }).success(result => console.log(result))
    }
</script>
@endsection
