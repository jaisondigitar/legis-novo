@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
    <style>
        .accordion {
            margin-top: 2rem;
        }

        .alert>p, .alert>ul {
            font-weight: 300;
        }

        .card_test:hover {
            box-shadow: 3px 4px 4px 2px #e9ecef;
            transform: scale(1.07)
        }

        .row {
            align-items: center;
            margin-top: 2rem;
        }

        .card_test {
            display: flex;
            border-radius: 23px;
            max-width: 500px;
            margin-left: 10px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: all 0.2s ease;
            cursor: pointer
        }

        .initial {
            border-radius: 20px 0 0 20px;
            background-color: #F04343;
            padding: 30px;
            max-width: 250px;
        }

        .initial_document {
            border-radius: 20px 0 0 20px;
            background-color: #00A3FF;
            padding: 30px;
            max-width: 250px;
        }

        .initial_commissions {
            border-radius: 20px 0 0 20px;
            background-color: #66B700;
            padding: 30px;
            max-width: 250px;
        }

        .end {
            border-radius: 0 20px 20px 0;
            background-color: #FFFFFF;
            padding: 30px;
            width: 100%;
        }

        .bt_color_danger {
            background-color: #F04343;
        }

        .bt_color_info {
            background-color: #00A3FF;
        }

        .bt_color_success {
            background-color: #66B700;
        }
    </style>

        <div class="row">
            <div class="col-sm-12">
                <div class="text-start">
                    <h5>Bem vindo(a)!</h5>
                </div>
            </div>
        </div>

    <div class="row justify-content-center">
        <div class="col-sm-3">
            <div style="padding-left: 10px">
            <a href="/lawsProjects">
            <div class="text-center card_test">
                <div
                    class="initial">
                </div>
                <div class="panel-body end">
                    <div class="text-black">
                        <h3 class="panel-title">PROJETOS DE LEI</h3>
                    </div>
                    <div class="text-start">
                        <h1 STYLE="color: #F04343" class="bolded tiles-number">{{ $projLeiAll }}</h1>
                        <div class="text-end">
                            <h3 class="text-muted"><small>APROVADOS: <strong>{{ $projLeiApr }}</strong></small></h3>
                        </div>
                    </div>
                </div>
            </div>
            </a>
            </div>
        </div>

        <div class="col-sm-3">
            <a href="/documents">
                <div class="text-center card_test">
                    <div
                        class="initial_document">
                    </div>
                    <div class="panel-body end">
                        <div class="text-black">
                            <h3 class="panel-title">DOCUMENTOS</h3>
                        </div>
                        <div class="text-start">
                            <h1 style="color: #00A3FF" class="bolded tiles-number">{{ $docAll }}</h1>
                        </div>
                        <div class="text-end">
                            <h3 class="text-muted"><small>LIDOS: <strong>{{ $docRead }}</strong></small></h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-3">
            <div style="padding-right: 10px">
            <a href="/admin/commissions">
                <div class="text-center card_test">
                    <div
                        class="initial_commissions">
                    </div>
                    <div class="panel-body end">
                        <div class="text-black">
                            <h3 class="panel-title">COMISSÕES</h3>
                        </div>
                            <div class="text-start">
                                <h1
                                    style="color: #66B700"
                                    class="bolded tiles-number bg-op">
                                    {{ isset($commissions)  ? count($commissions) : '0' }}
                                </h1>
                            </div>
                            <div class="text-end">
                                <h5 class="text-muted"><small><strong>COMISSÕES ATIVAS: </strong></small></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div  class="accordion" id="accordions">
        <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button  class="accordion-button collapsed btn bt_color_danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Projetos de Lei
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="accordionProjetosDeLei">
                    <div class="accordion-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    Emenda: 05 <br>
                                    EmendaSupresiva : 05<br>
                                    Emenda Modificada: 20<br>
                                    Emenda Projeto: 20<br>
                                    Resolução: 05<br>
                                    Emenda Aditiva: 05<br>
                                </div>
                                <div class="col">
                                    Emenda Substitutiva: 20<br>
                                    Projeto de Lei: 00<br>
                                    Emenda: 05<br>
                                    Projeto de Lei Complementar: 00<br>
                                    Projeto de Lei Legislativo: 00<br>
                                    loremipsum:00<br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div style="margin-top: 1rem" class="accordion-item">
            <h2 class="accordion-header" id="accordionDocumentos">
                <button class="accordion-button collapsed btn bt_color_info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Documentos
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="accordionDocumentos">
                <div class="accordion-body">
                    Emenda: 05               Emenda Substitutiva: 20
                    EmendaSupresiva : 05     Projeto de Lei: 00
                    Emenda Modificada: 20   Emenda: 05
                    Emenda Projeto: 20      Projeto de Lei Complementar: 00
                    Resolução: 05            Projeto de Lei Legislativo: 00
                    Emenda Aditiva: 05       loremipsum:00
                </div>
            </div>
        </div>
        <div style="margin-top: 1rem" class="accordion-item">
            <h2 class="accordion-header" id="accordionComissões">
                <button class="accordion-button collapsed btn bt_color_success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Comissões
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="accordionComissões">
                <div class="accordion-body">
                    Emenda: 05               Emenda Substitutiva: 20
                    EmendaSupresiva : 05     Projeto de Lei: 00
                    Emenda Modificada: 20   Emenda: 05
                    Emenda Projeto: 20      Projeto de Lei Complementar: 00
                    Resolução: 05            Projeto de Lei Legislativo: 00
                    Emenda Aditiva: 05       loremipsum:00
                </div>
            </div>
        </div>
    </div>
    {{--@if(isset($commissions))--}}
    {{--@foreach($commissions as $c)--}}
            {{--<div class="col-lg-6">--}}
                {{--<div class="panel panel-primary panel-square panel-no-border text-center">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h3 class="panel-title">{{$c->name}}</h3>--}}
                    {{--</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--@foreach($c->advices as $advice)--}}
                            {{--@if($advice->closed == 1)--}}
                        {{--@if($advice->project)--}}
                            {{--<ul class="list-group">--}}
                                {{--<li class="list-group-item" id="linha_{{$advice->id}}">--}}
                                    {{--{!! $advice->project->project_number . '/' . $advice->project->getYearLawPublish($advice->project->law_date) . '-' . $advice->project->law_type->name !!}--}}
                                    {{--<span class="pull-right">--}}
                                        {{--<a href="/lawsProjects/{{$advice->project->id}}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-file-text-o"></i></a>--}}
                                        {{--<button id="advice_{{$advice->id}}" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" onclick="findAdvice({{$advice->id}})"><i class="glyphicon glyphicon-eye-open"></i></button>--}}
                                        {{--<button id="advice_awnser_{{$advice->id}}" onclick="carrega_id({{$advice->id}})" type="button" class="btn btn-info btn-xs " data-toggle="modal" data-target="#myModal1" data = "{{$advice->id}}"><i class="fa fa-pencil-square-o"></i></button>--}}
                                    {{--</span>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--@endif--}}
                        {{--@if($advice->document)--}}
                            {{--<ul class="list-group">--}}
                                {{--<li class="list-group-item" id="linha_{{$advice->id}}">--}}
                                    {{--{!! $advice->document->number . '/' . $advice->document->getYear($advice->document->date) . '-' . $advice->document->document_type->name !!}--}}
                                {{--<span class="pull-right">--}}
                                    {{--<a href="/documents/{{$advice->document->id}}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-file-text-o"></i></a>--}}
                                    {{--<button id="advice_{{$advice->id}}" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" onclick="findAdvice({{$advice->id}})"><i class="glyphicon glyphicon-eye-open"></i></button>--}}
                                    {{--<button id="advice_awnser_{{$advice->id}}" onclick="carrega_id({{$advice->id}})" type="button" class="btn btn-info btn-xs " data-toggle="modal" data-target="#myModal1" data = "{{$advice->id}}"><i class="fa fa-pencil-square-o"></i></button>--}}
                                {{--</span>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--@endif--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                    {{--</div><!-- /.panel-body -->--}}
                {{--</div><!-- /.panel panel-success panel-block-color -->--}}
            {{--</div>--}}
    {{--@endforeach--}}
    {{--@endif--}}


    {{--modal  detalhes--}}

    <!-- Large modal -->
    <div class="container">
        <!-- Modal -->
        <div class="modal fade " id="myModal" role="dialog">
            <div class="modal-dialog  modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Detalhes do pedido</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">

                            <!-- advice_id Field -->
                            <div class="form-group col-sm-6 hidden">
                                {{ Form::label('advice_id', 'id:') }}
                                <input type="text" id="advice_idP" />
                                <label id="advice_id"></label>
                            </div>

                            <!-- Date Field -->
                            <div class="form-group col-sm-6">
                                {!! Form::label('date', 'Data:') !!}
                                <label id="date"></label>
                            </div>

                            <!-- Type Field -->
                            <div class="form-group col-sm-6">
                                {!! Form::label('laws_projects_id', 'Projeto de lei:', ['id' => 'projectName']) !!}
                                <label id="laws_projects_id"> </label>
                            </div>

                            <!-- To Id Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::label('description', 'Descrição:') !!}<br/>
                                <p id="description" style="margin-left: 15px;"></p>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        {{--<a href="javascript:void(0);" class="btn btn-danger pull-left" onclick="removeAdvice()">Remover</a>--}}
                        <a href="" id="history" class="btn btn-info"> Histórico do tramite </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- fim do modal --}}

    {{--modal1  detalhes--}}
    <!-- Large modal -->
        <div class="container">
                <!-- Modal -->
                <div class="modal fade " id="myModal1" role="dialog">
                        <div class="modal-dialog  modal-lg">
                                <!-- Modal content-->
                                <form action="/admin/saveAdvice" method="POST" enctype="multipart/form-data">
                                        @csrf
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Informar parecer</h4>
                                                </div>
                                            <div class="modal-body">
                                                    <div class="col-md-12">

                                                            <input type="text" class="form-control hidden"  name="id" id="adv_idP"/>

                                                            <div class="col-md-3">
                                                                    <label> Data: </label>
                                                                    <input type="text" class="form-control" name="date" id="dateP"/>
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
            </div>
    {{-- fim do modal --}}
    <!-- Large modal -->

    {{-- fim do modal --}}






    <script>

        var id = '';

        $(document).ready(function () {

            $('#dateP').datepicker();

            $('#dateP').on('blur', function() {
                var dateP = $('#dateP').val();
                var date = dateP.split('/');
                dia = date[1];
                mes = date[0];
                ano = date[2];
                dateP = dia + '/' + mes + '/' + ano;
                $('#dateP').val(dateP);
            });

        });

        var carrega_id = function(param){

            $('#adv_idP').val(param);

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

        var findAdvice = function(id){

            carrega_id(id);
            $('#history').attr('href', '/advice/findAwnser/' + id);

            url = "/admin/findAdvice";

            data = {
                id : id,
                "_token": "{{ csrf_token() }}"
            };

            $.ajax({
                url    : url,
                data   : data,
                method : 'POST',
                encoding: 'UTF-8'

            }).success(function(data){

                data = JSON.parse(data);
                console.log(data);

                if(data){
                    $('#date').text(data.date);
                    if(data.laws_projects_id > 0) {
                        $('#projectName').text('Projeto de lei:');
                        data_doc =data.project.law_date.toString().split('/');

                        $('#laws_projects_id').text(data.project.project_number + '/' + data_doc[2]);
                    }
                    if(data.document_id > 0) {
                        $('#projectName').text('Documento:');
                        data_doc = data.document.date.toString().split('/');
                        $('#laws_projects_id').text(data.document.number + '/' + data_doc[2]) ;
                    }
                    $('#description').html(data.description);
                }else{
                    toastr.error('Pedido não localizado!!!');
                }
            });
        }

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


@endsection
