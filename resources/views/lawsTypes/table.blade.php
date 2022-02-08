<table class="table table-responsive" id="lawsTypes-table">
    <thead>
        <th>Name</th>
        <th>Ativo</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($lawsTypes as $lawsType)
        <tr>
            <td>{!! $lawsType->name !!}</td>
            <td>

                @is(['root', 'admin'])
                    <input class="switch" onchange="changeActive('{!! $lawsType->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal"  type="checkbox" {!! $lawsType->is_active > 0 ? 'checked' : '' !!}>
                @endis
                    {{--@if($lawsType->is_active == 1)--}}
                        {{--<label class="label label-success">Sim</label>--}}
                    {{--@else--}}
                        {{--<label class="label label-danger">Não</label>--}}
                    {{--@endif--}}

            </td>
            <td>
                {!! Form::open(['route' => ['lawsTypes.destroy', $lawsType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('lawsTypes.show')<a @popper(Visualizar) href="{!! route('lawsTypes.show', [$lawsType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('lawsTypes.edit')<a @popper(Editar) href="{!! route('lawsTypes.edit', [$lawsType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('lawsTypes.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    var changeActive = function(id){
        var url = '/lawsTypes-active/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result) {
        });
    };
</script>
