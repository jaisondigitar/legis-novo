    <style>
        #font-color{
            color: black;
        }
    </style>

    <div class="row mt-3" id="font-color">
        <!-- Id Field -->
        <div class="form-group">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $sessionType->id !!}</p>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            <p>{!! $sessionType->name !!}</p>
        </div>

        <!-- Slug Field -->
        <div class="form-group">
            {!! Form::label('slug', 'Sigla:') !!}
            <p>{!! $sessionType->slug !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Criado em:') !!}
            <p>{!! $sessionType->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Editado em:') !!}
            <p>{!! $sessionType->updated_at !!}</p>
        </div>
    </div>

