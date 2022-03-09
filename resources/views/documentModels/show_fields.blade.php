    <style>
        #font-color{
            color: black;
        }
    </style>
    <div class="row mt-3" id="font-color">
        <!-- Id Field -->
        <div class="form-group">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $documentModels->id !!}</p>
        </div>

        <!-- Document Type Id Field -->
        <div class="form-group">
            {!! Form::label('document_type_id', 'Tipo Documento:') !!}
            <p>{!! $documentModels->document_type_id !!}</p>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            <p>{!! $documentModels->name !!}</p>
        </div>

        <!-- Content Field -->
        <div class="form-group">
            {!! Form::label('content', 'Conteúdo:') !!}
            <p>{!! $documentModels->content !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Criado em:') !!}
            <p>{!! $documentModels->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Editado em:') !!}
            <p>{!! $documentModels->updated_at !!}</p>
        </div>
    </div>


