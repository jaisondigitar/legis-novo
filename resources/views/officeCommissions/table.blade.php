<table class="table table-responsive" id="officeCommissions-table">
    <thead>
        <th>Nome</th>
        <th>Sigla</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($officeCommissions as $officeCommission)
        <tr>
            <td>{!! $officeCommission->name !!}</td>
            <td>{!! $officeCommission->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['officeCommissions.destroy', $officeCommission->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('officeCommissions.show')<a href="{!! route('officeCommissions.show', [$officeCommission->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('officeCommissions.edit')<a href="{!! route('officeCommissions.edit', [$officeCommission->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('officeCommissions.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>