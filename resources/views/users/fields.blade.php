{!! Form::token() !!}
<div class="row">
    <div class="form-group col-sm-12"><h3>Cadastro</h3><hr></div>
    <!--- Id Field --->
    <div class="form-group col-sm-6 col-lg-4" style="display: none;">
        {!! Form::label('id', 'Id:') !!}
        {!! Form::number('id', null, ['class' => 'form-control']) !!}
    </div>

    <!--- Institute Id Field --->
    <div class="form-group col-sm-6 col-lg-4" style="display: none;">
        {!! Form::label('company_id', 'Company:') !!}
        {!! Form::number('company_id', Auth::user()->company->id, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-6 col-lg-6 mb-1">
        {!! Form::label('sector_id', 'Setor:', ['class' => 'required']) !!}
        {!! Form::select('sector_id', $sectors, null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!--- Name Field --->
    <div class="form-group col-sm-6 col-lg-6 mb-1">
        {!! Form::label('name', 'Nome:', ['class' => 'required']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!--- Email Field --->
    <div class="form-group col-sm-6 col-lg-6 mb-1">
        {!! Form::label('email', 'Email:', ['class' => 'required']) !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>

    <!--- Password Field --->
    <div class="form-group col-sm-4 col-lg-4 mb-1">
        {!! Form::label('password', 'Senha:') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

  <label class="form-group col-sm-1">
    Ativo:
    <div  class="col-sm-2 form-group form-check form-switch form-switch-md">
        <input
            name="active"
            class="form-check-input"
            type="checkbox"
            @if(isset($user))
            {!! $user->active>0?'checked':'' !!}
            @else
            checked
            @endif
        >
    </div>
  </label>

    <div class="form-group col-sm-6 mt-3">
        <div style="background-color: #8CC152" class="the-box no-border">
            <table>
                <tr>
                    <th>
                        <h4 style="color: #0A0A0A" class="small-title required">GRUPO DE PERMISSÕES:</h4>
                    </th>
                </tr>
                @foreach($levels as $value)
                    <?php
                    $teste = false;
                    if (isset($user)) {
                        $teste = $user->hasRole($value->name);
                    }
                    ?>
                    <tr>
                        <td>
                            <label style="color:black;">
                                {!! Form::checkbox('roles[]', $value->id, $teste) !!}
                                {!! $value->name !!}
                            </label>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="form-group col-sm-6" id="assemblym_div">
        <div class="the-box no-border">
            <table>
                <tr>
                    <th>
                        <h4 class="small-title">GABINETES</h4>
                    </th>
                </tr>
                @foreach($assemblyman as $value)
                    <?php
                    $test = false;
                    if (isset($user)) {
                        $test = in_array($value->id, $user_assemblyman);
                    }
                    ?>
                    <tr>
                        <td>
                            <label>
                                {!! Form::checkbox('assemblyman[]', $value->id, $test) !!}
                                {!! $value->short_name !!} {!! $value->id !!}
                            </label>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!--- Submit Field --->
    <div class="form-group col-sm-12 mt-3">
        {!! Form::submit('SALVAR', ['class' => 'btn btn-success']) !!}
    </div>
    <script>

        $(document).ready(function(){

            $('#assemblym_div').hide();

            if($('#sector_id').val() == '2'){
                $('#assemblym_div').show();
            }
            else{
                $('#assemblym_div').hide();
            }

            $('#sector_id').change(function(){
                if(this.value == 2){
                    $('#assemblym_div').show();
                } else {
                    $('#assemblym_div').hide();
                }
            });

        });
    </script>
