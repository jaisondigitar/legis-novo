<table class="table table-striped table-hover" id="advicePublicationLaws-table">
    <thead>
        <th>Publicar em</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($advicePublicationLaws as $advicePublicationLaw)
        <tr>
            <td>{{$advicePublicationLaw->name}}</td>

            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['advicePublicationLaws.destroy', $advicePublicationLaw->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('advicePublicationLaws.show')<a @popper(Visualizar) href="{!! route('advicePublicationLaws.show', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('advicePublicationLaws.edit')<a @popper(Editar) href="{!! route('advicePublicationLaws.edit', [$advicePublicationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('advicePublicationLaws.delete')
                            <button
                                @popper(Deletar)
                                type = "submit"
                                onclick="sweet(event, {!! $advicePublicationLaw->id !!})"
                                class = 'btn btn-danger btn-sm'
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                            @endshield
                        </div>
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/advicePublicationLaws/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
