<table class="table table-striped table-hover dataTable">
    <thead>
        <tr>
            <th>Slug</th>
            <th>Descrição</th>
            <th class="pull-right">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>{!! $permission->name !!}</td>
                <td>{!! $permission->readable_name !!}</td>
                <td>
                    <div class="pull-right">
                        @is('root')
                            <a @popper(Editar) href="{!! route('permissions.edit', [$permission->id]) !!}"
                                class="btn btn-default btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endis
                        @is('root')
                            <a
                                class = "btn btn-danger btn-sm"
                                @popper(Deletar)
                                onclick="sweet(event, {!! $permission->id !!})"
                            >
                                <i class="fa fa-trash"></i>
                            </a>
                        @endis
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    const changeStatus = function(id){
        const url = '/permissions/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result) {
            console.log(result);
        });
    }
</script>
<script>
    const sweet = (e, id) => {
        const url = `/config/permissions/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
