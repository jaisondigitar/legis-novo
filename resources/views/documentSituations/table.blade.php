<table class="table table-striped table-hover" id="documentSituations-table">
    <thead>
        <th>Nome</th>
        <th>Ativo</th>
        <th class="pull-right">Manutenção</th>
    </thead>
    <tbody>
    @foreach($documentSituations as $documentSituation)
        <tr>
            <td>{!! $documentSituation->name !!}</td>
                <td>
                    <div class="form-check form-switch form-switch-md">
                        <input
                            onchange="statusActive({{ $documentSituation }})"
                            id="active"
                            name="active"
                            class="form-check-input"
                            type="checkbox"
                            @if(isset($documentSituation->active) ? $documentSituation->active == 1:false)
                            checked
                            @endif
                        >
                    </div>
                </td>
            <td>
                <div class="pull-right">
                    {!! Form::open(['route' => ['documentSituations.destroy', $documentSituation->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @shield('documentSituations.show')<a @popper(Visualizar) href="{!! route('documentSituations.show', [$documentSituation->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-eye"></i></a>@endshield
                            @shield('documentSituations.edit')<a @popper(Editar) href="{!! route('documentSituations.edit', [$documentSituation->id]) !!}" class='btn btn-default btn-sm'><i class="fa fa-edit"></i></a>@endshield
                            @shield('documentSituations.delete')
                               <button
                                   @popper(Deletar)
                                   type='submit'
                                   class='btn btn-danger btn-sm'
                                   onclick="sweet(event, {!! $documentSituation->id !!})"
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
        const url = `/documentSituations/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
    const statusActive = (documentSituation) => {
        const url = `/documentSituations/${documentSituation.id}/toggle`;

        $.ajax({
            url: url,
        }).success(() => {
            toastr.success("Status do documento alterado com sucesso");
        });
    }
</script>
