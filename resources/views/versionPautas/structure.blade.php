@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.new') !!}
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script src="/assets/js/jquery.mjs.nestedSortable.js"></script>

    <div class="row" style="margin: 0 3.125rem 0 3.125rem">
        @include('common.errors')
        <div class="the-box rounded">
            <div class="col-md-12" >
                <h2 class="text-uppercase">Versão - {{$version_pauta->name}}</h2>
                <h4 class="text-uppercase">Estrutura de pauta</h4>
                <a href="{{route('version_pauta.index')}}" class="btn btn-default pull-right"> Voltar </a>
            </div>
        </div>

            <div class="col-md-12 the-box rounded">
                @if(count($structurepautas)==0)
                    <div class="well text-center">
                        <h3>Sem dados. Insira um novo registro.</h3>
                        <button type="button" class="editable btn btn-info" data-item="0" data-method="post" data-number="1" data-action="store" data-title="Novo registro" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Adicionar estrutura</button>
                    </div>
                @else
                    <style>
                        .the-box{
                            margin-bottom: 3px;
                        }
                        ol {
                            border-left: 1px dashed #cccccc;
                            list-style: none;
                            counter-reset: num;
                        }
                        ul {
                            list-style: none;
                            counter-reset: num;
                        }
                        /*
                        ol li:before {
                        content: counter(num)".";
                        counter-increment: num;
                        }

                        ol ol li:before {
                        content: counters(num,".") ' ';
                        }
                        */
                        </style>
                            <?php
                            function renderNode($node, $index = 0, $level = 0)
                            {
                                $html = '<li id="struc_'.$node->id.'" class="list-item"><div class="the-box rounded"><h4 style="margin-top:0px"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> '.($node->isRoot() ? strtoupper($node->name) : $node->name).'</h4>';
                                if (! $node->isRoot()) {
                                    $html .= '<p><div class="form-check form-switch form-switch-md"><input class="form-check-input"   type="checkbox" onchange="toggle(\'add_doc\','.$node->id.')" '.($node->add_doc ? 'checked' : '').'> </div><label class="mx-2" ">Insere Documentos?</label></p>';
                                    $html .= '<p><div class="form-check form-switch form-switch-md"><input class="form-check-input"   type="checkbox" onchange="toggle(\'add_law\','.$node->id.')" '.($node->add_law ? 'checked' : '').'> </div><label class="mx-2">Insere Projeto de lei?</label></p>';
                                    $html .= '<p><div class="form-check form-switch form-switch-md"><input class="form-check-input"   type="checkbox" onchange="toggle(\'add_advice\','.$node->id.')" '.($node->add_advice ? 'checked' : '').'> </div><label class="mx-2">Insere parecer?</label></p>';
                                    $html .= '<p><div class="form-check form-switch form-switch-md"><input class="form-check-input"   type="checkbox" onchange="toggle(\'add_obs\','.$node->id.')" '.($node->add_obs ? 'checked' : '').'> </div><label class="mx-2">Insere Campo de Obs?</label></p>';
                                }

                                $html .= '<div class="editable">
                                            <button type="button" class="btn btn-default btn-sm" data-item="'.($node->parent_id > 0 ? $node->parent_id : 0).'" data-number="'.($node->order + 1).'" data-method="post" data-action="store" data-title="Novo IRMAO de '.$node->name.'" data-toggle="modal" data-target="#myModal"><i class="fa fa-bars"></i> abaixo</i></button>
                                            <button type="button" class="btn btn-default btn-sm" data-item="'.$node->id.'" data-method="post" data-action="store" data-title="Novo FILHO de '.$node->name.'" data-toggle="modal" data-target="#myModal"><i class="fa fa-level-down"></i> filho</i></button>
                                            <button type="button" class="btn btn-default btn-sm" data-item="'.$node->id.'" data-method="put"  data-number="'.$node->order.'" data-name="'.$node->name.'" data-action="update" data-title="Editando '.$node->name.'" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> editar</i></button>
                                            <button type="button" class="btn btn-danger btn-sm"  onClick="deletaReg('.$node->id.')"><i class="fa fa-trash"></i> remover</i></button>
                                        </div>';

                                $html .= '</div>';
                                $html .= '<ol>';

                                foreach ($node->children as $child) {
                                    $html .= renderNode($child, $index, $level);
                                }

                                $html .= '</ol>';
                                $html .= '</li>';


                                return $html;
                            }
                            ?>
                            <div class="col-md-12">
                                <ul class="">
                                    @foreach($structurepautas as $reg)
                                        {!! renderNode($reg,0,0) !!}
                                    @endforeach
                                </ul>
                            </div>


                        @endif
                    </>
                </div>
            </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idModal" placeholder="id" class="form-control">
                    <div class="form-group col-sm-9">
                        <label>Nome:</label>
                        <input type="text" id="nameModal" class="form-control" placeholder="nome"/>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Ordem:</label>
                        <input type="text" id="numberModal" class="form-control" placeholder="ordem"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                    <button type="button" class="btn btn-success saveModal"><i class="fa fa-save"></i> Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        //$('.editable').hide();
        var routeGroup = "";
        var routeModel = "/structurepautas";
        var cc_title;
        var cc_name;
        var cc_item_id;
        var cc_action;
        var cc_method;

        var cc_url;


        var toggle = function(field,id)
        {
            var url = "/structurepauta/toggle/"+field+"/"+id;

            $.ajax({
                method: "GET",
                url: url
            }).success(function(result,textStatus,jqXHR) {
                if(result){

                }
            });
        }

        var deletaReg = function(id)
        {
            var url = '/version_pauta/{{$version_pauta->id}}/structurepauta/deleta/' + id;
            $.ajax({
                method: "GET",
                url: url
            }).success(function(result,textStatus,jqXHR) {
                if(JSON.parse(result)){
                    $('#struc_'+id).fadeOut(400);
                }
            });
        }



        $('#myModal').on('show.bs.modal', function(e) {
            $('#myModal .modal-dialog .modal-body #nameModal').val('');
            $('#myModal .modal-dialog .modal-body #type').val('');
            $('#myModal .modal-dialog .modal-body #numberModal').val('');
            cc_title    = e.relatedTarget.dataset.title;
            cc_name     = e.relatedTarget.dataset.name;
            cc_number   = e.relatedTarget.dataset.number;
            cc_action   = e.relatedTarget.dataset.action;
            cc_item_id  = e.relatedTarget.dataset.item;
            cc_method   = e.relatedTarget.dataset.method;

            cc_url = {
                store: routeGroup+routeModel,
                update: routeGroup+routeModel + '/' + cc_item_id,
                delete: routeGroup+routeModel + '/' + cc_item_id+"/delete"
            }


            $('#myModal .modal-dialog .modal-header .modal-title').html(cc_title);
            $('#myModal .modal-dialog .modal-body #idModal').val(cc_item_id);
            if(cc_name){
                $('#myModal .modal-dialog .modal-body #nameModal').val(cc_name)
            }

            if(cc_number){
                $('#myModal .modal-dialog .modal-body #numberModal').val(cc_number)
            }
            $('#nameModal').focus();

            $('.saveModal').on('click', function(){

                var data = {
                    _token: "{{ csrf_token() }}",
                    parent_id: $('#myModal .modal-dialog .modal-body #idModal').val(),
                    order: $('#myModal .modal-dialog .modal-body #numberModal').val(),
                    name: $('#myModal .modal-dialog .modal-body #nameModal').val(),
                    version_pauta_id: '{{$version_pauta->id}}'
                }
                sendAction(data);
            })

        });

        var sendAction = function(data){
            $.ajax({
                method: cc_method,
                url: cc_url[cc_action],
                dataType: "json",
                data: data
            }).success(function(result,textStatus,jqXHR) {
                if(result){
                    window.location.reload();
                }
            });
        }

        $(document).ready(function(){
            console.log(cc_url);

        });
    </script>
@endsection
