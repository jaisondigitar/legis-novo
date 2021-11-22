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

    <h2>Permissões de <b>{{ strtoupper($roles->name) }}</b></h2>

    <div class="row">
        @foreach($list as $reg)
            <div class="col-md-4">
                <?php $count = 0; ?>
                @foreach($perms as $key=>$perm)
                    <?php
                        $check = '';
                        foreach ($roles->permissions as $key2=>$value2) {
                            if ($value2->name == $perm->name) {
                                $check = 'checked';
                            }
                        }

                        $tmp = explode('.', $perm->name);

                        if ($tmp[0] === $reg) {
                            if ($count === 0) {
                                echo '<ul class="list-group">';
                                echo '<li class="list-group-item active">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> '.strtoupper(substr($perm->readable_name, 6)).'
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
