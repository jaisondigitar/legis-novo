

    <style>
        #font-color{
            color: black;
        }
    </style>

    <div class="row mt-3" id="font-color">
        <!-- Id Field -->
        <div class="form-group">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $type_voting->id !!}</p>
        </div>

        <!-- Prefix Field -->
        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            <p>{!! $type_voting->name !!}</p>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('anonymous', 'Anônimo:') !!}
            <p>{!! $type_voting->anonymous !!}</p>
        </div>

        <!-- Active Field -->
        <div class="form-group">
            {!! Form::label('active', 'Ativo:') !!}
            <p>{!! $type_voting->active !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Criado em:') !!}
            <p>{!! $type_voting->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Atualizado em:') !!}
            <p>{!! $type_voting->updated_at !!}</p>
        </div>
    </div>

