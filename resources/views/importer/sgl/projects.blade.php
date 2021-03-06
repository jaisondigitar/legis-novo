@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('company.list') !!}
@endsection
@section('content')
  <link href="/assets/css/jquery-loading.css" rel="stylesheet">
  <style media="screen">
  .js-loading-overlay {
    background-color: rgba(0,0,0,.7);
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
  }
  </style>
  <div id="spin2"></div>
    <div class="the-box rounded">
        <h2 style="margin-top: 5px">Importador de projetos de lei</h2>
        <p><strong>Como usar:</strong> Faça download da planilha de padrão de importação. Com a planilha preenchida, selecione o tipo de documento, selecione o arquivo e clique em importar.</p>
        <p><strong>Download da planilha padrão</strong> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="/demoimport/ImportProjectDemoLEGIS.xlsx">Planilha demo</a></p>
        <p><a href="javascript:void(0)" data-toggle="modal" data-target="#demoplanilha" ><i class="fa fa-info-circle" aria-hidden="true"></i> Manual da planilha</a></p>
        <hr>
         <form action="/importer/projects/import" onSubmit="return importar()" method="post" enctype="multipart/form-data">
           {!! Form::token() !!}
          <div class="col-md-12 importa">

            <div class="col-md-4">

              <div class="col-md-12">
                <h3>Tipo de projetos</h3>
                <ul>
                @foreach ($documentType as $key => $value)
                  <li>
                    <label>
                      <input type="radio" name="type" value="{{ $key }}">
                      {{ $value }}
                    </label>
                  </li>
                @endforeach
                </ul>
              </div>

            </div>
            <div class="col-md-8">
                <div class="col-md-12">
                  <h3>Importador</h3>
                  @include('flash::message')
                  <label>Selecione o arquivo:</label>
                  <input name="file" type="file" class="form-control"/>
                </br>
                  <label><input type="checkbox" name="is_approved" value="1"> Marcar todos como aprovados.</label>
                  <hr>
                  <button type="submit" class="btn btn-primary"  name="import"> <i class="fa fa-upload"></i> IMPORTAR</button>
                </div>
              </div>
          </div>

        </form>

        <div class="clearfix">

        </div>
    </div>

    <div class="modal fade" id="demoplanilha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">MANUAL DA PLANILHA DE IMPORTAÇÃO</h4>
      </div>
      <div class="modal-body">
        <p><strong>Colunas da planilha de importação de documentos</strong></p>
        <ul>
          <li><strong>date</strong>: Data do projeto de lei  no formato d/m/aaaa</li>
          <li><strong>numberproject</strong>: Numero do projeto de lei no formato numero/ano</li>
          <li><strong>owners</strong>: Código do parlamentar no software LEGIS. Se mais de 1 autor, separe por vírgula (,). O primeiro código será o autor responsável, os demais serão co-autores.</li>
          <li><strong>title</strong>: Ementa do projeto de lei</li>
          <li><strong>protocoldate</strong>: Data do protocolo no formato d/m/aaaa</li>
          <li><strong>protocolnumber</strong>: Numero do protocolo sem ano</li>
          <li><strong>prefix</strong>: Preâmbulo do projeto de lei</li>
          <li><strong>sufix</strong>: Observação do projeto de lei</li>
          <li><strong>justify</strong>: Justificativa do projeto de lei</li>
        </ul>
        <p class="text-danger">** Todos documentos importados, serão considerados lidos e receberão um numero de protocolo automatico.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script src="/assets//js/jquery-loading.js"></script>
<script type="text/javascript">

  var prepareUpload = function(event)
  {
    files = event.target.files;
    console.log(files);
  }

  var importar = function()
  {

    if(validaDados())
    {
      return true;

    }else{

      alert('Verifique se você selecionou o tipo de documento e também selecionou o arquivo do tipo excel.')

      return false;
    }

  }

  var validaDados = function()
  {

    var type      = $('input[name=type]:checked').val();
    var document  = $('input[name=file]')[0].files[0];

    if(!type || !document)
    {
      return false;
    }

    return true;

  }

</script>
@endsection
