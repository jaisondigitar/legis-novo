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
        @foreach($list as $reg)
            <div>
                <?php $count = 0; ?>
                @foreach($perms as $key => $perm)
                    <?php
                        $check = '';
                        foreach ($roles->permissions as $key2 => $value2) {
                            if ($value2->name == $perm->name) {
                                $check = 'checked';
                            }
                        }

                        $tmp = explode('.', $perm->name);

                        if ($tmp[0] === $reg) {
                            if ($count === 0) {
                                echo '<ul class="list-group">';
                                echo '<li class="list-group-item active">
                                        <i
                                            style="margin-right: 10px"
                                            class="fa fa-check-square-o"
                                            aria-hidden="true"
                                        ></i>'.$perm->readable_name.'
                                    </li>';
                            }

                            echo '<li class="list-group-item ">
                                <span class="pull-left" style="margin-right: 10px">
                                    <input id="perm_'.$perm->name.'" onchange="togglePerm(\''.$roles->name.'\',\''.$perm->id.'\')" type="checkbox" '.$check.'>
                                </span>
                                <span class="disabled" >'.$perm->readable_name.'</span>
                            </li>';
                            echo $count === 4 ? '</ul>' : null;
                            $count++;
                        }
                    ?>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<script>
    var togglePerm = function(role,perm)
    {
        var url = '/gerencial/roles/toggle/permission/'+role+'/'+perm;
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }
</script>
@endsection
