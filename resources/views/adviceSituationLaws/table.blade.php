<table class="table table-striped table-hover" id="adviceSituationLaws-table">
    <thead>
        <th>Situação</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($adviceSituationLaws as $adviceSituationLaw)
        <tr>
            <td> {{$adviceSituationLaw->name}}</td>

            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['adviceSituationLaws.destroy', $adviceSituationLaw->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('adviceSituationLaws.show')<a @popper(Visualizar) href="{!! route('adviceSituationLaws.show', [$adviceSituationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('adviceSituationLaws.edit')<a @popper(Editar) href="{!! route('adviceSituationLaws.edit', [$adviceSituationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('adviceSituationLaws.delete')
                            <button
                                @popper(Deletar)
                                type = "submit"
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $adviceSituationLaw->id !!})"
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
        const url = `/adviceSituationLaws/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
