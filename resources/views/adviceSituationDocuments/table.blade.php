<table class="table table-responsive" id="adviceSituationDocuments-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($adviceSituationDocuments as $adviceSituationDocuments)
        <tr>
            <td>{!! $adviceSituationDocuments->name !!}</td>
            <td>
                {!! Form::open(['route' => ['adviceSituationDocuments.destroy', $adviceSituationDocuments->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('adviceSituationDocuments.show')<a @popper(Visualizar) href="{!! route('adviceSituationDocuments.show', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>@endshield
                    @shield('adviceSituationDocuments.edit')<a @popper(Editar) href="{!! route('adviceSituationDocuments.edit', [$adviceSituationDocuments->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('adviceSituationDocuments.delete'){!! Form::button('<i @popper(Deletar) class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => 'sweetDelete(event)' ]) !!}@endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    const sweetDelete=(e) =>{
        e.preventDefault();
        Swal.fire({
            title: 'Excluir Documento?',
            text: "Não será possivel desfazer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `/adviceSituationDocuments/{{$adviceSituationDocuments->id}}`;

                const data = {
                    '_token' : '{{csrf_token()}}'
                };

                $.ajax({
                    url : url,
                    data : data,
                    method : 'POST'
                }).success(() => {
                    window.location.reload()
                });
            }
        })
    }
</script>
