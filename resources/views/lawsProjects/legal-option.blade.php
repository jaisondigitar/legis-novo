@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.show') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        <div class="form-group col-sm-12">
            <div class="form-group">
                <a href="{!! route('lawsProjects.index') !!}" class="btn btn-default">Voltar</a>
            </div>
            <div class="panel panel-square panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i
                            class="fa fa-angle-double-right"
                            style="margin-right: 5px"
                        ></i>PARECERES
                    </h3>
                    <div class="right-content">
                        @if (Auth::user()->can_request_legal_option)
                            <div class="btn-group btn-group-xs">
                                <button
                                    type="button"
                                    class="btn btn-default btn-xs"
                                    data-toggle="modal"
                                    data-target="#newParecer"
                                    onclick="addChosen()"
                                >
                                    <i
                                        class="fa fa-plus"
                                        style="margin-right: 5px"
                                    ></i>SOLICITAR PARECER
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    @include('lawsProjects.tramites_table')
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="newParecer"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">PEDIDO DE DESTINO</h4>
                        <p>Projeto de Lei: {!!$lawsProject->project_number . '/' .$lawsProject->getYearLawPublish($lawsProject->law_date)!!}</p>
                    </div>
                    <div class="modal-body">
                        <label style="width: 100%" for="comissao">Selecione a comiss??o:</label>
                        <select style="width: 100%" class="form-control js-example-basic-multiple col-sm-12" id="comissao" name="comission" multiple="multiple">
                            @foreach($commissions as $commission)
                                <option value="c{{ $commission->id }}">{{ $commission->name }}</option>
                            @endforeach
                        </select>

                        <label>
                            Parecer Jur??dico:
                            <textarea
                                name="legal_option"
                                class="form-control descricao ckeditor"
                            ></textarea>
                        </label>

                        <label>
                            {!! Form::label('date_end', 'Prazo:') !!}
                            {!! Form::text('date_end', null, ['class' => 'form-control datepicker']) !!}
                        </label>

                        <label>
                            {!! Form::label('days', 'Dias:') !!}
                            {!! Form::number('days', null, ['class' => 'form-control', 'disabled']) !!}
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-default"
                            data-dismiss="modal"
                        >
                            Fechar
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="newAdvice({{ $lawsProject->id }})"
                        >
                            SOLICITAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        document.querySelector('#date_end').value = someDateFiveForm

        $('#date_end').on('change', () => {
            const date_first_split = $('#date_end').val().split('/').reverse().join('/')
            const date_last_split = dateForm.split('/').reverse().join('/')

            let day1 = new Date(date_last_split);
            let day2 = new Date(date_first_split);

            let difference= Math.abs(day2-day1);

            document.querySelector('#days').value = difference/(1000 * 3600 * 24)
        })

        $(document).ready(function () {
            setTimeout(function () {
                $('#comissao').addClass('chosen-select')
            },500);
        });

        var addChosen = function(){

            $('#comissao').addClass('chosen-select')

        };

        const newAdvice = (project_id) => {
            const url = "/advice/create";
            const laws_projects_id = project_id;
            const to_id = [];
            const type = [];
            const label = [];

            $('#comissao :selected').each((i, sel) =>{
                to_id[i] = $(sel).val().substr(1);
                type[i] = $(sel).val().substr(0,1);
                label[i] = $(sel).text();
            });

            const data = {
                date: dateForm + ' ' + timeForm,
                laws_projects_id: laws_projects_id,
                document_id: 0,
                to_id: to_id,
                type: type,
                legal_option: CKEDITOR.instances['legal_option'].getData(),
                date_end: $('#date_end').val(),
            };

            $.ajax({
                url: url,
                data: data,
                method: 'POST'
            }).success((data) => {
                if (data) {
                    toastr.success("Pedido salvo com sucesso!!");
                    window.location.reload()
                } else {
                    toastr.error("Erro ao salvar pedido!!");
                }
            })
        }

        const dataAtualFormatada = (data) => {
            let dia = data.getDate();
            if (dia.toString().length === 1)
                dia = "0"+dia;
            let mes = data.getMonth()+1;
            if (mes.toString().length === 1)
                mes = "0"+mes;
            let ano = data.getFullYear();
            return dia+"/"+mes+"/"+ano;
        }
    </script>
@endsection
