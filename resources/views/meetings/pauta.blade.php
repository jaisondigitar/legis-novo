@extends('layouts.meeting')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('meetings.list') !!}
@endsection
@section('content-meeting')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script src="/assets/js/jquery.mjs.nestedSortable.js"></script>
    <style>
        .container ul {
            list-style: none;
        }

        @media print {
            .noprint {
                display: none !important;
            }
        }

        .limheight {
            margin-bottom: 0px;
            -webkit-column-count: 3;
            -moz-column-count: 3;
            column-count: 3; /*3 in those rules is just placeholder -- can be anything*/
        }
        .limheight li {
            display: inline-block; /*necessary*/
            width: 100%;
        }
        .chosen-container{
            width: 100% !important;
        }

        .document_list{
            margin-left: 5px;
            font-style: italic;
            color : #999;
            text-align: justify;
        }

        .chosen-container .chosen-results li{
         height: 55px;
         }
    </style>
    <script>
        function imprimir() {

            var conteudo = document.getElementById('print').innerHTML;
            var tela = window.open('about:blank');
            tela.document.write(conteudo);
            tela.window.print();
            tela.window.close();
        }

    </script>
    <div class="" id="print">

        <div class="the-box rounded">
            <div class="col-md-9">
                <h2>Pauta da sessão</h2>
            </div>
            <div class="col-md-12">
                <a href="/meeting/pauta/{{ $meeting_id }}/pdf" target="_blank"><button class="pull-right btn btn-info btn-rounded-lg"><i class="fa fa-file-pdf-o"></i> GERAR PDF </button></a>
            </div>
            {{--<div class="col-md-3 noprint">--}}
                {{--<a href="" target="_blank"><button class="pull-right btn btn-info btn-rounded-lg" onclick="imprimir()"><i class="fa fa-file-pdf-o"></i> GERAR PDF </button></a>--}}
            {{--</div>--}}


            <div class="clearfix"></div>

            <?php
            function renderNode($node, $index, $level, $meeting_id)
            {
                $class = $level == 0 ? 'the-box rounded' : '';

                $html = '<hr> <li id="struc_'.$node->id.'" class="list-item"><div class="'.$class.'"><h4 style="margin-top:0px"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> '.($node->isRoot() ? strtoupper($node->name) : $node->name).'</h4>';

                /*
                 * $node->add_doc
                 * $node->add_law
                 * $node->add_ass
                 * $node->add_obs
                 */


                if ($level > 0) {
                    $html .= '<div class="col-md-2">';

                    if ($node->add_doc) {
                        $html .= '<button type="button" id="btn-add-doc" class="addDoc btn btn-block btn-sm btn-info" data-structure = "'.$node->id.'" data-toggle="modal" ><i class="fa fa-plus"></i> DOCUMENTO</button>';
                    }
                    if ($node->add_law) {
                        $html .= '<button type="button" class=" addLaw btn btn-block btn-sm btn-info"  data-structure = "'.$node->id.'" data-toggle="modal" ><i class="fa fa-plus"></i> PROJETO DE LEI</button>';
                    }
                    if ($node->add_advice) {
                        $html .= '<button type="button" class=" addAdvice btn btn-block btn-sm btn-info"  data-structure = "'.$node->id.'" data-toggle="modal" ><i class="fa fa-plus"></i> PARECER</button>';
                    }

//                    $html .= '<button type="button" onclick="addDocument()" class="btn btn-block btn-sm btn-info"><i class="fa fa-plus"></i> teste</button>';

                    $html .= '</div>';

                    $html .= '<div class="col-md-10">';

                    if ($node->add_doc || $node->add_law || $node->add_advice) {
                        $html .= '<table class="table table-striped table-responsive">
                                        <thead>
                                            <th>Descrição</th>
                                            <th width="60">Manutenção</th>
                                        </thead>
                                        <tbody id="document_'.$node->id.'">



                                        </tbody>
                                    </table>';
                    }

                    if ($node->add_ass) {
                        $ass = \App\Models\Assemblyman::where('active', 1)->orderBy('short_name', 'ASC')->get();
                        $html .= '<ul class="list-group">';
                        foreach ($ass as $par) {
                            $par->party_last = \App\Models\PartiesAssemblyman::where('assemblyman_id', $par->id)->orderBy('date', 'DESC')->first();
                            $par->responsibility_last = \App\Models\ResponsibilityAssemblyman::where('assemblyman_id', $par->id)->orderBy('date', 'DESC')->first();

                            $html .= '<li class="list-group-item">';
                            $html .= '<label>[___] '.$par->short_name;

                            if (! empty($par->party_last)) {
                                $html .= ' - '.$par->party_last->party->prefix;
                            }

                            if (! empty($par->responsibility_last)) {
                                $html .= ' ('.$par->responsibility_last->responsibility->name.')';
                            }

                            $html .= '</li>';
                            $html .= '<div class="clearfix"><div><div><div class="clearfix"><div>';
                        }
                        $html .= '</ul>';
                    }

                    if ($node->add_obs) {
                        $value = \App\Models\MeetingPauta::where('meeting_id', $meeting_id)
                            ->where('structure_id', $node->id)
                            ->whereNull('law_id')
                            ->whereNull('document_id')
                            ->whereNull('advice_id')
                            ->first();

                        $value1 = $value ? $value->description : '';


                        $html .= '<textarea class="form-control addObs ckeditor" data-structure="'.$node->id.'" id="obs_'.$node->id.'" rows="5">'.$value1.'</textarea>';
                        $html .= '<div style="margin-top: 5px; float: right;">';
                        if ($value) {
                            $html .= '<button class="btn btn-warning" onclick="limpaTexto('.$node->id.' , '.$value->id.') "  data-structure='.$node->id.' style="margin-right: 5px;"> Limpar Texto</button>';
                        }
                        $html .= '<button class="btn btn-info" data-structure='.$node->id.' onclick="salvaTexto('.$node->id.')"> Salvar Texto</button>';
                        $html .= '</div>';
                    }

                    $html .= '</div>';
                }


                if (count($node->children) > 0) {
                    $level++;
                    $html .= '<ul>';

                    foreach ($node->children as $child) {
                        $html .= renderNode($child, $index, $level, $meeting_id);
                    }

                    $html .= '<div class="clearfix"><div></div></ul>';
                }


                $html .= '<div class="clearfix"><div></div></div>';
                $html .= '<div class="clearfix"><div></div></li>';



                return $html;
            }
            ?>


            <div class="">
                <ul class="">
                    @foreach($structurepautas as $reg)
                        {!! renderNode($reg,0,0,$meeting_id) !!}
                    @endforeach
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-12 the-box rounded">
            <a href="/meetings"><button class="btn btn-default">Voltar</button></a>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ADICIONAR DOCUMENTO</h4>
                </div>
                <div class="modal-body" >
                    <div class="col-md-12 form-group">

                        <input type="hidden" class="form-control" name="meeting" id="meeting_doc" value="{{$meeting_id}}"> <br>


                        <input type="hidden" class="form-control" name="structure" id="struct_doc" ><br>


                        {!! Form::label('document_id', 'Documento:') !!}
                        {!! Form::select('document_id', $docs,null, ['class' => 'chosen form-control' ])!!}

                        {!! Form::label('observation', 'Observação:') !!}
                        {!! Form::textarea('observation', null, ['class' => 'form-control' ])!!}

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" onclick="addDocument()" class="btn btn-primary">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ADICIONAR PROJETOS DE LEI</h4>
                </div>
                <div class="modal-body" >
                    <div class="col-md-12 form-group">

                        <input type="hidden" class="form-control" name="meeting" id="meeting_law" value="{{$meeting_id}}"> <br>


                        <input type="hidden" class="form-control" name="structure" id="struct_law" ><br>


                        {!! Form::label('project_law_id', 'Projeto de lei:') !!}
                        {!! Form::select('project_law_id', $lawscreate,null, ['class' => 'chosen form-control' ])!!}
                        {!! Form::label('observation', 'Observação:') !!}
                        {!! Form::textarea('observation', null, ['id'=>'observation_law', 'class' => 'form-control' ])!!}

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" onclick="addProjectLaw()" class="btn btn-primary">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ADICIONAR PARECER</h4>
                </div>
                <div class="modal-body" >
                    <div class="col-md-12 form-group">

                        <input type="hidden" class="form-control" name="meeting" id="meeting_advice" value="{{$meeting_id}}"> <br>
                        <input type="hidden" class="form-control" name="structure" id="struct_advice" ><br>

                        {!! Form::label('advice_id', 'Parecer:') !!}
                        {!! Form::select('advice_id', $advices,null, ['class' => 'chosen form-control' ])!!}

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" onclick="addAdvices()" class="btn btn-primary">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        var showFields = function (id, struct, texto, observation) {
            observation = observation ? observation :'';
            var tb = $('#document_' + struct);
            var str1  = '<tr id="document_row_'+ id +'"> ';
                str1 += '<td>'+ texto +'<br>';
                str1 += '<div class="document_list"> Observação - ' + observation + '</div>';
                str1 += '</td> ';
                str1 += '<td><button type="button" onclick="removeRow('+ id +')" class="btn btn-danger btn-xs">Remover</button></td> ' ;
                str1 += '</tr>';
            tb.append(str1);
        }
    </script>


    <?php
        function loadText($p)
        {
            if ($p->document_id) {
                $documts = \App\Models\Document::where('id', $p->document_id)->first();
                $texto = '<b>DOCUMENTO :</b> <br>'.'<span class="text-muted">'.$documts->number.'/'.$documts->getYear($documts->date).' '.($documts->document_type->parent_id ? $documts->document_type->parent->name.'::'.$documts->document_type->name : $documts->document_type->name).' - '.$documts->owner->short_name.'</span>';

                return $texto;
            }

            if ($p->law_id) {
                $law = \App\Models\LawsProject::where('id', $p->law_id)->first();
                $texto = '<b>PROJETO DE LEI :</b> <br>'.'<span class="text-muted">'.$law->project_number.'/'.$law->getYearLawPublish($law->law_date).' '.$law->law_type->name.' - '.($law->assemblyman_id ? $law->owner->short_name : '').'</span>';

                return $texto;
            }

            if ($p->advice_id) {
                $advice = \App\Models\Advice::where('id', $p->advice_id)->first();
                $texto = '<b>'.$advice->commission->name.' :</b><br>';
                if ($advice->laws_projects_id > 0) {
                    $texto .= '<span class="text-muted">'.$advice->project->project_number.'/'.$advice->project->getYearLawPublish($advice->project->law_date).' '.$advice->project->law_type->name.' - '.($advice->project->assemblyman_id ? $advice->project->owner->short_name : '').'</span>';
                }
                if ($advice->document_id > 0) {
                    $texto .= '<span class="text-muted">'.$advice->document->number.'/'.$advice->document->getYear($advice->document->date).' '.($advice->document->document_type->parent_id ? $advice->document->document_type->parent->name.'::'.$advice->document->document_type->name : $advice->document->document_type->name).' - '.$advice->document->owner->short_name.'</span>';
                }

                return $texto;
            }
        }
    ?>

    @foreach($pautas as $p)

        <script>
            showFields('{{$p->id}}', '{{$p->structure_id}}','{!! loadText($p) !!}', '{{ substr($p->observation, 0,255) }}');
        </script>

    @endforeach


    <script>

        var idMeetingPauta = 0;

        $(document).ready(function () {
            $('.addDoc').on('click', function () {
                var structId= $(this).data('structure');
                $(".modal-body #struct_doc").val( structId );
                $('#myModal').modal();
            });

            $('.addLaw').on('click', function () {
                var structId= $(this).data('structure');
                $(".modal-body #struct_law").val( structId );
                $('#myModal1').modal();
            });

            $('.addAdvice').on('click', function () {
                var structId= $(this).data('structure');
                $(".modal-body #struct_advice").val( structId );
                $('#myModal2').modal();
            });

            $('.chosen').chosen();
        });

        var addDocument = function()
        {
            var doc = $('#document_id option:selected');
            var meet = $('#meeting_doc').val();
            var struct = $('#struct_doc').val();
            var cmp = $('#document_' + struct);
            var obs = $('#observation').val();

            salvaDoc(meet, struct,0,doc.val(),0,'',obs,function (data) {
                var tpl = getTemplate(data,meet, doc.html(), obs);
                cmp.append(tpl);
                $('#observation').val('');
            });

        };


        var limpaTexto = function (struct, id) {
            var meet = $('#meeting_doc').val();
            $('#obs_' + struct).val('');
            removeDoc(id);
            window.location.reload();
        }

        var salvaTexto = function (struct) {

            var meet = $('#meeting_doc').val();
            var obs = CKEDITOR.instances['obs_'+struct].getData();

            salvaDoc(meet, struct,0,0,0,obs,function (data) {
                window.location.reload();
                toastr.success('Pauta salva com sucesso!');
            });
        }


        var salvaDoc = function (meet, struct, law, document,advice,description,obs,callback) {

            url = '/meetings/addDocument';

            var data = {
                meeting_id: meet,
                structure_id: struct,
                law_id: law,
                document_id: document,
                advice_id: advice,
                description: description,
                observation: obs
            };

            $.ajax({
                method: "POST",
                url: url,
                data: data
            }).success(function (data) {
                if (data){
                    callback(data)
                }
            });
        };


        var addProjectLaw = function()
        {

            var doc = $('#project_law_id option:selected');
            var meet = $('#meeting_law').val();
            var struct = $('#struct_law').val();
            var cmp = $('#document_' + struct);
            var obs = $('#observation_law').val();


            salvaDoc(meet, struct,doc.val(),0,0,'',obs,function (data) {
                var tpl = getTemplateLaw(data,meet, doc.html(), obs);
                cmp.append(tpl);
                $('#observation_law').val('');
            });
        };

        var addAdvices = function()
        {

            var doc = $('#advice_id option:selected');
            var meet = $('#meeting_law').val();
            var struct = $('#struct_advice').val();
            var cmp = $('#document_' + struct);

            salvaDoc(meet, struct,0,0,doc.val(),'', '',function (data) {
                var tpl = getTemplateAdvice(data,meet, doc.html());
                cmp.append(tpl);
            });
        };

        const removeRow = (id) => {
            const url = `/meetings/removeDocument/${id}`  ;

            Swal.fire({
                title: 'Excluir Documento?',
                text: "Não será possivel desfazer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: "GET"
                    }).success(function (data) {
                        data = JSON.parse(data);
                        if (data){
                            $('#document_row_' + id).fadeOut(400, function () {
                                $(this).remove();
                            });
                        }else{
                            toastr.error('Registro possui votação, não pode ser excluido!');
                        }
                    });
                }
            })
        };

        var getTemplate = function(id,number,type,obs)
        {
            type  = type.split(':');
            var mp_id = null;

            if(id.search(',') > 0) {
                m_p = id.split(',');
                if(m_p[9].search(':') > 0) {
                    m_p_id = m_p[9].split(':');
                    mp_id = m_p_id[1];
                    if(mp_id.search('}') > 0){
                        mp_id = mp_id.replace('}', '');
                    }
                }
            }else {
                mp_id = id;
            }

            if($('#document_row_'+ mp_id).length == 0) {
                var str =   '<tr id="document_row_'+ mp_id +'"> ' ;
                str +=  '<td>';
                str += '<b>' + type[0] + ' :</b> <br>';
                str += '<span class="text-muted">' + type[1]+ '::' + type[3] + '</span>';
                if(obs.length > 0) {
                    str += '<div class="document_list">Observação - ' + obs + '</div>';
                }
                str +=  '</td> ' ;
                str +=  '<td><button type="button" onclick="removeRow('+ mp_id +')" class="btn btn-sm btn-danger">Remover</button></td>';
                str +=  '</tr>';

                return str;
            }else{
                toastr.error('Documento já esta vinculado a pauta!');
            }


        };

        var getTemplateAdvice = function(id,number,type,obs)
        {
            type  = type.split(':');
            var mp_id = null;

            if(id.search(',') > 0) {
                m_p = id.split(',');
                if(m_p[9].search(':') > 0) {
                    m_p_id = m_p[9].split(':');
                    mp_id = m_p_id[1];
                    if(mp_id.search('}') > 0){
                        mp_id = mp_id.replace('}', '');
                    }
                }
            }else {
                mp_id = id;
            }

            if($('#document_row_'+ mp_id).length == 0) {
                var str =   '<tr id="document_row_'+ mp_id +'"> ' ;
                str +=  '<td>';
                str += '<b>' + type[0] + ' :</b> <br>';
                str += '<span class="text-muted">' + type[2] + '</span>';
                // if(obs != '') {
                //     str += '<div class="document_list">Observação - ' + obs + '</div>';
                // }
                str +=  '</td> ' ;
                str +=  '<td><button type="button" onclick="removeRow('+ mp_id +')" class="btn btn-danger btn-xs">Remover</button></td> ' ;
                str +=  '</tr>';

                return str;
            }else{
                toastr.error('Parecer já esta vinculado a pauta!');
            }


        };

        var getTemplateLaw = function(id,number,type,obs)
        {
            type  = type.split(':');
            var mp_id = null;

            if(id.search(',') > 0) {
                m_p = id.split(',');
                if(m_p[9].search(':') > 0) {
                    m_p_id = m_p[9].split(':');
                    mp_id = m_p_id[1];
                    if(mp_id.search('}') > 0){
                        mp_id = mp_id.replace('}', '');
                    }
                }
            }else {
                mp_id = id;
            }

            if($('#document_row_'+ mp_id).length == 0) {
                var str = '<tr id="document_row_' + mp_id + '"> ';
                    str += '<td>';
                    str += '<b>' + type[0] + ' :</b> <br>';
                    str += '<span class="text-muted">' + type[1] + '</span>';

                if (obs != '') {
                    str += '<div class="document_list">Observação - ' + obs + '</div>';
                }
                str += '</td> ';
                str += '<td><button type="button" onclick="removeRow(' + mp_id + ')" class="btn btn-danger btn-xs">Remover</button></td> ';
                str += '</tr>';

                return str;
            }else{
                toastr.error('Projeto de lei já esta vinculada a pauta!');
            }
        };
    </script>
@endsection

<script type="text/javascript">
    function deleteConfirmation(id) {
        swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "{{url('/delete')}}/" + id,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                }).then((results) => {
                    swal("Done!", results.message, "success");
                }).catch((error) => {
                    swal("Error!", results.message, "error");
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }
</script>
