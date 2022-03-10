    <style>
        #font-color{
            color: black;
        }
    </style>
        <div class="row mt-3" id="font-color">
            <!-- Id Field -->
            <div class="form-group">
                {!! Form::label('id', 'Id:') !!}
                <p>{!! $responsibility->id !!}</p>
            </div>

            <!-- Companies Id Field -->
            <div class="form-group">
                {!! Form::label('companies_id', 'Companhia:') !!}
                <p>{!! $responsibility->companies_id !!}</p>
            </div>

            <!-- Name Field -->
            <div class="form-group">
                {!! Form::label('name', 'Nome:') !!}
                <p>{!! $responsibility->name !!}</p>
            </div>

            <!-- Created At Field -->
            <div class="form-group">
                {!! Form::label('created_at', 'Criado em:') !!}
                <p>{!! $responsibility->created_at !!}</p>
            </div>

            <!-- Updated At Field -->
            <div class="form-group">
                {!! Form::label('updated_at', 'Atualizado em:') !!}
                <p>{!! $responsibility->updated_at !!}</p>
            </div>
        </div>

