    <style>
        #font-color{
            color: black;
        }
    </style>
        <div class="row mt-3" id="font-color">
            <!-- Id Field -->
            <div class="form-group">
                {!! Form::label('id', 'Id:') !!}
                <p>{!! $documentSituation->id !!}</p>
            </div>

            <!-- Name Field -->
            <div class="form-group">
                {!! Form::label('name', 'Nome:') !!}
                <p>{!! $documentSituation->name !!}</p>
            </div>

            <!-- Active Field -->
            <div class="form-group">
                {!! Form::label('active', 'Ativo:') !!}
                <p>{!! $documentSituation->active !!}</p>
            </div>

            <!-- Created At Field -->
            <div class="form-group">
                {!! Form::label('created_at', 'Criado em:') !!}
                <p>{!! $documentSituation->created_at !!}</p>
            </div>

            <!-- Updated At Field -->
            <div class="form-group">
                {!! Form::label('updated_at', 'Atualizado em:') !!}
                <p>{!! $documentSituation->updated_at !!}</p>
            </div>

        </div>
