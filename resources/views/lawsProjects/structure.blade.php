@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.new') !!}
@endsection
@section('content')
    <style>
        .modal-dialog  {
            width: 90%;
        }
    </style>
<div class="row">
    @include('common.errors')
    <div class="container">
        <div class="col-md-12 the-box rounded">
            <h2>{{ $law_project->title }}</h2>
            <span>{{ $law_project->law_type->name }}</span>
        </div>
        <div class="col-md-12 the-box rounded">
            <div class="row">
                <div class="col-md-12">
                    @if(count($structure_laws) == 0)
                        <div class="well text-center">Sem dados. Insira um novo registro.</div>
                    @else
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css"/>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
                        <script src="/assets/js/jquery.mjs.nestedSortable.js"></script>
                        <style>
                            .the-box{
                                margin-bottom: 3px;
                            }
                            ol {
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
                            if ($node->isLeaf()) {
                                $html = '<li id="'.$node->id.'" class="list-item"><div class="the-box rounded"><strong>'.
                                        (isset($node->type) ? $node->type->showName() : '')
                                        .' '
                                        .($node->number ? $node->number : '')
                                        .':</strong> '
                                        .$node->content;
                                if (! $node->isRoot()) {
                                    $html .= '
            <div class="editable">
            <button type="button" class="editable btn btn-xs btn-info" data-item="'.$node->parent_id.'" data-method="post" data-action="store" data-title="Novo IRMAO" data-toggle="modal" data-target="#myModal"><i class="fa fa-bars"></i> abaixo</i></button>
            <button type="button" class="editable btn btn-xs btn-primary" data-item="'.$node->id.'" data-method="post" data-action="store" data-title="Novo FILHO" data-toggle="modal" data-target="#myModal"><i class="fa fa-level-down"></i> filho</i></button>
            <button type="button" class="editable btn btn-xs btn-warning" data-item="'.$node->id.'" data-method="put" data-type="'.$node->law_structure_id.'" data-number="'.$node->number.'" data-name="'.strip_tags($node->content).'" data-action="update" data-title="Editando" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> editar</i></button>
            <button type="button" class="editable btn btn-xs btn-danger"  onClick="deletaReg('.$node->id.')"><i class="fa fa-remove"></i> remover</i></button>
            </div>';
                                } else {
                                    $html .= '<div class="editable">
            <button type="button" class="editable btn btn-xs btn-primary" data-item="'.$node->id.'" data-method="post" data-action="store" data-title="Novo FILHO" data-toggle="modal" data-target="#myModal"><i class="fa fa-level-down"></i> filho</i></button>
            </div>';
                                }
                                $html .= '</div></li>';

                                return $html;
                            } else {
                                $html = '<li id="'.$node->id.'" class="list-item"><div class="the-box rounded"><strong>'.(isset($node->type) ? $node->type->showName() : '').' '.($node->number ? $node->number : '').':</strong> '.$node->content;
                                if (! $node->isRoot()) {
                                    $html .= '
            <div class="editable">
                <button type="button" class="btn btn-xs btn-info" data-item="'.$node->parent_id.'" data-method="post" data-action="store" data-title="Novo IRMAO" data-toggle="modal" data-target="#myModal"><i class="fa fa-bars"></i> abaixo</i></button>
                <button type="button" class="btn btn-xs btn-primary" data-item="'.$node->id.'" data-method="post" data-action="store" data-title="Novo FILHO" data-toggle="modal" data-target="#myModal"><i class="fa fa-level-down"></i> filho</i></button>
                <button type="button" class="btn btn-xs btn-warning" data-item="'.$node->id.'" data-method="put" data-type="'.$node->law_structure_id.'" data-number="'.$node->number.'" data-name="'.strip_tags($node->content).'" data-action="update" data-title="Editando" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> editar</i></button>
                <button type="button" class="btn btn-xs btn-danger"  onClick="deletaReg('.$node->id.')"><i class="fa fa-remove"></i> remover</i></button>
            </div>';
                                } else {
                                    $html .= '<div class="editable">
            <button type="button" class="editable btn btn-xs btn-primary" data-item="'.$node->id.'" data-method="post" data-action="store" data-title="Novo FILHO" data-toggle="modal" data-target="#myModal"><i class="fa fa-level-down"></i> filho</i></button>
            </div>';
                                }
                                $html .= '</div>';
                                $html .= '<ol>';

                                $actual_node = $node->children()
                                    ->orderBy('law_structure_id')
                                    ->orderBy('number')
                                    ->get();

                                foreach ($actual_node as $child) {
                                    $html .= renderNode($child, $index, $level);
                                }

                                $html .= '</ol>';
                                $html .= '</li>';
                            }

                            return $html;
                        }
                        ?>
                        <div class="col-md-12">
                            <ul class="">
                                @foreach($structure_laws as $reg)
                                    {!! renderNode($reg,0,0) !!}
                                @endforeach
                            </ul>
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
                                            <select name="type" id="type" class="form-control">
                                                @foreach($laws_structure_types as $key=>$reg)
                                                    <option value="{{ $key }}">{{ $reg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <input type="text" id="numberModal" class="form-control" placeholder="número"/>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <textarea id="nameModal" class="form-control ckeditor" rows="10"></textarea>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>
                                        <button type="button" class="btn btn-primary saveModal"><i class="fa fa-save"></i> Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>

                            //$('.editable').hide();
                            var routeGroup = "";
                            var routeModel = "/structureLaws";
                            var cc_title;
                            var cc_name;
                            var cc_item_id;
                            var cc_action;
                            var cc_method;

                            var cc_url;


                            var deletaReg = function(id){
                                cc_title    = "";
                                cc_name     = "";
                                cc_action   = "delete";
                                cc_item_id  = id;
                                cc_method   = "GET";

                                cc_url = {
                                    store: routeGroup+routeModel,
                                    update: routeGroup+routeModel+"/"+cc_item_id,
                                    delete: routeGroup+routeModel+"/"+cc_item_id+"/delete"
                                }

                                if(confirm('Tem certeza?')){
                                    sendAction(null);
                                }

                            }

                            $('#myModal').on('show.bs.modal', function(e) {


                                $('#myModal .modal-dialog .modal-body #type').val('');
                                $('#myModal .modal-dialog .modal-body #numberModal').val('');
                                cc_title    = e.relatedTarget.dataset.title;
                                cc_name     = e.relatedTarget.dataset.name;
                                cc_type     = e.relatedTarget.dataset.type;
                                cc_number   = e.relatedTarget.dataset.number;
                                cc_action   = e.relatedTarget.dataset.action;
                                cc_item_id  = e.relatedTarget.dataset.item;
                                cc_method   = e.relatedTarget.dataset.method;

                                if(cc_method=="post")
                                {
                                    CKEDITOR.instances['nameModal'].setData("");
                                }

                                cc_url = {
                                    store: routeGroup+routeModel,
                                    update: routeGroup+routeModel+"/"+cc_item_id,
                                    delete: routeGroup+routeModel+"/"+cc_item_id+"/delete"
                                }

                                $('#myModal .modal-dialog .modal-header .modal-title').html(cc_title);
                                $('#myModal .modal-dialog .modal-body #idModal').val(cc_item_id);

                                if(cc_name){
                                    console.log(cc_name)
                                    CKEDITOR.instances['nameModal'].setData(cc_name);
                                }

                                if(cc_type){
                                    $('#myModal .modal-dialog .modal-body #type').val(cc_type)
                                }

                                if(cc_number){
                                    $('#myModal .modal-dialog .modal-body #numberModal').val(cc_number)
                                }

                                $('.saveModal').on('click', function(){


                                    var data = {
                                        _token: "{{ csrf_token() }}",
                                        law_id: "{{ $law_project->id }}",
                                        parent_id: $('#myModal .modal-dialog .modal-body #idModal').val(),
                                        type: $('#myModal .modal-dialog .modal-body #type').val(),
                                        number: $('#myModal .modal-dialog .modal-body #numberModal').val(),
                                        content: CKEDITOR.instances['nameModal'].getData()
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

                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 the-box rounded">
            <a href="/lawsProjects"><button class="btn btn-default">Voltar à lista de projetos</button></a>
        </div>
    </div>
</div>
@endsection
