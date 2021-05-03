<table class="table table-responsive" id="advicePublicationLaws-table">
    <thead>
        <th>Publicar em</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($advicePublicationLaws as $advicePublicationLaw)
        <tr>
            <td>{{$advicePublicationLaw->name}}</td>

            <td>
                {!! Form::open(['route' => ['advicePublicationLaws.destroy', $advicePublicationLaw->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('advicePublicationLaws.show')<a href="{!! route('advicePublicationLaws.show', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('advicePublicationLaws.edit')<a href="{!! route('advicePublicationLaws.edit', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('advicePublicationLaws.delete'){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>