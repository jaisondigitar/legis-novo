<!-- Session Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('session_type_id', 'Tipo da Sessão') !!}
    {!! Form::select('session_type_id', $session_type_list, null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Session Place Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('session_place_id', 'Local da Sessão') !!}
    {!! Form::select('session_place_id', $session_place_list, null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Date Start Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_start', 'Data Início') !!}
    {!! Form::text('date_start', null, ['class' => 'form-control datetimepicker1', 'required']) !!}
</div>

<!-- Date End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_end', 'Data Encerramento:') !!}
    {!! Form::text('date_end', null, ['class' => 'form-control datetimepicker1', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('number', 'Número') !!}
    {!! Form::text('number', null, ['class' => 'form-control', 'required']) !!}
    <label class="label label-danger" id="labelmessage"></label>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('version_pauta_id', 'Tipo da versão da pauta') !!}
    {!! Form::select('version_pauta_id', $version_pautas, null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">



    {!! Form::submit('Salvar', ['id' => 'verify', 'class' => 'btn btn-primary']) !!}
    <a href="{!! route('meetings.index') !!}" class="btn btn-default">Cancelar</a>
</div>

<script>
    $(document).ready(function(){
        $('#labelmessage').html('');

        $('#session_type_id').on('change', function () {
            $.ajax({
               method: "GET",
               url: "{{url('meetings/next_number')}}/" + this.value,
               dataType: "json"
            }).success(function(result) {
               $('#number').val(result);
            });
        });

        $('#number').focusout( function () {
            $.ajax({
                method: "GET",
                url: "{{url('meetings/can_number')}}/" + this.value + '/' + $('#session_type_id').val(),
                dataType: "json"
            }).success(function(result) {
                if(result.success == false){
                    $('#number').val(result.next_number);
                    $('#labelmessage').html(result.message);
                } else {
                    $('#labelmessage').html('');
                }
            });
        });

    });
</script>
