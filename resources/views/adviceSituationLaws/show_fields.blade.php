<style>
    #font-color {
        color: black;
    }
</style>
        <div class="row mt-3" id="font-color">
            <!-- Id Field -->
            <div class="form-group">
                {!! Form::label('id', 'Id:') !!}
                <p>{!! $adviceSituationLaw->id !!}</p>
            </div>

            <!-- Created At Field -->
            <div class="form-group">
                {!! Form::label('created_at', 'Criado em:') !!}
                <p>{!! $adviceSituationLaw->created_at !!}</p>
            </div>

            <!-- Updated At Field -->
            <div class="form-group">
                {!! Form::label('updated_at', 'Atualizado em:') !!}
                <p>{!! $adviceSituationLaw->updated_at !!}</p>
            </div>
        </div>


