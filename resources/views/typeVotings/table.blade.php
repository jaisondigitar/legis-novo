<table class="table table-responsive" id="types-table">
    <thead>
        <th>Nome</th>
        <th>Anônimo</th>
        <th>Ativo</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($type_voting as $type)
        <tr>
            <td>{!! $type->name !!}</td>
            <td>
                <div class="form-check form-switch form-switch-md">
                    <input
                        onchange="statusActive({{ $type }})"
                        id="anonymous"
                        name="anonymous"
                        class="form-check-input"
                        type="checkbox"
                        @if(isset($type->anonymous) ? $type->anonymous == 1:false)
                        checked
                        @endif
                    >
                </div>
            </td>
            <td>
                <div class="form-check form-switch form-switch-md">
                    <input
                        onchange="statusActive({{ $type }})"
                        id="active"
                        name="active"
                        class="form-check-input"
                        type="checkbox"
                        @if(isset($type->active) ? $type->active == 1:false)
                        checked
                        @endif
                    >
                </div>
            </td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['typeVotings.destroy', $type->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('typeVotings.show')<a @popper(Visualizar) href="{!! route('typeVotings.show', [$type->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('typeVotings.edit')<a @popper(Editar) href="{!! route('typeVotings.edit', [$type->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('typeVotings.delete')
                            <button
                                @popper(Deletar)
                                type = 'submit'
                                class = 'btn btn-danger btn-sm'
                                onclick="sweet(event, {!! $type->id !!})"
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
        const url = `/typeVotings/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
    const statusActive = (typeVotings) => {
        console.log(typeVotings)
        const url = `/typeVotings/${typeVotings.id}`;

        $.ajax({
            url: url,
        }).success(() => {
            toastr.success("Status do tipo de documento alterado com sucesso");
        });
    }
</script>
