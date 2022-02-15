<table class="table table-bordered table-striped table-hover table-responsive datatable">
    <thead>
        <tr>
            <th>Slug</th>
            <th>Descrição</th>
            <th width="50px">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>{!! $permission->name !!}</td>
                <td>{!! $permission->readable_name !!}</td>
                <td>
                    @is('root')
                        <a @popper(Editar) href="{!! route('permissions.edit', [$permission->id]) !!}">
                            <i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i>
                        </a>
                    @endis
                    @is('root')
                        <a @popper(Deletar) href="{!! route('config.permissions.delete', [$permission->id]) !!}" onclick="return confirm('Deseja deletar este registro?')">
                            <i class="glyphicon glyphicon-remove icon-rounded icon-xs icon-danger"></i>
                        </a>
                    @endis
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
    const changeStatus = function(id){
        const url = '/permissions/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        })
    }
</script>
