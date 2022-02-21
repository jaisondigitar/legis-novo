<table class="table table-bordered table-hover">
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
                    <a @popper(Editar) href="{!! route('modules.edit', [$module->id]) !!}"
                        class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i>

{{--                        <i class="fas fa-pencil-alt icon-rounded icon-xs icon-warning"></i>--}}
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
