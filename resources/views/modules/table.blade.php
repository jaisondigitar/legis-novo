<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th>Name</th>
            <th width="80px">Ativo</th>
            <th width="90px">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($modules as $module)
            <tr>
                <td>{!! $module->name !!}</td>
                <td>
                    <label>
                        <input
                            class="switch"
                            onchange="changeStatus('{!! $module->id !!}')"
                            data-on-text="Sim"
                            data-off-text="Não"
                            data-off-color="danger"
                            data-on-color="success"
                            data-size="normal"
                            type="checkbox" {!! $module->active>0?'checked':'' !!}
                        >
                    </label>
                </td>
                <td>
                    <a @popper(Editar) href="{!! route('modules.edit', [$module->id]) !!}">
                        <i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i>
                    </a>
                    <a
                        class="pointer"
                        @popper(Deletar)
                        type="submit"
                        onclick="sweet(event, {!! $module->id !!})"
                    >
                        <i class="fa fa-remove icon-rounded icon-xs icon-danger"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    const changeStatus = function(id){
        const url = '/config/modules/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result) {
            console.log(result);
        });
    }

    const sweet = (e, id) => {
        const url = `/config/modules/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
