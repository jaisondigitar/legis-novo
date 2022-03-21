<style>
    .resume {
        height: 10vh;
        max-height: 10vh;
        max-width: 100%;
        min-width: 100%;
    }
</style>

<!-- Document Type Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('document_type_id', 'Tipo de documento', ['class' => 'required']) !!}
    {!! Form::select('document_type_id', $documentType, null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('owner_id', 'Parlamentar responsável', ['class' => 'required']) !!}
    {!! Form::select('owner_id', $assemblymensList, null, ['class' => 'form-control']) !!}
</div>

<!-- From Field -->
<div class="form-group col-sm-4">
    {!! Form::label('date', 'Data', ['class' => 'required']) !!}
    {!! Form::text('date', null, ['class' => 'form-control datepicker', 'minlength' => '10']) !!}
</div>

<!-- Sector Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sectors[]', 'Destinatário Final') !!}
    <select class="js-example-basic-multiple col-sm-12" name="sectors[]" multiple="multiple">
        @foreach($sector as $key => $name)
            @if(in_array($key, $sectors_default))
                <option value="{{ $key }}" selected>{{$name}}</option>
            @else
                <option value="{{ $key }}">{{$name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Resume Field -->
<div class="form-group col-sm-12">
    {!! Form::label('resume', 'Ementa', ['class' => 'required']) !!}
    {!! Form::textarea('resume', null, [
            'class' => 'form-control resume ckeditor',
            'maxlength' => 680
    ]) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-12">
    {!! Form::label('content', 'Conteúdo', ['class' => 'required']) !!}
    {!! Form::textarea('content', null, ['class' => 'form-control ckeditor']) !!}
</div>

<!-- Assemblymen Field -->
<div class="form-group col-sm-12">
    {!! Form::label('assemblymen', 'Parlamentares Assinando') !!}
    {!! Form::select('assemblymen[]', $assemblymen, null, ['class' => 'chosen-select', 'multiple', 'style' => 'width:100%;', 'data-placeholder' => 'Selecione o parlamentar...']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('documents.index') !!}" class="btn btn-default">Cancelar</a>
</div>
<style href="{{ url('assets/plugins/chosen/chosen.min.css') }}"></style>
<script src="{{ url('assets/plugins/chosen/chosen.jquery.min.js') }}"></script>

@if(!isset($document))

    <script>
        $(document).ready(function(){

            $('#document_type_id').on('change', function(){

                id = $("#document_type_id").val();
                url = '/documents/findTextInitial';
                data = {
                    'id'  : id,
                    '_token' : '{{csrf_token()}}'
                };

                $.ajax({
                    url : url,
                    data : data,
                    method : 'POST'
                }).success(function(data){

                    data = JSON.parse(data);
                    var editor = CKEDITOR.instances.content;
                    editor.insertText( data.text_initial );

                });
            });
        });
    </script>

@endif

<style>
    .select2.select2-container .select2-selection {
        border: 1px solid #ddd;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        height: 34px;
        margin-bottom: 15px;
        outline: none !important;
        transition: all .15s ease-in-out;
    }
</style>

<script type="text/javascript">
    document.querySelector('#date').value = dateForm

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    $(document).ready(function () {

        var oldValue;

        if($('#owner_id').val() > 0){
            var assemblyman = $("#owner_id option:selected").text();
            $("select.chosen-select option:contains('" + assemblyman + "')").hide();
            if(oldValue){
                $("select.chosen-select option:contains('" + oldValue + "')").show();
            }
            $(".chosen-select").trigger('chosen:updated');
            oldValue = assemblyman;
        }

        $('#owner_id').on('change', function () {
            var assemblyman = $("#owner_id option:selected").text();
            $("select.chosen-select option:contains('" + assemblyman + "')").hide();
            if(oldValue){
                $("select.chosen-select option:contains('" + oldValue + "')").show();
            }
            $(".chosen-select").trigger('chosen:updated');
            oldValue = assemblyman;
        });

        $(".chosen-select").chosen();

        @if(isset($documentAssemblyman))
            $(".chosen-select").val({!! (isset($documentAssemblyman) ? $documentAssemblyman : '') !!}).trigger('chosen:updated');
        @endif
    });
</script>

<script>
    var save_processing = function() {

        url = '{{route('processingDocuments.store')}}';

        if ($('#new_document_situation_id').val() == 0) {
            toastr.error('Selecione uma situação para tramitação!')
        } else {
            if ($('#new_status_processing_document_id').val() == 0) {
                toastr.error('Selecione um status para tramitação!');
            }
            else {
                if ($('#new_processing_document_date').val() == '') {
                    toastr.error('Selecione uma data para tramitação!');
                }
                else {
                    data = {
                        document_id: '{{ $document->id }}',
                        document_situation_id: $('#new_document_situation_id').val(),
                        status_processing_document_id: $('#new_status_processing_document_id').val(),
                        processing_document_date: $('#new_processing_document_date').val(),
                        observation: CKEDITOR.instances.new_document_observation.getData()
                    };

                    $.ajax({
                        url: url,
                        data: data,
                        method: 'post'
                    }).success(function (data) {

                        data = JSON.parse(data);

                        table = $('#table_processing').empty();

                        data.forEach(function (valor, chave) {
                            str = '<tr id="line_' + valor.id + '"> ';
                            str += "<td>";
                            str += valor.document_situation.name;
                            str += "</td>";
                            str += "<td>";
                            if(valor.status_processing_document_id > 0) {
                            str += valor.status_processing_document.name;
                            }
                            str += "</td>";
                            str += "<td>";
                            str += valor.processing_document_date;
                            str += "</td>";
                            str += "<td>";
                            str += valor.observation;
                            str += "</td>";
                            str += "<td>";
                            str += '<button type="button" class="btn btn-danger btn-xs" onclick="delete_processing(' + valor.id + ')"> <i class="fa fa-trash"></i> </button>';
                            str += "</td>";
                            str += "</tr>";
                            table.append(str);
                        });

                        toastr.success('Tramitação salva com sucesso!');

                        $('#new_document_situation_id').val(0);
                        $('#new_status_processing_document_id').val(0);
                        $('#new_processing_document_date').val('');
                        CKEDITOR.instances.new_document_observation.setData('');
                    });
                }
            }
        }
    }


    var delete_processing = function(id){

        if(confirm('Deseja excluir?')) {

            url = '/processingDocuments/' + id;

            $.ajax({
                url: url,
                method: 'DELETE'
            }).success(function (data) {

                data = JSON.parse(data);

                $('#line_' + id).fadeOut();
                toastr.success('Tramitação excluída com sucesso!');

            });
        }
    }

</script>
