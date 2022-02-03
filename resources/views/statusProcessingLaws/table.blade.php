<table class="table table-responsive" id="statusProcessingLaws-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($statusProcessingLaws as $statusProcessingLaw)
        <tr>
            <td>{!! $statusProcessingLaw->name !!}</td>
            <td>
                {!! Form::open(['route' => ['statusProcessingLaws.destroy', $statusProcessingLaw->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('statusProcessingLaws.show')<a @popper(Visualizar) href="{!! route('statusProcessingLaws.show', [$statusProcessingLaw->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('statusProcessingLaws.edit')<a @popper(Editar) href="{!! route('statusProcessingLaws.edit', [$statusProcessingLaw->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('statusProcessingLaws.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
