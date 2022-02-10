<table class="table table-striped table-hover" id="documents-table">
    <thead>
        <tr>
            <th>Número interno</th>
            <th>Data</th>
            <th>Tipo documento</th>
            <th>Responsável</th>
            <th>Conteúdo</th>
            <th style="text-align: center">Número</th>
            <th>Lido</th>
            <th style="text-align: center;">Aprovado</th>
            <th style="text-align: center;">Protocolo</th>
            <th style="text-align: center;" >Data Protocolo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $document)
            <tr id="row_{{$document->id}}" >
                <td>{!! $document->getNumber() !!}</td>
                <td>{!! $document->date !!}</td>
                <td>
                    @if($document->document_type->parent_id)
                        {{ $document->document_type->parent->name }} ::
                    @endif
                        {!! $document->document_type->name !!}
                </td>
                <td>
                    @if($document->owner)
                        {!! $document->owner->short_name !!}
                    @else
                        -
                    @endif

                    @if($document->assemblyman()->count() > 0)
                        @foreach($document->assemblyman()->get() as $assemblyman)
                            - {{$assemblyman->short_name}}
                        @endforeach
                    @endif
                </td>
                <td>
                    @if($document->content)
                        {!! strip_tags(Str::limit($document->content, $limit = 500, $end = '...')) !!}
                    @else
                        -
                    @endif
                </td>
                <td id="tdnumber{{$document->id}}" style="text-align: center">
                    @if($document->number==0)
                        -
                    @else
                        {!! $document->number . '/' . $document->getYear($document->date) !!}
                    @endif
                </td>
                @shield('document.read')
                    @if($document->read == 1)
                        <td>
                            <label class="label label-success">
                                Sim
                            </label>
                        </td>
                    @else
                        <td>
                            <label class="label label-danger">
                                Não
                            </label>
                        </td>
                    @endif
                @endshield
                @shield('document.approved')
                    @if($document->approved == 1)
                        <td style="text-align: center;">
                            <label class="label label-success">
                                Sim
                            </label>
                        </td>
                    @else
                        <td style="text-align: center;">
                            <label class="label label-danger">
                                Não
                            </label>
                        </td>
                    @endif
                @endshield
                <td align="center" id="tdprotocol{{$document->id}}">
                    @if($document->document_protocol)
                        {{$document->document_protocol->number}}
                    @else
                        -
                    @endif
                </td>
                <td align="center" id="tddate{{$document->id}}">
                    @if($document->document_protocol)
                        {{date('d/m/Y H:i:s', strtotime($document->document_protocol->created_at))}}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{!! $documents->appends(request()->input())->render() !!}

<script>
    const pdf = function(){

        url = '/report/pdf';

        data = {
            reg      : $('#reg').val(),
            tipo     : $('#tipo').val(),
            numero   : $('#numero').val(),
            ano      : $('#ano').val(),
            dono     : $('#dono').val(),
            data     : $('#data').val(),
            '_token' : '{{csrf_token()}}'
        };

        $.ajax({
            url : url,
            data : data,
            jsonp: false,
            method: 'POST',
            success :function(data){
                data = JSON.parse(data);
                console.log(data);
            }
        })
    }
</script>
