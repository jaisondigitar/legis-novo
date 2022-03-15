<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <th>Code</th>
			<th>State</th>
			<th>Name</th>
        <th width="100px">Ação</th>
    </thead>
    <tbody>
    @foreach($cities as $city)
        <tr>
            <td>{!! $city->code !!}</td>
			<td>{!! $city->state !!}</td>
			<td>{!! $city->name !!}</td>
            <td>
                <a href="{!! route('cities.edit', [$city->id]) !!}"><i class="fa fa-edit icon-rounded icon-xs icon-warning"></i></a>
                <a href="{!! route('cities.delete', [$city->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"><i class="fa fa-remove icon-rounded icon-xs icon-danger"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var changeStatus = function(id){
        var url = '/cities/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }
</script>
