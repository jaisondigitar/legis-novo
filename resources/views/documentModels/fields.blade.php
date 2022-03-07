<style>
    .form-group > input{
        border-radius: 5px; !important;
    }

    .form-group > select{
        border-radius: 5px; !important;
    }

</style>
        <div class="row">
        <!-- Document Type Id Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('document_type_id', 'Tipo de Documento' , ['class' => 'required']) !!}
            {!! Form::select('document_type_id', $document_type, null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group col-sm-9">
            {!! Form::label('name', 'Nome:' , ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="col-sm-12 mt-3">
            <p>Variáveis disponiveis:<br><small>Clique para adicionar automaticamente</small></p>
            <p>
            <ul style="border-radius: 10px">
                <div style="text-align: center">
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[numero]')">Numero</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[numero_documento]')">Numero documento</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[ano_documento]')">Ano documento</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[tipo_documento]')">Tipo documento</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[data_curta]')">Data curta</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[data_longa]')">Data longa</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[responsavel]')">Responsavel</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[protocolo_numero]')">Protocolo numero</li>
                </div>
                <div style="text-align: center" class="mt-3">
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[protocolo_data]')">Protocolo data</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[protocolo_hora]')">Protocolo hora</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[numero_interno]')">Numero interno</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[responsavel]')">Responsavel</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[autores]')">Autores</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[autores_vereador]')">Autores vereador</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[conteudo]')">Conteudo</li>
                    <li class="btn btn-default btn-sm mx-1" onclick="InsertText('[nome_vereadores]')">Nome vereadores</li>
                </div>
            </ul>
            </p>
        </div>
        <!-- Content Field -->
        <div class="form-group col-sm-12 mb-3">
            {!! Form::label('content', 'Conteúdo:' , ['class' => 'required']) !!}
            {!! Form::textarea('content', null, ['class' => 'form-control ckeditor']) !!}
        </div>

        <!-- Content Field -->
        <div class="form-group col-sm-12 mb-1">
            {!! Form::label('text_initial', 'Texto Inicial:' , ['class' => 'required']) !!}
            {!! Form::textarea('text_initial', null, ['class' => 'form-control ckeditor']) !!}
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('documentModels.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
<script>
    function InsertText(str) {
        var editor = CKEDITOR.instances.content;
        editor.insertText( str );
    }
</script>
