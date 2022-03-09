    <style>
        #font-color{
            color: black;
        }
    </style>
    <div class="row" id="font-color">
        <!-- Id Field -->
        <div class="form-group mt-3">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $adviceSituationDocuments->id !!}</p>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            <p>{!! $adviceSituationDocuments->name !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Criado em:') !!}
            <p>{!! $adviceSituationDocuments->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Atualizado em:') !!}
            <p>{!! $adviceSituationDocuments->updated_at !!}</p>
        </div>
    </div>


