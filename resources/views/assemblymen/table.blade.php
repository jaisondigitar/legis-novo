<table class="table table-responsive" id="assemblymen-table">
    <thead>
        <th>Código</th>
        <th>Nome Parlamentar</th>
        <th>E-mail</th>
        <th>Responsabilidade</th>
        <th>Legislatura</th>
        <th>Ativo</th>
        <th colspan="3">Manutenção</th>
    </thead>
    <tbody>
    @foreach($assemblymen as $assemblyman)
        <tr>
            <td>#{!! $assemblyman->id !!}</td>
            <td>{!! $assemblyman->short_name !!} -
                @if(!empty($assemblyman->party_last))
                    {{$assemblyman->party_last->party->prefix}}
                @endif
            </td>

            <td>{!! $assemblyman->email !!}</td>
            <td>
                @if(!empty($assemblyman->responsibility_last))
                    {{$assemblyman->responsibility_last->responsibility->name}}
                @endif
            </td>
            <td>
                @if(!empty($assemblyman->legislature_last))
                    {{ date('Y', strtotime($assemblyman->legislature_last->from)) }}
                    -
                    {{ date('Y', strtotime($assemblyman->legislature_last->to)) }}
                @endif
            </td>
            <td>
                @shield('assemblymen.edit')
                <input class="switch" onchange="changeStatus('{!! $assemblyman->id !!}')" data-on-text="Sim" data-off-text="Não" data-off-color="danger" data-on-color="success" data-size="normal"  type="checkbox" {!! $assemblyman->active>0?'checked':'' !!}>
                @endshield
            </td>
            <td>
                <div class='btn-group' style="min-width: 200px">
                    @shield('assemblymen.show')
                        <button
                            @popper(Legislaturas) type="button" class='btn btn-default btn-xs listLegislatures' value="{{$assemblyman->id}}">
                            L
                        </button>
                    @endshield
                    @shield('assemblymen.show')
                    <button
                        @popper(Partidos) type="button" class='btn btn-default btn-xs listParties' value="{{$assemblyman->id}}">
                        P
                    </button>
                    @endshield
                    @shield('assemblymen.show')
                    <button
                        @popper(Responsabilidades) type="button" class='btn btn-default btn-xs listResponsibilities' value="{{$assemblyman->id}}">
                        R
                    </button>
                    @endshield
                    @shield('assemblymen.show')<a @popper(Visualizar) href="{!! route('assemblymen.show', [$assemblyman->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-eye"></i></a>@endshield
                    @shield('assemblymen.edit')<a @popper(Editar) href="{!! route('assemblymen.edit', [$assemblyman->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>@endshield
                    @shield('assemblymen.delete')
                        {!! Form::open(['route' => ['assemblymen.destroy', $assemblyman->id], 'method' => 'delete']) !!}
                        <a
                            @popper(Deletar)
                            type = "submit"
                            class = 'btn btn-danger btn-xs'
                            onclick="sweet(event, {!! $assemblyman->id !!})"
                        >
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                        {!! Form::close() !!}
                    @endshield
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="modal fade" id="listResultModalLegislature" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center"><span class="glyphicon"></span> Histórico</h4>
            </div>
            <div class="modal-body">
                <button class="btn btn-info" id="addLegislatures">Adicionar</button>
                {!! Form::open(['route' => 'assemblymen.addLegislatures']) !!}
                    <div id="addLegislaturesInput"></div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12 listResult"></div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="listResultModalParties" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center"><span class="glyphicon"></span> Histórico</h4>
            </div>
            <div class="modal-body">
                <button class="btn btn-info" id="addParty">Adicionar</button>
                {!! Form::open(['route' => 'assemblymen.addParties']) !!}
                <div id="addPartiesInput"></div>
                <div class="row">
                    <div class="form-group col-sm-12 col-lg-12 listResult"></div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="listResultModalResponsibilities" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 align="center"><span class="glyphicon"></span> Histórico</h4>
            </div>
            <div class="modal-body">
                <button class="btn btn-info" id="addResponsibility">Adicionar</button>
                {!! Form::open(['route' => 'assemblymen.addResponsibilities']) !!}
                    <div id="addResponsibilitiesInput"></div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-lg-12 listResult"></div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>

    var changeStatus = function(id)
    {
        var url = '/assemblymen/'+id+'/toggle';
        $.ajax({
            method: "GET",
            url: url,
            dataType: "json"
        }).success(function(result,textStatus,jqXHR) {
            console.log(result);
        });
    }

    function removeLegislatures(legislature_id, assemblyman_id)
    {
        var isGood = confirm('Deseja realmente apagar a legislatura do parlamentar?');
        if (isGood) {
            $.ajax({
                url: "{{ url('assemblymen/removeLegislatures') }}/" + legislature_id + "/" + assemblyman_id,
                type: 'GET',
                dataType: 'json',
            })
            .done(function (result) {
                if(result.data == 'success')
                    $("#listResultModalLegislature").modal('hide');
            })
            .fail(function () {
            });
        }
    }

    function removeParties(party_id, assemblyman_id)
    {
        var isGood = confirm('Deseja realmente apagar o partido do parlamentar?');
        if (isGood) {
            $.ajax({
                url: "{{ url('assemblymen/removeParty') }}/" + party_id + "/" + assemblyman_id,
                type: 'GET',
                dataType: 'json',
            })
            .done(function (result) {
                if(result.data == 'success')
                $("#listResultModalParties").modal('hide');
            })
            .fail(function () {
            });
        }
    }

    function removeResponsibilities(responsibility_id, assemblyman_id)
    {
        var isGood = confirm('Deseja realmente apagar a responsabilidade do parlamentar?');
        if (isGood) {
            $.ajax({
                url: "{{ url('assemblymen/removeResponsibility') }}/" + responsibility_id + "/" + assemblyman_id,
                type: 'GET',
                dataType: 'json',
            })
            .done(function (result) {
                if(result.data == 'success')
                $("#listResultModalResponsibilities").modal('hide');
            })
            .fail(function () {
            });
        }
    }

    $(document).ready(function(){

        $("#addLegislatures").click(function(){
            $("#addLegislaturesInput").append(`
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('legislature_id', 'Legislatura:', ['class' => 'small-title']) !!}
                        {!! Form::select('legislature_id', $legislatures, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <button class='btn btn-success' type='submit'>Salvar</button>
                    </div>
                </div>
            `);
            $('.datepicker').mask('99/99/9999');
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR'
            });
        });

        $("#addParty").click(function(){
            $("#addPartiesInput").append(`
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('party_id', 'Partidos:', ['class' => 'small-title']) !!}
                        {!! Form::select('party_id', $parties, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('party_date', 'Data:') !!}
                        {!! Form::text('party_date', isset($assemblyman) ? null : \Carbon\Carbon::now()->format('d/m/Y'),['class' => 'form-control datepicker']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <button class='btn btn-success' type='submit'>Salvar</button>
                    </div>
                </div>
            `);
            $('.datepicker').mask('99/99/9999');
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR'
            });
        });

        $("#addResponsibility").click(function(){
            $("#addResponsibilitiesInput").append(`
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('responsibility_id', 'Responsabilidade:', ['class' => 'small-title']) !!}
                        {!! Form::select('responsibility_id', $responsibilities, null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('responsibility_date', 'Data:') !!}
                        {!! Form::text('responsibility_date', isset($assemblyman) ? null : \Carbon\Carbon::now()->format('d/m/Y'), ['class' => 'form-control datepicker']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <button class='btn btn-success' type='submit'>Salvar</button>
                    </div>
                </div>
            `);
            $('.datepicker').mask('99/99/9999');
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR'
            });
        });

        $(".listLegislatures").click(function(){
            $(".listResult").empty();
            $("#addLegislatureInput").empty();
            $("#listResultModalLegislature").modal();
            var assemblyman_id = this.value;
            $.ajax({
                    url: "{{ url('assemblymen/listLegislatures') }}/"+ this.value,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(result) {
                    $( ".listResult" ).append( $( "<h2>Legislaturas</h2>" ) );
                    $( ".listResult" ).append( $( '<input type="hidden" name="assemblyman_id" value='+assemblyman_id+'>') );
                    $( ".listResult" ).append( $( '<div class="row">' ) );
                    $.each(result, function( index, value ) {
                        var dateAr = value.from.split('-');
                        var dateArTo = value.to.split('-');
                        var from = dateAr[2] + '/' + dateAr[1] + '/' + dateAr[0].slice(-2);
                        var to = dateArTo[2] + '/' + dateArTo[1] + '/' + dateArTo[0].slice(-2);
                        $( ".listResult" ).append( $( "<div class='col-sm-6'>"+from+" - "+to+"</div><div class='col-sm-6'><button class='btn btn-danger' type='button' onclick='removeLegislatures("+ value.legislature_id + "," + assemblyman_id +")'>Deletar</button> </div>" ) );
                    });
                    $( ".listResult" ).append( $( "</div>" ) );
                })
                .fail(function() {
                    console.log("error");
                });
        });
        $(".listParties").click(function(){
            $(".listResult").empty();
            $("#addPartiesInput").empty();
            $("#listResultModalParties").modal();
            var assemblyman_id = this.value;
            $.ajax({
                    url: "{{ url('assemblymen/listParties') }}/"+ this.value,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(result) {
                    $( ".listResult" ).append( $( "<h2>Partidos</h2>" ) );
                    $( ".listResult" ).append( $( '<input type="hidden" name="assemblyman_id" value='+assemblyman_id+'>') );
                    $( ".listResult" ).append( $( '<div>' ) );
                    $.each(result, function( index, value ) {
                        $( ".listResult" ).append( $( "<div class='row form-group'><div class='col-sm-6'>"+value.party.prefix+"</div><div class='col-sm-6'><button class='btn btn-danger' type='button' onclick='removeParties("+ value.party.id + "," + assemblyman_id +")'>Deletar</button></div>" ) );
                    });
                    $( ".listResult" ).append( $( "</div>" ) );
                })
                .fail(function() {
                    console.log("error");
                });
        });
        $(".listResponsibilities").click(function(){
            $(".listResult").empty();
            $("#addResponsibilitiesInput").empty();
            $("#listResultModalResponsibilities").modal();
            var assemblyman_id = this.value;
            $.ajax({
                    url: "{{ url('assemblymen/listResponsibilities') }}/"+ this.value,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(result) {
                    console.log(result);
                    $( ".listResult" ).append( $( "<h2>Responsabilidades</h2>" ) );
                    $( ".listResult" ).append( $( '<input type="hidden" name="assemblyman_id" value='+assemblyman_id+'>') );
                    $( ".listResult" ).append( $( '<div>' ) );
                    $.each(result, function( index, value ) {
                        $( ".listResult" ).append( $( "<div class='row form-group'><div class='col-sm-6'>"+value.responsibility.name+"</div><div class='col-sm-6'><button class='btn btn-danger' type='button' onclick='removeResponsibilities("+ value.responsibility.id + "," + assemblyman_id +")'>Deletar</button></div>" ) );
                    });
                    $( ".listResult" ).append( $( "</div>" ) );
                })
                .fail(function() {
                    console.log("error");
                });
        });
    });

    const sweet = (e, id) => {
        const url = `assemblymen/${id}`;

        const method = 'DELETE'

        sweetDelete(e, url, null, method)
    }
</script>


