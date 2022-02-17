<table class="table table-responsive" id="adviceSituationLaws-table">
    <thead>
        <th>Situação</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($adviceSituationLaws as $adviceSituationLaw)
        <tr>
            <td> {{$adviceSituationLaw->name}}</td>

            <td>
                {!! Form::open(['route' => ['adviceSituationLaws.destroy', $adviceSituationLaw->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('adviceSituationLaws.show')<a @popper(Visualizar) href="{!! route('adviceSituationLaws.show', [$adviceSituationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>@endshield
                    @shield('adviceSituationLaws.edit')<a @popper(Editar) href="{!! route('adviceSituationLaws.edit', [$adviceSituationLaw->id]) !!}" class='btn btn-default btn-sm'><i class="fas fa-pencil-alt"></i></a>@endshield
                    @shield('adviceSituationLaws.delete')<button @popper(Deletar) type = 'submit' class = 'btn btn-danger btn-sm' onclick = "return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
