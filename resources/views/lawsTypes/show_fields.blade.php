    <style>
        #font-color{
            color: black;
        }
    </style>
    <div class="row mt-3" id="font-color">
        <!-- Id Field -->
        <div class="form-group">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $lawsType->id !!}</p>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            <p>{!! $lawsType->name !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Criado em:') !!}
            <p>{!! $lawsType->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Atualizado em:') !!}
            <p>{!! $lawsType->updated_at !!}</p>
        </div>
    </div>


