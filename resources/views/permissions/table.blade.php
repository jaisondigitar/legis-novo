<table class="table table-bordered table-striped table-hover table-responsive datatable">
    <thead>
			<th>Slug</th>
			<th>Descrição</th>
        <th width="100px">Ação</th>
    </thead>
    <tbody>
    @foreach($permissions as $permission)

        <tr>
			<td>{!! $permission->name !!}</td>
			<td>{!! $permission->readable_name !!}</td>
            <td>
                @is('root')<a href="{!! route('config.permissions.edit', [$permission->id]) !!}"><i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i></a>@endis
                @is('root')<a href="{!! route('config.permissions.delete', [$permission->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"><i class="glyphicon glyphicon-remove icon-rounded icon-xs icon-danger"></i></a>@endis
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
    var changeStatus = function(id){
        var url = '/permissions/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }
</script>
