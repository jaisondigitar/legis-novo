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
                    @shield('advicePublicationLaws.show')<a @popper(Visualizar) href="{!! route('advicePublicationLaws.show', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('advicePublicationLaws.edit')<a @popper(Editar) href="{!! route('advicePublicationLaws.edit', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('advicePublicationLaws.delete')
                    <button
                        @popper(Deletar)
                        type = "submit"
                        onclick="sweet(event, {!! $advicePublicationLaw->id !!})"
                        class = 'btn btn-danger btn-xs'
                    >
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/advicePublicationLaws/${id}`;

        const data = null

        const method = 'DELETE'

        sweetDelete(e, url, data, method)
    }
</script>
