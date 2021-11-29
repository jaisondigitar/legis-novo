@if($lawsProjects->isEmpty())
    <div class="well text-center">Sem dados. Insira um novo registro.</div>
@else
    <table class="table table-responsive" id="lawsProjects-table">
        <thead>
            <tr>
                <th>#COD</th>
                <th>DESCRIÇÃO</th>
                <th>DATA</th>
                <th>PROTOCOLO</th>
                <th>APROVADO</th>
                <th>LIDO</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($lawsProjects as $lawsProject)
                <tr>
                    <td>{!! $lawsProject->getNumberLaw() !!}</td>
                    <td>
                        @if(!$lawsProject->law_type)
                            {{ $lawsProject->law_type_id }}
                        @else
                            {!! mb_strtoupper($lawsProject->law_type->name, 'UTF-8') !!}
                        @endif
                        <span id="tdLawProjectNumber{{$lawsProject->id}}">
                            {!! $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) !!}
                        </span>
                    </td>
                    <td> {{$lawsProject->law_date}} </td>
                    <td>
                        @if($lawsProject->project_number > 0)
                            <label class="label label-success">
                                {{ $lawsProject->protocol }}
                            </label>
                        @else
                            <label class="label label-danger">
                                Não
                            </label>
                        @endif
                    </td>
                    <td>
                        @if($lawsProject->is_ready == 1)
                            <label class="label label-success">
                                SANCIONADA
                            </label>
                        @else
                            <span align="center">
                                <label class="label label-danger">
                                    Não
                                </label>
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($lawsProject->is_read == 1)
                            <label class="label label-success">
                                Sim
                            </label>
                        @else
                            <label class="label label-danger">
                                Não
                            </label>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{!! $lawsProjects->appends(request()->input())->render() !!}
