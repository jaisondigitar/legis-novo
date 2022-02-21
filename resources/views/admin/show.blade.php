@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('commissions.list') !!}
@endsection
@section('content')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    @if(isset($commissions))
            <div class="col-lg-12">
                <div class="panel panel-info panel-square panel-no-border text-center">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="font-size: 30px;">{{$commissions->name}}</h2>
                        <h4 class="text-uppercase">{{$commissions->type}}</h4>
                        <a href="/admin/commissions" class="btn btn-default pull-right" style="margin-top: -51px;"> <i class="fa fa-arrow-left"></i> Voltar</a>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center"> Número</th>
                                    <th class="text-center"> Ano</th>
                                    <th class="text-center"> Nome</th>
                                    <th class="text-center" style="text-align: left"> Ementa</th>
                                    <th class="text-center"> Autor</th>
                                    <th class="text-center"> Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($advices as $advice)
                                    @if($advice->project)
                                        <tr>
                                            <td> {!! $advice->project->project_number !!} </td>
                                            <td> {!! $advice->project->getYearLawPublish($advice->project->law_date) !!}</td>
                                            <td> {!! $advice->project->law_type->name !!}</td>
                                            <td style="text-align: left"> {!! $advice->project->title !!}</td>
                                            <td> {!! $advice->project->owner->short_name !!}</td>
                                            <td>
                                                <span class="pull-right">
                                                    <a href="/lawsProjects/{{$advice->project->id}}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-file-text-o"></i></a>
                                                    <a id="advice_{{$advice->id}}" type="button" class="btn btn-info btn-xs" href='/advice/findAwnser/{{$advice->id}}'><i class="glyphicon glyphicon-eye-open"></i></a>
                                                    @if($advice->closed == 1)
                                                    <button id="advice_awnser_{{$advice->id}}" onclick="carrega_id({{$advice}}, {{$advice->project->getYearLawPublish($advice->project->law_date)}})" type="button" class="btn btn-info btn-xs " data-toggle="modal" data-target="#myModal1" data = "{{$advice->id}}"><i class="fa fa-pencil-square-o"></i></button>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endif

                                    @if($advice->document)
                                        <tr>
                                            <td> {!! $advice->document->number !!} </td>
                                            <td> {!! $advice->document->getYear($advice->document->date) !!}</td>
                                            <td> {!! $advice->document->document_type->name !!}</td>
                                            <td style="text-align: left"> {!! $advice->project->title !!}</td>
                                            <td> {!! $advice->project->owner->short_name !!}</td>
                                            <td>
                                                 <span class="pull-right">
                                                    <a href="/documents/{{$advice->document->id}}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-file-text-o"></i></a>
                                                    <button id="advice_{{$advice->id}}" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" onclick="findAdvice({{$advice->id}})"><i class="fa fa-eye"></i></button>
                                                     @if($advice->closed == 1)
                                                     <button id="advice_awnser_{{$advice->id}}" onclick="carrega_id({{$advice->id}})" type="button" class="btn btn-info btn-xs " data-toggle="modal" data-target="#myModal1" data = "{{$advice->id}}"><i class="fa fa-pencil-square-o"></i></button>
                                                     @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                        {{--{!! $advices->render() !!}--}}
                    </div><!-- /.panel-body -->
                </div><!-- /.panel panel-success panel-block-color -->
            </div>
        {{--@endforeach--}}

        {{--modal1  detalhes--}}

            <style>
                .datepicker>div {
                    display: inline;
                }
            </style>
        <!-- Large modal -->
        {{--<div class="container">--}}
            <!-- Modal -->
            <div class="modal fade " id="myModal1" role="dialog">
                <div class="modal-dialog  modal-lg">
                    <!-- Modal content-->
                    <form action="/admin/saveAdvice" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Informar parecer</h4>
                                <p id="inform"></p>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">

                                    <input type="text" class="form-control hidden"  name="id" id="adv_idP"/>

                                    <div class="col-md-3">
                                        <label> Data: </label>
                                        <input type="text" class="form-control datepicker1" name="date" id="dateP" autocomplete="off"/>
                                    </div>

                                    <!-- Date Field -->
                                    <div class="form-group col-sm-4">
                                        {!! Form::label('situationP', 'Situação:') !!}
                                        {!! Form::select('situationP', $commissions_situation, null,['class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group col-sm-4">
                                        {!! Form::label('town_hall', 'Encerrar:') !!}
                                        <div class="clearfix"></div>
                                        {!! Form::checkbox('closed', 1, null, ['class' => 'form-control switch' , 'data-on-text' => 'Sim', 'data-off-text' => 'Não', 'data-off-color' => 'danger', 'data-on-color' => 'success', 'data-size' => 'normal', 'type' => 'checkbox' ]) !!}
                                    </div>

                                    <!-- Date Field -->
                                    <div class="form-group col-sm-12">
                                        {!! Form::label('descriptionP', 'Descrição:') !!}
                                        <textarea name="desc" id="descriptionP" class="form-control ckeditor" cols="30" rows="10"></textarea>
                                    </div>


                                    <!-- Date Field -->
                                    <div class="form-group col-sm-12">

                                        <div class="col-md-4">
                                            {!! Form::label('fileP', 'Arquivo:') !!}
                                            <input type="file" name="Arquivo" id="fileP"><br>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <img id="imgP" src="" alt="" width="200"/>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info" onclick="return carrega_data()">Salvar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        {{--</div>--}}
        {{-- fim do modal --}}
        <!-- Large modal -->

        {{-- fim do modal --}}
            <script>
                $(document).ready(function () {
                    $('.datepicker1').datepicker({
                        format: 'dd/mm/yyyy',
                        language: 'pt-BR',
                        autoclose: true
                    });

                })

            </script>


        <script>

            var id = '';

            $(document).ready(function () {

                $('#table_advice').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                    }
                });

                // $('#dateP').datepicker();

                // $('#dateP').on('blur', function() {
                //     var dateP = $('#dateP').val();
                //     var date = dateP.split('/');
                //     dia = date[1];
                //     mes = date[0];
                //     ano = date[2];
                //     dateP = dia + '/' + mes + '/' + ano;
                //     $('#dateP').val(dateP);
                // });

            });

            const carrega_id = (param, number) => {
                document.getElementById('inform').textContent = `${param.project.owner.short_name} - ${param.project.project_number}/${number}`;

                $('#adv_idP').val(param.id);

            };

            var carrega_data = function(){

                ck = CKEDITOR.instances['descriptionP'].getData() == '' ? null : CKEDITOR.instances['descriptionP'].getData() ;

                if($('#dateP').val() == '' || $('#situationP').val() == 0 || ck == null ){
                    toastr.error('Verifique todos os dados!!!');
                    return false;
                }else {
                    date = $('#dateP').val();
                    date = date.split('/');
                    dia = date[0];
                    mes = date[1];
                    ano = date[2];
                    date = ano + '-' + mes + '-' + dia;
                    $('#dateP').val(date);
                }
            };

            var saveAdvice = function(){
                url = '/admin/saveAdvice';

                if($('#dateP').val() == '' || $('#situationP').val() == 0 || $('#descriptionP').val() == ''){
                    toastr.error('Verifique todos os dados!!!');
                }else {

                    date = $('#dateP').val();
                    date = date.split('/');
                    dia = date[0];
                    mes = date[1];
                    ano = date[2];
                    date = ano + '-' + mes + '-' + dia;

                    data = {
                        advice_id: id,
                        date: date,
                        situation: $('#situationP').val(),
                        description: $('#descriptionP').val(),
                        file: $("#imgP").attr('src'),
                        "_token": "{{ csrf_token() }}"
                    };

                    $.ajax({
                        data: data,
                        url: url,
                        method: 'POST'
                    }).success(function (data) {

                        if(data){
                            toastr.success('Resposta salva!!!');
                            $('#myModal1').toggle();
                        }
                    });
                }

            }

            var removeAdvice = function(){


                url = '/advice/delete';

                data = {
                    id : $('#advice_idP').val(),
                    _token : '{{ csrf_token() }}'
                }

                $.ajax({
                    url : url,
                    data : data,
                    method : 'POST'
                }).success(function(data){

                    data = JSON.parse(data);

                    if(data){

                        $('#linha_'+data).fadeOut();
                        $('#myModal').toggle();
                        toastr.success('Parecer removido com sucesso!');

                    }else{
                        toastr.error('Erro ao excluir!');
                        $('#myModal').toggle();
                    }
                });


            }
        </script>
    @endif
@endsection
