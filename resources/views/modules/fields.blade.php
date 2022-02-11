<div class="row">
    {!! Form::token() !!}
    <div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>
    <!--- Name Field --->
    <div class="form-group col-sm-6 col-lg-4">
        {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!--- Token Field --->
    <div class="form-group col-sm-6 col-lg-4">
        {!! Form::label('token', 'Token:', ['class' => 'required']) !!}
        {!! Form::text('token', null, ['class' => 'form-control']) !!}
        <a href="#" onclick="createHash('{{ $module->name ?? time() }}');return false;"><span class="btn btn-info">Criar token</span></a>
    </div>

    <!--- Active Field --->
    <div class="form-group col-sm-6 col-lg-4">
        <label>
            Ativo
            <div class="form-check form-switch form-switch-lg">
                <input
                    id="active"
                    name="active"
                    class="form-check-input"
                    type="checkbox"
                    @if($module->active)
                        checked
                    @endif
                >
            </div>
        </label>
    </div>


    <!--- Submit Field --->
    <div class="form-group col-sm-12">
        {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
    </div>
</div>
