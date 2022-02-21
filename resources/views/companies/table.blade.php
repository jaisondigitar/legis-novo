<table class="table table-bordered table-striped table-hover display nowrap">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Fantasia</th>
            <th width="80px">Ativo</th>
            <th width="80px">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr>
                <td>#{!! str_pad($company->id, 4, "0", STR_PAD_LEFT) !!}</td>
                <td>{!! $company->shortName !!}</td>
                <td>
                    <input class="switch" onchange="changeStatus('{!! $company->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal" type="checkbox" {!! $company->active>0?'checked':'' !!}>
                </td>
                <td>
                    <a @popper(Visualizar) href="{!! route('companies.show', [$company->id]) !!}"
                        class="btn btn-default btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a @popper(Editar) href="{!! route('companies.edit', [$company->id]) !!}"
                        class="btn btn-default btn-sm">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a
                        class="pointer"
                        @popper(Deletar)
                        type="submit"
                        onclick="sweet(event, {!! $company->id !!})"
                    >
                        <i class="fa fa-trash icon-rounded icon-xs icon-danger"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.table').DataTable( {
            "scrollX": true
        } );
    } );
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
</script>
<script>
    const sweet = (e, id) => {
        const url = `companies/${id}`;

        const method = 'DELETE';

        sweetDelete(e, url, null, method);
    }
</script>
