<table class="table table-responsive" id="attendance-table">
    <thead>
        <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Setor</th>
            <th>Visitante</th>
            <th>Tipo de Atendimento</th>
            <th>Manutenção</th>
        </tr>
    </thead>
    <tbody>
    @foreach($attendance as $attend)
        <tr>
            <td>{!! $attend->date !!}</td>
            <td>{!! $attend->time !!}</td>
            <td>{!! $attend->sector->name !!}</td>
            <td>{!! $attend->people->name !!}</td>
            <td>{!! $attend->type->name !!}</td>
            <td>
                {!! Form::open(['route' => ['attendance.destroy', $attend->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('attendance.show')
                    <a href="{!! route('attendance.show', [$attend->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @endshield
                    @shield('attendance.edit')
                        <a href="{!! route('attendance.edit', [$attend->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    @endshield
                    @shield('attendance.delete')
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
