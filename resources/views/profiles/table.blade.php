<table class="table table-bordered table-striped table-hover table-responsive">
    <thead>
        <th>User Id</th>
			<th>Image</th>
			<th>Fullname</th>
			<th>About</th>
			<th>Facebook</th>
			<th>Twitter</th>
			<th>Linkedin</th>
			<th>Instagram</th>
			<th>City</th>
			<th>State</th>
			<th>Active</th>
        <th width="80px">Ativo</th>
        <th width="80px">Ação</th>
    </thead>
    <tbody>
    @foreach($profiles as $profile)
        <tr>
            <td>{!! $profile->user_id !!}</td>
			<td>{!! $profile->image !!}</td>
			<td>{!! $profile->fullName !!}</td>
			<td>{!! $profile->about !!}</td>
			<td>{!! $profile->facebook !!}</td>
			<td>{!! $profile->twitter !!}</td>
			<td>{!! $profile->linkedin !!}</td>
			<td>{!! $profile->instagram !!}</td>
			<td>{!! $profile->city !!}</td>
			<td>{!! $profile->state !!}</td>
			<td>{!! $profile->active !!}</td>
            <td>
                <input class="switch" onchange="changeStatus('{!! $profile->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal"  type="checkbox" {!! $profile->active>0?'checked':'' !!}>
            </td>
            <td>
                <a href="{!! route('profiles.edit', [$profile->id]) !!}"><i class="fa fa-edit icon-rounded icon-xs icon-warning"></i></a>
                <a href="{!! route('profiles.delete', [$profile->id]) !!}" onclick="return confirm('Deseja deletar este registro?')"><i class="fa fa-remove icon-rounded icon-xs icon-danger"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var changeStatus = function(id){
        var url = '/profiles/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }
</script>
