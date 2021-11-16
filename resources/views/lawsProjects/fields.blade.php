<div class="form-group col-sm-2">
    {!! Form::label('law_date', 'Data projeto:') !!}
    {!! Form::text('law_date', null, ['class' => 'form-control datepicker', 'required']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('law_type_id', 'Tipo de lei:') !!}
    {!! Form::select('law_type_id', $law_types, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('reference_id', 'Referente à:') !!}
    {!! Form::select('reference_id', $references_project, null, ['class' => 'form-control chosen']) !!}
</div>

<div class="form-group col-sm-2">
    {!! Form::label('situation_id', 'Situação Atual:') !!}
    {!! Form::select('situation_id', $situation, null, ['class' => 'form-control']) !!}
</div>



{{--<div class="form-group col-sm-2">--}}
    {{--{!! Form::label('town_hall', 'Aprovado pela câmara:') !!}--}}
    {{--<div class="clearfix"></div>--}}
    {{--{!! Form::checkbox('town_hall', 1, null, ['class' => 'form-control switch' , 'data-on-text' => 'Sim', 'data-off-text' => 'Não', 'data-off-color' => 'danger', 'data-on-color' => 'success', 'data-size' => 'normal', 'type' => 'checkbox' ]) !!}--}}
{{--</div>--}}



{{--<div class="form-group col-sm-2">--}}
    {{--{!! Form::label('town_hall', 'Aprovado pela câmara::') !!}--}}
    {{--<input class="switch" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal" type="checkbox" {!! $town_hall > 0 ? 'checked':'' !!}>--}}
{{--</div>--}}

<div class="clearfix"></div>
<div class="form-group col-sm-3" style="padding-left: 0px">
    <div class="form-group col-sm-12 hidden">
        {!! Form::label('date_presentation', 'Data ao plenário:') !!}
        {!! Form::text('date_presentation', null, ['class' => 'form-control datepicker']) !!}
    </div>
    <div class="form-group col-sm-12">
        {!! Form::label('comission_id', 'Comissão:') !!}
        {!! Form::select('comission_id', $comission, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-12">
        {!! Form::label('assemblyman_id', 'Responsável') !!}
        {!! Form::select('assemblyman_id', $assemblymensList ,null, ['class' => 'form-control', 'id' => 'owner_id']) !!}
    </div>

</div>

<div class="form-group col-sm-9">
    {!! Form::label('title', 'Ementa:') !!}
    {!! Form::textarea('title', null, ['class' => 'form-control', 'rows'=>5]) !!}
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-6">
    {!! Form::label('sub_title', 'Texto PREFIXO:') !!}
    {!! Form::textarea('sub_title', null, ['class' => 'form-control ckeditor']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('sufix', 'Texto SUFIXO:') !!}
    {!! Form::textarea('sufix', null, ['class' => 'form-control ckeditor']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('sufix', 'Texto JUSTIFICATIVA:') !!}
    {!! Form::textarea('justify', null, ['class' => 'form-control ckeditor']) !!}
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-5">
    <div class="panel panel-square panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-angle-double-right"></i> PARLAMENTARES ASSINANDO</h3>
        </div>
        <div class="panel-body">
            {!! Form::select('assemblymen[]', $assemblymen, null, ['class' => 'chosen-select', 'multiple', 'style' => 'width:100%;', 'data-placeholder' => 'Selecione o parlamentar...']) !!}
        </div><!-- /.panel-body -->
    </div>
</div>

{{--<div class="form-group col-sm-3">--}}
    {{--<div class="panel panel-square panel-default">--}}
        {{--<div class="panel-heading">--}}
            {{--<h3 class="panel-title"><i class="fa fa-upload"></i> ANEXAR ARQUIVO</h3>--}}
        {{--</div>--}}
        {{--<div class="panel-body">--}}
            {{--<input type="file" name="file" value="" class="form-control">--}}
            {{--<br>--}}
            {{--@if(isset($lawsProject) && $lawsProject->file)--}}
              {{--<a href="/laws/{{ $lawsProject->file }}" target="_blank"><i class="fa fa-download"></i> {{ $lawsProject->file }}</a>--}}
            {{--@endif--}}
        {{--</div><!-- /.panel-body -->--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group col-sm-3">--}}
    {{--<div class="panel panel-square panel-default">--}}
        {{--<div class="panel-heading">--}}
            {{--<h3 class="panel-title"><i class="fa fa-upload"></i> ANEXAR LEI SANCIONADA</h3>--}}
        {{--</div>--}}
        {{--<div class="panel-body">--}}
            {{--<input type="file" name="law_file" value="" class="form-control">--}}
            {{--<br>--}}
            {{--@if(isset($lawsProject) && $lawsProject->law_file)--}}
              {{--<a href="/laws/{{ $lawsProject->law_file }}" target="_blank"><i class="fa fa-download"></i> {{ $lawsProject->law_file }}</a>--}}
            {{--@endif--}}
        {{--</div><!-- /.panel-body -->--}}
    {{--</div>--}}
{{--</div>--}}


{{-- -----------------------------------tamitação --}}

@if(isset($lawsProject->id) && $tramitacao)


<div class="col-sm-12" disable="true">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="right-content">
                <button type="button" class="btn btn-default btn-sm btn-rounded-lg to-collapse" data-toggle="collapse" data-target="#panel-collapse-4" aria-expanded="true"><i class="fa fa-chevron-up"></i></button>
            </div>
            <h3 class="panel-title"><i class="fa fa-angle-double-right"></i>TRAMITAÇÃO ANTIGA(INATIVO)</h3>
        </div>
        <div id="panel-collapse-4" class="collapse " aria-expanded="true" style="">
            <div class="panel-body">
                <div class=" col-md-12 col-sm-12">
                    <div class="form-group col-sm-3"> 
                        {!! Form::label('advice_publication_id', ' Publicado no:') !!} 
                        {!! Form::text('advice_publication_id', isset($lawsProject->advicePublicationLaw) ? $lawsProject->advicePublicationLaw->name : ' ', ['class' => 'form-control', 'disabled']) !!} 
                    </div>  

                    <div class="form-group col-sm-3"> 
                        {!! Form::label('advice_situation_id', 'Situação do projeto:') !!} 
                        {!! Form::text('advice_situation_id', isset($lawsProject->adviceSituationLaw) ? $lawsProject->adviceSituationLaw->name : ' ', ['class' => 'form-control', 'disabled']) !!} 
                    </div>  

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-2"> 
                        {!! Form::label('date_presentation', 'Data ao plenário:') !!} 
                        {!! Form::text('date_presentation', null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('advice_date', 'Parecer em:') !!} 
                        {!! Form::text('advice_date', null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  

                    <div class="form-group col-sm-2"> 
                        {!! Form::label('first_discussion', ' Primeira discussão em:') !!} 
                        {!! Form::text('first_discussion',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('second_discussion', ' Segunda discussão em:') !!} 
                        {!! Form::text('second_discussion',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('third_discussion', ' Terceira discussão em:') !!} 
                        {!! Form::text('third_discussion',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-2"> 
                        {!! Form::label('single_discussion', ' Única discussão em:') !!} 
                        {!! Form::text('single_discussion',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('special_urgency', ' Urgência especial em:') !!} 
                        {!! Form::text('special_urgency',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('approved', ' Aprovado em:') !!} 
                        {!! Form::text('approved',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('sanctioned', ' Sancionado em:') !!} 
                        {!! Form::text('sanctioned',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('Promulgated', ' Promulgado em:') !!} 
                        {!! Form::text('Promulgated',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-2"> 
                        {!! Form::label('Rejected', ' Rejeitado em:') !!} 
                        {!! Form::text('Rejected',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('Vetoed', ' Vetado em:') !!} 
                        {!! Form::text('Vetoed',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('Filed', ' Arquivado em:') !!} 
                        {!! Form::text('Filed',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  
                    <div class="form-group col-sm-2"> 
                        {!! Form::label('sustained', ' Mantido em:') !!} 
                        {!! Form::text('sustained',  null, ['class' => 'form-control datepicker','disabled']) !!} 
                    </div>  

                    <div class="clearfix"></div>  
                    <div class="form-group col-sm-12"> 
                        {!! Form::label('observation', ' Observações:') !!} 
                        {!! Form::textarea('observation', null, ['class' => 'form-control','disabled']) !!} 
                    </div> 
                </div>
            </div><!-- /.panel-body -->
        </div><!-- /.collapse in -->
    </div><!-- /.panel panel-default -->
</div>
@endif
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{--{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}--}}
    <button type="submit" class="btn btn-primary"> Salvar</button>
    <a href="{!! route('lawsProjects.index') !!}" class="btn btn-default">Cancelar</a>
</div>

<style href="{{ url('assets/plugins/chosen/chosen.min.css') }}"></style>
<script src="{{ url('assets/plugins/chosen/chosen.jquery.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#reference_id').chosen();

        var oldValue;

        if($('#owner_id').val() > 0){
            var assemblyman = $("#owner_id option:selected").text();
            $("select.chosen-select option:contains('" + assemblyman + "')").hide();
            if(oldValue){
                $("select.chosen-select option:contains('" + oldValue + "')").show();
            }
            $(".chosen-select").trigger('chosen:updated');
            oldValue = assemblyman;
        }

        $('#owner_id').on('change', function () {
            var assemblyman = $("#owner_id option:selected").text();
            $("select.chosen-select option:contains('" + assemblyman + "')").hide();
            if(oldValue){
                $("select.chosen-select option:contains('" + oldValue + "')").show();
            }
            $(".chosen-select").trigger('chosen:updated');
            oldValue = assemblyman;
        });

        $(".chosen-select").chosen();
        @if(isset($lawsAssemblyman))
            $(".chosen-select").val({!! (isset($lawsAssemblyman) ? $lawsAssemblyman : '') !!}).trigger('chosen:updated');
        @endif
    });


    var save_processing = function(){

        url = '{{route('processings.store')}}';

        if($('#new_advice_situation_id').val() == ''){
           toastr.error('Selecione a situação da tramitação!')
        }else {
            if($('#new_status_processing_law_id').val() == ''){
                toastr.error('Selecione um status para tramitação!');
            }else {
                if($('#new_date_processing').val() == ''){
                    toastr.error('Selecione uma data para tramitação!');
                }else
                data = {
                    law_projects_id: '{{ $lawsProject->id }}',
                    advice_publication_id: $('#new_advice_publication_id').val(),
                    advice_situation_id: $('#new_advice_situation_id').val(),
                    status_processing_law_id: $('#new_status_processing_law_id').val(),
                    processing_date: $('#new_date_processing').val(),
                    processing_file: $('#processing_file').val(),
                    obsevation: CKEDITOR.instances.new_observation.getData()
                };

                $.ajax({
                    url: url,
                    data: data,
                    method: 'post'
                }).success(function (data) {

                    data = JSON.parse(data);

                    table = $('#table_processing').empty();

                    data.forEach(function (valor, chave) {

                        str = '<tr id="line_' + valor.id + '"> ';
                        str += "<td>";
                        if(valor.advice_publication_id > 0) {
                        str += valor.advice_publication_law.name;
                        }
                        str += "</td>";
                        str += "<td>";
                        str += valor.advice_situation_law.name;
                        str += "</td>";
                        str += "<td>";
                        if(valor.status_processing_law_id > 0) {
                            str += valor.status_processing_law.name;
                        }
                        str += "</td>";
                        str += "<td>";
                        str += valor.processing_date;
                        str += "</td>";
                        str += "<td>";
                        str += valor.obsevation;
                        str += "</td>";
                        str += "<td>";
                        str += '<button type="button" class="btn btn-danger btn-xs" onclick="delete_processing(' + valor.id + ')"> <i class="fa fa-trash"></i> </button>';
                        str += "</td>";
                        str += "</tr>";
                        table.append(str);
                    });

                    toastr.success('Tramitação salva com sucesso!');

                    $('#new_advice_publication_id').val('');
                    $('#new_advice_situation_id').val('');
                    $('#new_status_processing_law_id').val('');
                    $('#new_date_processing').val('');
                    CKEDITOR.instances.new_observation.setData('');
                });
            }
        }

    }

    var delete_processing = function(id){

        if(confirm('Deseja excluir?')) {

            url = '/processings/' + id;

            $.ajax({
                url: url,
                method: 'DELETE'
            }).success(function (data) {

                data = JSON.parse(data);

                $('#line_' + id).fadeOut();
                toastr.success('Tramitação excluída com sucesso!');

            });
        }
    }


</script>
