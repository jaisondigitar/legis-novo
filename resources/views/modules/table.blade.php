<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <th>Name</th>
        <th width="80px">Ativo</th>
        <th width="150px">Ação</th>
    </thead>
    <tbody>
    @foreach($modules as $module)
        <tr>
            <td>{!! $module->name !!}</td>
            <td>
                <input class="switch" onchange="changeStatus('{!! $module->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal"  type="checkbox" {!! $module->active>0?'checked':'' !!}>
            </td>
            <td>
                <a href="{!! route('modules.edit', [$module->id]) !!}"><i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i></a>
                <a href="{!! route('config.modules.delete', [$module->id]) !!}" onclick="return
                confirm('Deseja deletar este registro?')"><i class="glyphicon glyphicon-remove icon-rounded icon-xs icon-danger"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var changeStatus = function(id){
        var url = '/config/modules/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }
</script>
