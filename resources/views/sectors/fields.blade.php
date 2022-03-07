   <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- External Field -->
       <div  class="col-sm-6 form-group form-check form-switch form-switch-md">
           <span>Externo</span><br>
           <input
               style="margin: 0.5rem 0 0 0"
               name="active"
               class="form-check-input"
               type="checkbox"
               @if(isset($sector->external))
                   {!! 'checked' !!}
               @endif
           >
       </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-3">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('sectors.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
   </div>
