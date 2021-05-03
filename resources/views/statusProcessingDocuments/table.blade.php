<table class="table table-responsive" id="statusProcessingDocuments-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($statusProcessingDocuments as $statusProcessingDocument)
        <tr>
            <td>{!! $statusProcessingDocument->name !!}</td>
            <td>
                {!! Form::open(['route' => ['statusProcessingDocuments.destroy', $statusProcessingDocument->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('statusProcessingDocuments.show')<a href="{!! route('statusProcessingDocuments.show', [$statusProcessingDocument->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('statusProcessingDocuments.edit')<a href="{!! route('statusProcessingDocuments.edit', [$statusProcessingDocument->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('statusProcessingDocuments.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>