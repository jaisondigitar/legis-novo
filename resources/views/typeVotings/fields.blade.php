    <div class="row">
        <!-- Prefix Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="clearfix"></div>
        <!-- anonimo Field -->
        <div class="form-group col-sm-3 mt-3">
            {!! Form::label('anonymous', 'Anônimo:') !!}
            <div class="form-check form-switch form-switch-md">
                <input
                    id="anonymous"
                    name="anonymous"
                    class="form-check-input"
                    type="checkbox"
                    @if(isset($type_voting->anonymous) ? $type_voting->anonymous == 1:false)
                    checked
                    @endif
                >
            </div>
        </div>

        <!-- Active Field -->
        <div class="form-group col-sm-3 mt-3">
            {!! Form::label('active', 'Ativo:') !!}
            <div class="form-check form-switch form-switch-md">
                <input
                    id="active"
                    name="active"
                    class="form-check-input"
                    type="checkbox"
                    @if(isset($type_voting->active) ? $type_voting->active == 1:false)
                    checked
                    @endif
                >
            </div>
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
            <a href="{!! route('typeVotings.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
