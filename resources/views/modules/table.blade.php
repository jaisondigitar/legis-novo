<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th width="1rem">Ativo</th>
            <th class="pull-right">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($modules as $module)
            <tr>
                <td>{!! $module->name !!}</td>
                <td>
                    <label class="pull-right">
                        <div class="form-check form-switch form-switch-md">
                            <input
                                onchange="changeStatus('{!! $module->id !!}')"
                                id="active"
                                name="active"
                                class="form-check-input"
                                type="checkbox"
                                @if($module->active)
                                checked
                                @endif
                            >
                        </div>
                    </label>
                </td>
                <td>
                    <div class="pull-right">
                        <a @popper(Editar) href="{!! route('modules.edit', [$module->id]) !!}"
                            class='btn btn-default btn-sm'><i class="fa fa-edit"></i>
                        </a>
                        <a
                            class = "btn btn-danger btn-sm"
                            @popper(Deletar)
                            type="submit"
                            onclick="sweet(event, {!! $module->id !!})"
                        >
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
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
