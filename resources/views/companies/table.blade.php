<table class="table table-bordered table-striped table-hover display nowrap">
    <thead>
        <th>Cod</th>
        <th>Fantasia</th>
        <th width="80px">Ativo</th>
        <th width="120px">Ação</th>
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
                <a href="{!! route('config.companies.show', [$company->id]) !!}"><i class="fa fa-cogs icon-rounded icon-xs icon-info"></i></a>
                <a href="{!! route('config.companies.edit', [$company->id]) !!}"><i class="fa fa-pencil icon-rounded icon-xs icon-warning"></i></a>
                <a href="{!! route('config.companies.delete', [$company->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"><i class="glyphicon glyphicon-remove icon-rounded icon-xs icon-danger"></i></a>
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
    var changeStatus = function(id){
        var url = '/config/companies/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }
</script>
