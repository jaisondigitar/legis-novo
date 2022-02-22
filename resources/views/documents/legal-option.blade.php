@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.show') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="form-group">
            <a href="{!! route('documents.index') !!}" class="btn btn-default">Voltar</a>
        </div>

        @if(isset($document))
            <div class="the-box rounded">
                <div class="form-group col-sm-12">
                    <div class="panel panel-square panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-angle-double-right"></i> PEDIDO DE PARECERES</h3>
                            <div class="right-content">
                                <div class="btn-group btn-group-xs">
                                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                            data-target="#newParecer" onclick="addChosen()">
                                        <i class="fa fa-plus"></i> SOLICITAR PARECER
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('documents.tramites_table')
                        </div><!-- /.panel-body -->
                    </div>
                </div>

                <div class="modal fade" id="newParecer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">PEDIDO DE DESTINO</h4>
                                <p>Documento: {!! $document->number. '/' . $document->getYear($document->date) !!}</p>
                            </div>
                            <div class="modal-body">
                                <label style="width: 100%">
                                    Selecione a comissão:
                                    <select class="form-control destination" multiple name="comission" id="comissao">
                                        <optgroup label="Comissões">
                                            @foreach(\App\Models\Commission::active()->get() as $comission)
                                                <option value="c{{ $comission->id }}">{{ $comission->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </label>

                                <label>
                                    Descrição:
                                    <textarea
                                        name="comissionDescriprion"
                                        class="form-control descricao ckeditor"
                                    ></textarea>
                                </label>

                                <label>
                                    Parecer Jurídico:
                                    <textarea
                                        name="legal_option"
                                        class="form-control descricao ckeditor"
                                    ></textarea>
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary" onclick="newAdvice({{ $document->id }})">
                                    SOLICITAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('#comissao').addClass('chosen-select')
            }, 500);
        });

        var addChosen = function () {
            $('#comissao').addClass('chosen-select')
        };

        var newAdvice = function (document_id) {
            var url = "/advice/create";
            var document_id = document_id;
            var to_id = [];
            var type = [];
            var label = [];

            $('#comissao :selected').each(function (i, sel) {
                to_id[i] = $(sel).val().substr(1);
                type[i] = $(sel).val().substr(0, 1);
                label[i] = $(sel).text();
            });

            const data = {
                document_id: document_id,
                laws_projects_id: 0,
                to_id: to_id,
                type: type,
                description: CKEDITOR.instances['comissionDescriprion'].getData(),
                legal_option: CKEDITOR.instances['legal_option'].getData(),
                date_end: null,
            };

            if (to_id.length > 0) {
                $.ajax({
                    url: url,
                    data: data,
                    method: 'POST'
                }).success(function (data) {
                    if (data) {
                        toastr.success("Pedido salvo com sucesso!!");
                        window.location.reload()
                    } else {
                        toastr.error("Erro ao salvar pedido!!");
                    }
                })
            } else {
                toastr.error('Selecione um destino!');
            }
        }

        function dataAtualFormatada(data) {
            var dia = data.getDate();
            if (dia.toString().length == 1)
                dia = "0" + dia;
            var mes = data.getMonth() + 1;
            if (mes.toString().length == 1)
                mes = "0" + mes;
            var ano = data.getFullYear();
            return dia + "/" + mes + "/" + ano;
        }
    </script>
@endsection
