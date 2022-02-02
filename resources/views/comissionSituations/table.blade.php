<table class="table table-responsive" id="comissionSituations-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($comissionSituations as $comissionSituation)
        <tr>
            <td>{!! $comissionSituation->name !!}</td>
            <td>
                {!! Form::open(['route' => ['comissionSituations.destroy', $comissionSituation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('comissionSituations.show')<a @popper(Visualizar) href="{!! route('comissionSituations.show', [$comissionSituation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('comissionSituations.edit')<a @popper(Editar) href="{!! route('comissionSituations.edit', [$comissionSituation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('comissionSituations.delete')<a @popper(Deletar) </a>{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
