<table class="table table-responsive" id="documentTypes-table">
    <thead>
        <th>Nome</th>
        <th>Prefixo</th>
        <th>Sigla</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($documentTypes as $documentType)
        <tr>
            <td>{!! $documentType->name !!}</td>
            <td>{!! $documentType->prefix !!}</td>
            <td>{!! $documentType->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['documentTypes.destroy', $documentType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('documentTypes.show')<a @popper(Visualizar) href="{!! route('documentTypes.show', [$documentType->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('documentTypes.edit')<a @popper(Editar) href="{!! route('documentTypes.edit', [$documentType->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                    @shield('documentTypes.delete')
                        <button
                            @popper(Deletar)
                            type='submit'
                            class='btn btn-danger btn-xs'
                            onclick="sweet(event, {!! $documentType->id !!})"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @foreach($documentType->childs as $doc)
            <tr>
                <td><span class="text-muted">{!! $documentType->name !!} <i class="fa fa-arrow-circle-right"></i> </span> {!! $doc->name !!}</td>
                <td>{!! $doc->prefix !!}</td>
                <td>{!! $doc->slug !!}</td>
                <td>
                    <div class='btn-group'>
                        @shield('documentTypes.show')<a @popper(Visualizar) href="{!! route('documentTypes.show', [$doc->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                        @shield('documentTypes.edit')<a @popper(Editar) href="{!! route('documentTypes.edit', [$doc->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-edit"></i></a>@endshield
                        @shield('documentTypes.delete')
                            <button
                                @popper(Deletar)
                                type='submit'
                                class='btn btn-danger btn-xs'
                                onclick="sweet(event, {!! $doc->id !!})"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                        @endshield
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
<script>
    const sweet = (e, id) => {
        const url = `/documentTypes/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>
