<table class="table table-responsive" id="lawsProjects-table">
    <thead>
    <th>DATA</th>
    <th>PARA</th>
    <th>SITUAÇÃO</th>
    <th>AÇÕES</th>
    </thead>
    <tbody id="adviceTable">
        @foreach($lawsProject->advices as $advice)
            <tr id="linha_{{$advice->id}}">
                <td>{{ $advice->date }}</td>
                <td>{{ $advice->destination->name }}</td>
                <td>{{ $advice->situation->last()->situation->name }}</td>
                <td>
                    <div class="btn-group">
                        <a href="/advice/findAwnser/{{$advice->id}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> </a>
                        <button class="btn btn-xs btn-danger" onclick="remove_advice({{ $advice->id }})"><i class="fa fa-trash"></i> </button>
                        @if($advice->situation->last()->situation->name === 'Contrário' || Auth::user()->hasRole('root'))
                            <button
                                type="button"
                                class="btn btn-default btn-xs"
                                data-toggle="modal"
                                data-target="#modalRessources"
                            >
                                <i
                                    class=" fa fa-cog"
                                ></i>
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
            @include('lawsProjects.modal_legal_opinion')
        @endforeach
    </tbody>
</table>

<script>
    var remove_advice = function(id){

        url = '/advice/delete';

        data = {
            id : id,
            _token : '{{ csrf_token() }}'
        };

        $.ajax({
            url : url,
            data : data,
            method : 'POST'
        }).success(function(data){

            data = JSON.parse(data);

            if(data){
                $('#linha_' + data).fadeOut();
                toastr.success("Parecer removido com sucesso!");
            }else{
                toastr.error("Erro, pode esta vinculado a uma pauta!");
            }

            console.log(data);

        });
    }
</script>
