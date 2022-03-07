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

        <div class="col-sm-8 mt-3">
            <p>Variáveis disponiveis:<br><small>Clique para adicionar automaticamente</small></p>
            <p>
            <ul>
                <li class="btn" onclick="InsertText('[numero]')">[numero]</li>
                <li class="btn" onclick="InsertText('[numero_documento]')">[numero_documento]</li>
                <li class="btn" onclick="InsertText('[ano_documento]')">[ano_documento]</li>
                <li class="btn" onclick="InsertText('[tipo_documento]')">[tipo_documento]</li>
                <li class="btn" onclick="InsertText('[data_curta]')">[data_curta]</li>
                <li class="btn" onclick="InsertText('[data_longa]')">[data_longa]</li>
                <li class="btn" onclick="InsertText('[responsavel]')">[responsavel]</li>
                <li class="btn" onclick="InsertText('[protocolo_numero]')">[protocolo_numero]</li>
                <li class="btn" onclick="InsertText('[protocolo_data]')">[protocolo_data]</li>
                <li class="btn" onclick="InsertText('[protocolo_hora]')">[protocolo_hora]</li>
                <li class="btn" onclick="InsertText('[numero_interno]')">[numero_interno]</li>
                <li class="btn" onclick="InsertText('[responsavel]')">[responsavel]</li>
                <li class="btn" onclick="InsertText('[autores]')">[autores]</li>
                <li class="btn" onclick="InsertText('[autores_vereador]')">[autores_vereador]</li>
                <li class="btn" onclick="InsertText('[conteudo]')">[conteudo]</li>
                <li class="btn" onclick="InsertText('[nome_vereadores]')">[nome_vereadores]</li>
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
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('documentModels.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
<script>
    function InsertText(str) {
        var editor = CKEDITOR.instances.content;
        editor.insertText( str );
    }
</script>
