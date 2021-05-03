<table class="table table-responsive" id="lawsProjects-table">
    <thead>
    <th>DATA</th>
    <th>PARA</th>
    <th>SITUAÇÃO</th>
    <th>AÇÕES</th>
    </thead>
    <tbody id="adviceTable">

    {{--@if($lawsProject->advices)--}}
        @foreach($document->advices as $advice)
            <tr id="linha_{{$advice->id}}">
                <td>{{ $advice->date }}</td>
                <td>{{ $advice->destination->name }}</td>
                <td>{{ $advice->situation->last()->situation->name }}</td>
                <td>
                    <div class="btn-group">
                        {{--<button class="btn btn-xs btn-info">PDF</button>--}}
                        {{--<button class="btn btn-xs btn-default"><i class="fa fa-paperclip"></i> </button>--}}
                        {{--<button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> </button>--}}
                        <a href="/advice/findAwnser/{{$advice->id}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> </a>
                        <button class="btn btn-xs btn-danger" onclick="remove_advice({{ $advice->id }})"><i class="fa fa-trash"></i> </button>

                    </div>
                </td>
            </tr>
        @endforeach
    {{--@endif--}}
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
                toastr.error("Erro ao excluir parecer!");
            }

            console.log(data);

        });
    }
</script>
