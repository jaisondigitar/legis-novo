<table class="table table-responsive" id="commissions-table">
    <thead>
        <th>Data início</th>
        <th>Data término</th>
        <th>Nome</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($commissions as $commission)
        <tr>
            <td>{!! $commission->date_start !!}</td>
            <td>{!! $commission->date_end !!}</td>
            <td>{!! $commission->name !!}</td>
            <td>
                {!! Form::open(['route' => ['commissions.destroy', $commission->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('commissions.show')<a href="{!! route('commissions.show', [$commission->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('commissions.edit')<a href="{!! route('commissions.edit', [$commission->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('commissions.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>