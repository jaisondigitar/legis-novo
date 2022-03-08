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
                    <div class="card card-square card-default">
                        <div class="card-header">
                            <div class="row">
                                <h4 class="card-title col-md-10"><i class="fa fa-angle-double-right"></i> PEDIDO DE PARECERES</h4>
                                <div class="right-content col-md-2">
                                    <div class="btn-group btn-group-xs">
                                        <button type="button" class="btn btn-default btn-xs" data-bs-toggle="modal" data-bs-target="#newParecer" style="font-size: 13px">
                                            <i class="fa fa-plus"></i> SOLICITAR PARECER
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('documents.tramites_table')
                        </div><!-- /.card-body -->
                    </div>
                </div>

                <div class="modal fade" id="newParecer" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">PEDIDO DE DESTINO</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

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
                                    Parecer Jurídico:
                                    <textarea
                                        name="legal_option"
                                        class="form-control descricao ckeditor"
                                    ></textarea>
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-bs-dismiss="modal">FECHAR</button>
                                <button type="button" class="btn btn-success pull-right" onclick="newAdvice({{ $document->id }})">SOLICITAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        @endif
    </div>

    <script>
        const newAdvice = (document_id) => {
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
                date: dateForm + ' ' + timeForm,
                document_id: document_id,
                laws_projects_id: 0,
                to_id: to_id,
                type: type,
                legal_option: CKEDITOR.instances['legal_option'].getData(),
                date_end: null
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
