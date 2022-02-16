<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <th>Id</th>
			<th>Name</th>
        <th width="80px">Ação</th>
    </thead>
    <tbody>
    @foreach($roles as $role)
        <tr>
            <td>{!! $role->id !!}</td>
			<td>{!! $role->name !!}</td>
            <td>
                @is('root')<a href="{!! route('gerencial.roles.edit', [$role->id]) !!}"><i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i></a>@endis
                @is('root')<a href="{!! route('gerencial.roles.delete', [$role->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"><i class="glyphicon glyphicon-remove icon-rounded icon-xs icon-danger"></i></a>@endis
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var changeStatus = function(id){
        var url = '/roles/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        })
    }
</script>
