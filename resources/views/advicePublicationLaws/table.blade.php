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
                    @shield('advicePublicationLaws.show')<a @popper(Visualizar) href="{!! route('advicePublicationLaws.show', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('advicePublicationLaws.edit')<a @popper(Editar) href="{!! route('advicePublicationLaws.edit', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('advicePublicationLaws.delete') <button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
