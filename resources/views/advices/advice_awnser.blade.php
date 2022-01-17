@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')


    <div class="col-sm-12">
        <div class="the-box bg-default no-border">
            <h4 class="small-title">INFORMAÇÕES</h4>
            <hr>

            <div class="col-sm-12">
                <div class="panel-group" id="accordion-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a class="block-collapse collapsed" data-parent="#accordion-1" data-toggle="collapse" href="#accordion-1-child-1" aria-expanded="false">
                                    @if($advice->project)
                                        Dados do Projeto de lei
                                    @endif
                                    @if($advice->document)
                                        Dados do documento
                                    @endif

										<span class="right-content">
											<span class="right-icon"><i class="glyphicon glyphicon-plus icon-collapse"></i></span>
										</span>
                                </a>
                            </h3>
                        </div>
                        <div id="accordion-1-child-1" class="collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                @if($advice->project)
                                    <div class="col-md-3">
                                        <b>Nº Projeto de lei:</b> <br/>
                                        {{$advice->project->project_number}}
                                    </div>

                                    <div class="col-md-3">
                                        <b>Parlamentar:</b> <br/>
                                        {{$advice->project->assemblyman->short_name}}
                                    </div>

                                    <div class="col-md-3">
                                        <b>Tipo:</b> <br/>
                                        {{$advice->project->law_type->name}}
                                    </div>

                                    <div class="col-md-3">
                                        <b>Data:</b> <br/>
                                        {{$advice->project->law_date}}
                                    </div>

                                    <div class="clearfix"></div>
                                    <br/>
                                    <br/>

                                    <div class="col-md-6">
                                        <b>Ementa:</b> <br/>
                                        {{$advice->project->title}}
                                    </div>

                                    <div class="col-md-6">
                                        <b>Preâmbulo:</b> <br/>
                                        {!! $advice->project->sub_title !!}
                                    </div>
                                @endif
                                @if($advice->document)
                                    <div class="col-md-3">
                                        <b>Nº Documento:</b> <br/>
                                        {{$advice->document->number}}
                                    </div>

                                    <div class="col-md-3">
                                        <b>Tipo:</b> <br/>
                                        {{$advice->document->document_type->name}}
                                    </div>

                                    <div class="col-md-3">
                                        <b>Data:</b> <br/>
                                        {{$advice->document->date}}
                                    </div>

                                    <div class="clearfix"></div>
                                    <br/>
                                    <br/>
                                    <div class="col-md-6">
                                        <b>Descrição:</b> <br/>
                                        {!! $advice->document->content !!}
                                    </div>
                                @endif
                            </div><!-- /.panel-body -->
                        </div><!-- /.collapse in -->
                    </div><!-- /.panel panel-default -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a class="block-collapse collapsed" data-parent="#accordion-1" data-toggle="collapse" href="#accordion-1-child-2" aria-expanded="false">
                                    Dados do pedido
										<span class="right-content">
											<span class="right-icon">
												<i class="glyphicon glyphicon-plus icon-collapse"></i>
											</span>
										</span>
                                </a>
                            </h3>
                        </div>

                        <div id="accordion-1-child-2" class="collapse" aria-expanded="false">
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <b>Data:</b> <br/>
                                    {{ $advice->date }}
                                </div>

                                <div class="col-md-6">
                                    <b>Comissão:</b> <br/>
                                    {{$advice->commission->name}}
                                </div>

                                <div class="clearfix"></div>
                                <br/>
                                <br/>

                                <div class="col-md-12">
                                    <b>Descrição:</b> <br/>
                                    {!! $advice->description !!}
                                </div>




                            </div><!-- /.panel-body -->
                        </div><!-- /.collapse in -->
                    </div><!-- /.panel panel-default -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a class="block-collapse collapsed" data-parent="#accordion-1" data-toggle="collapse" href="#accordion-1-child-3" aria-expanded="false">
                                    Pareceres
										<span class="right-content">
											<span class="right-icon">
												<i class="glyphicon glyphicon-plus icon-collapse"></i>
											</span>
										</span>
                                </a>
                            </h3>
                        </div>
                        <div id="accordion-1-child-3" class="collapse" aria-expanded="false">
                            <div class="panel-body">
                                @foreach($advice->awnser()->orderBy('date','desc')->get() as $awnser)
                                    {{--{{dd($awnser)}}--}}

                                    <div class="col-sm-12" id="awnser_{{$awnser->id}}">
                                        <div class="panel panel-default">
                                            {{--<div class="panel-heading">--}}
                                            {{--<h3 class="panel-title">Default style</h3>--}}
                                            {{--</div>--}}
                                            <div class="panel-body">
                                                <div class="col-md-4">
                                                    <b>Data:</b> <br/>
                                                    {{ $awnser->date }}
                                                </div>

                                                <div class="col-md-4">
                                                    <b>Situação:</b> <br/>
                                                    {{$awnser->commission_situation->name}}
                                                </div>


                                                <div class="col-md-4">
                                                    <b>Arquivos:</b> <br/>
                                                    <a href="/uploads/advice_awnser/{{$awnser->file}}" target="_blank" class="remove_file_c{{$awnser->id}}">{{$awnser->file}}</a>
                                                    @shield('lawsProject.advicesDeleteFile')
                                                    @if($awnser->file)
                                                    <button type="button" class="btn btn-danger btn-xs remove_file_c{{$awnser->id}}" onclick="return removeFile({{$awnser->id}})"> <i class="fa fa-trash"></i> </button>
                                                    @endif
                                                    @endshield
                                                </div>


                                                <div class="clearfix"></div>
                                                <br/>
                                                <br/>


                                                <div class="col-md-12">
                                                    <b>Descrição:</b> <br/>
                                                    {!! $awnser->description !!}
                                                </div>

                                                <hr>
                                                @shield('lawsProject.advicesDelete')<button type="button" id="removeAwnser" onclick="return removeAwnser({{$awnser->id}})" class="btn btn-danger pull-right"><i class="fa fa-trash"></i></button>@endshield
                                                @shield('lawsProject.advicesEdit')<button type="button" class="btn btn-warning pull-right" style="margin-right: 2px;" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="get_awnser({{$awnser->id}})"><i class="fa fa-edit"></i></button>@endshield
                                            </div><!-- /.panel-body -->
                                        </div><!-- /.panel panel-default -->
                                    </div>


                                @endforeach

                                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="card">
                                                    <div class="card-header bg-info">
                                                        <span class="text-uppercase" style="padding: 5px; line-height: 35px;">Edita parecer</span>
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="/advice/awnserUpdate" method="POST" enctype="multipart/form-data">
                                                            {!! csrf_field() !!}
                                                            {{--<div class="modal-content">--}}
                                                            {{--<div class="modal-header">--}}
                                                            {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                                            {{--<h4 class="modal-title">Informar parecer</h4>--}}
                                                            {{--</div>--}}
                                                            <div class="modal-body">
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control hidden"  name="id" id="awnser_id" value=""/>

                                                                    {{--<div class="col-md-3">--}}
                                                                        {{--<label> Data: </label>--}}
                                                                        {{--<input type="date" class="form-control" name="date" id="date_awnser" value=""/>--}}
                                                                    {{--</div>--}}

                                                                    <div class="form-group col-md-3">
                                                                        {!! Form::label('law_date', 'Data:') !!}
                                                                        {!! Form::text('date', null, ['id'=>'date_awnser', 'class' => 'form-control datepicker1', 'required']) !!}
                                                                    </div>

                                                                    <!-- Date Field -->
                                                                    <div class="form-group col-sm-4">
                                                                        {!! Form::label('situation_awnser', 'Situação:') !!}
                                                                        {!! Form::select('situation_awnser', $commissions_situation, null  ,['class' => 'form-control']) !!}
                                                                    </div>

                                                                    <!-- Date Field -->
                                                                    <div class="form-group col-sm-12">
                                                                        {!! Form::label('description_awnser', 'Descrição:') !!}
                                                                        <textarea name="description_awnser" id="description_awnser" class="form-control ckeditor" cols="30" rows="10">

                                                                        </textarea>
                                                                    </div>


                                                                    <!-- Date Field -->
                                                                    <div class="form-group col-sm-12" id="file_div">
                                                                        <div class="col-md-4">
                                                                            {!! Form::label('file_awnser', 'Arquivo:') !!}
                                                                            <input type="file" name="Arquivo" id="file_awnswer" value=""><br>
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
                                                            {{--</div>--}}
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div><!-- /.panel-body -->
                        </div><!-- /.collapse in -->
                    </div><!-- /.panel panel-default -->
                </div><!-- /.panel-group -->
            </div>
            <a href="javascript:history.go(-1)" class="btn btn-info pull-right" > Voltar </a>
            <div class="clearfix"></div>
        </div><!-- /.the-box .bg-info .no-border-->
        <div class="clearfix"></div>
    </div>

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
        var removeAwnser = function (id) {
            if(confirm('Deseja excluir parecer?')) {
                $.ajax({
                    url: '/advice/findAwnser/' + id + '/delete',
                    method: 'POST'
                }).success(function (data) {
                    data = JSON.parse(data);
                    if (data) {
                        $('#awnser_' + data.id).fadeOut();
                        toastr.sucess('Parecer removido com sucesso!');
                    } else {
                        toastr.error('Erro ao excluir parecer!');
                    }
                })
            }
        }

        

        var get_awnser = function (id) {
            $('#file_div').fadeIn();
            url = '/advice/findAwnser/'+ id +'/getAwnser';
            $.ajax({
                url : url,
                method : 'GET'
            }).success(function (response) {
                response = JSON.parse(response);
                if(response){
                    $('#awnser_id').val(response.id);
                    document.getElementById('date_awnser').value = response.date;
                    $('#situation_awnser').val(response.commission_id);
                    CKEDITOR.instances.description_awnser.setData( response.description );
                }
            })
        }

        var dateFormat = function (data) {
            var dia = data.getDate();
            if (dia.toString().length == 1)
                dia = "0"+dia;

            var mes = data.getMonth()+1;
            if (mes.toString().length == 1)
                mes = "0"+mes;

            var ano = data.getFullYear();

            return ano+"-"+mes+"-"+dia;
        }

        var removeFile = function (id) {
            if (confirm("Deseja excluir o arquivo?")) {
                url = '/advice/awnser/' + id + '/removeFile';

                $.ajax({
                    url: url,
                    method: 'GET'
                }).success(function (response) {
                    response = JSON.parse(response);
                    if (response) {
                        $('.remove_file_c'+id).fadeOut()

                    } else {
                        toastr.error('Falha ao remover arquivo!');
                    }

                });
            }
        }
    </script>

@endsection
