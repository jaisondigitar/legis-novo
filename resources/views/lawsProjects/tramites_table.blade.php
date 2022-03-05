<table class="table table-responsive" id="lawsProjects-table">
    <thead>
    <th>DATA</th>
    <th>PARA</th>
    <th>SITUAÇÃO</th>
    <th>TIPO</th>
    <th>AÇÕES</th>
    </thead>
    <tbody id="adviceTable">
        @foreach($lawsProject->advices as $advice)
            <tr id="linha_{{$advice->id}}">
                <td>{{ $advice->date }}</td>
                <td>{{ $advice->destination->name }}</td>
                <td>{{ $advice->situation->last()->situation->name ?? null}}</td>
                <td>{{$advice->advice_id ? 'Réplica' : ''}}</td>
                <td>
                    <div class="btn-group">
                        <a href="/advice/findAwnser/{{$advice->id}}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> </a>
                        @if(($advice->situation->last()->situation->name ?? null) == 'Contrário' && \App\Models\Advice::query()->where('advice_id', $advice->id)->doesntExist())
                            <button id="advice_awnser_{{$advice->id}}" type="button" class="btn btn-success btn-xs " data-toggle="modal" data-target="#myModal1" data = "{{$advice->id}}"><i class="fa fa-pencil-square-o"></i></button>
                        @endif
                        <button class="btn btn-xs btn-danger" onclick="remove_advice({{ $advice->id }})"><i class="fa fa-trash"></i> </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{--modal1  detalhes--}}
<!-- Large modal -->
<div class="container">
    <!-- Modal -->
    <div class="modal fade " id="myModal1" role="dialog">
        <div class="modal-dialog  modal-lg">
            <!-- Modal content-->
            <form action="/advice/replica" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Informar réplica</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">

                            <input type="text" class="form-control hidden"  name="id" value="{{$advice->id}}"/>
                            <input type="text" class="form-control hidden"  name="to_id[]" value="{{$advice->to_id}}"/>
                            <input type="text" class="form-control hidden"  name="type" value="{{$advice->type}}"/>
                            <input type="text" class="form-control hidden"  name="laws_projects_id" value="{{$advice->laws_projects_id}}"/>
                            <input type="text" class="form-control hidden"  name="document_id" value="{{$advice->document_id}}"/>

                            <div class="col-md-3">
                                <label> Data: </label>
                                <input type="text" class="form-control" name="date" id="dateP" autocomplete="off"/>
                            </div>

                            <!-- Date Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::label('descriptionP', 'Descrição:') !!}
                                <textarea name="description" id="description" class="form-control ckeditor" cols="30" rows="10"></textarea>
                            </div>


                            <!-- Date Field -->
                            <div class="form-group col-sm-12">

                                <div class="col-md-4">
                                    {!! Form::label('fileP', 'Arquivo:') !!}
                                    <input type="file" name="file" id="file"><br>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-6">
                                    <img id="imgP" src="" alt="" width="200"/>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- fim do modal --}}
<!-- Large modal -->

{{-- fim do modal --}}
<script>

    $(document).ready(function () {

        $('#dateP').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            autoclose: true
        });

        $('#dateP').on('blur', function() {
            var dateP = $('#dateP').val();
            if (dateP.trim()) {
                var date = dateP.split('/');
                dia = date[1];
                mes = date[0];
                ano = date[2];
                dateP = dia + '/' + mes + '/' + ano;
                $('#dateP').val(dateP);
            }
        });

    });

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

        });
    }

</script>
