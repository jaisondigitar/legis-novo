<table class="table table-striped table-hover dataTable">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Fantasia</th>
            <th>Ativo</th>
            <th class="pull-right">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr>
                <td>#{!! str_pad($company->id, 4, "0", STR_PAD_LEFT) !!}</td>
                <td>{!! $company->shortName !!}</td>
                <td>
                    <div class="form-check form-switch form-switch-md">
                        <input
                            onchange="changeStatus('{!! $company->id !!}')"
                            id="active"
                            name="active"
                            class="form-check-input"
                            type="checkbox"
                            @if($company->active)
                            checked
                            @endif
                        >
                    </div>
                </td>
                <td>
                    <div class="pull-right">
                        <a @popper(Visualizar) href="{!! route('companies.show', [$company->id]) !!}"
                           class="btn btn-default btn-sm">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a @popper(Editar) href="{!! route('companies.edit', [$company->id]) !!}"
                           class="btn btn-default btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a
                            class="btn btn-danger btn-sm"
                            @popper(Deletar)
                            type="submit"
                            onclick="sweet(event, {!! $company->id !!})"
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
        const url = '/config/companies/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result) {
            console.log(result);
        });
    }
    const sweet = (e, id) => {
        const url = `companies/${id}`;

        const method = 'DELETE';

        sweetDelete(e, url, null, method);
    }
</script>
