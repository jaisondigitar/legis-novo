<div class="row" align="center">
    <h3>Legislatura:</h3>
    <div class="col-md-5">
    </div>
    <div class="col-md-1">
        <div class="form-group">
                {!! Form::label('from', 'De:') !!}
                <p>{!! $legislature->from !!}</p>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            {!! Form::label('to', 'Até:') !!}
            <p>{!! $legislature->to !!}</p>
        </div>
    </div>
    <div class="col-md-5">
    </div>
</div>
<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-toolbar" role="toolbar">
                @shield('legislatures.edit')
                    <button type="button" class="btn btn-default" id="modalBtn"><i class="fa fa-plus-circle"></i> Novo registro</button>
                @endshield
            </div>
        </div>
    </div>
    <hr class="hr">
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group">
{{--        erro ao tentar acessar  $legislature_assemblyman as $item - $item->assemblyman->full_name       --}}
{{--                @foreach($legislature_assemblyman as $item)--}}
{{--                    <li class="list-group-item">--}}
{{--                        <i class="fa fa-angle"></i> {{ $item->assemblyman->full_name }}--}}
{{--                        <span class="pull-right">--}}
{{--                            @shield('legislatures.edit')--}}
{{--                                <a href="{!! route('legislatures.deleteAssemblyman', [$legislature->id .'/'.$item->assemblyman->id]) !!}" onclick="return confirm('Deseja deletar este registro?')">--}}
{{--                                    <button type="button" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Deletar</button>--}}
{{--                                </a>--}}
{{--                            @endshield--}}
{{--                        </span>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
            </ul>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center"><span class="glyphicon"></span> Adicionar parlamentares</h4>
            </div>
            {!! Form::open(['route' => ['legislatures.saveAssemblyman', $legislature->id], 'method' => 'post']) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6 col-lg-4">
                            {!! Form::label('assemblyman_id', 'Parlamentar:') !!}
                            @foreach($assemblyman as $item)
                               <p>
                                   {!! Form::checkbox('assemblyman_id[]', $item->id) !!}
                                   {{ $item->full_name }}
                               </p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-success pull-right"><span class="glyphicon glyphicon-off"></span> Salvar</button>
                    <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $("#modalBtn").click(function(){
            $("#myModal").modal();
        });
    });
</script>
