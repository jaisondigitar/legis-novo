@extends('layouts.meeting')
@section('content-meeting')
    <div class="">
        <h2>ESTADO DO PAINEL DE VOTAÇÃO</h2>
        <div class="col-md-12">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label style="width: 100%;">
                            PADRÃO
                            <span class="pull-right">
                                <input type="radio" class="pull-left radioBox" id="default" name="stage_panel" value="yes" checked onclick="changeStage('default')">
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            VOTAÇÃO
                            <span class="pull-right">
                                <input type="radio" class="pull-left radioBox" id="voting" name="stage_panel" value="no" onclick="changeStage('voting')">
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            RESUMO
                            <span class="pull-right">
                                <input type="radio" class="pull-left radioBox" id="resume" name="stage_panel" value="abstention" onclick="changeStage('resume')">
                            </span>
                        </label>
                    </li>
                    <li class="list-group-item">
                        <label  style="width: 100%;">
                            DISCURSO
                            <span class="pull-right">
                                <input type="radio" class="pull-left radioBox" id="discourse" name="stage_panel" value="discourse" onclick="changeStage('discourse')">
                            </span>
                        </label>
                    </li>
                </ul>
            </div><!-- /.panel-body -->
            <div class="clearfix"></div>
        </div>
    </div>

    <script>

        var changeStage = function (stage) {
                url = '/set-stage-panel'

                data = {
                    url: url,
                    stage: stage,
                    _token: '{{ csrf_token() }}'
                }

                $.ajax({
                    url: url,
                    data: data,
                    method: 'POST'
                }).success(function (data) {
                    data = JSON.parse(data);

                    if (data) {
                        toastr.success('Estado alterado com sucesso!')
                    } else {
                        toastr.error('Erro ao alterar estado!')
                    }
                })
            }

    </script>
@endsection