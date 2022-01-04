@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('lawsProjects.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($lawsProject, ['route' => ['lawsProjects.update', $lawsProject->id], 'method' => 'patch','files' => true]) !!}
                @include('lawsProjects.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>

@is(['admin','root'])

<div class="the-box rounded" style="font-size: 12px">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            <h1> Log de registro </h1>
            <hr>
        </div>
        @foreach($logs as $key => $log)
            <div class="col-sm-12" style="display: flex; margin: 20px 0;">
                <div class="<?php echo $log->event; ?>"></div>
                <div
                    class="col-sm-12 log"
                    @if($key%2==0)
                    style="border: 1px solid #ddd; background-color: #ddd;"
                    @else
                    style="border: 1px solid #ddd; background-color: #fff;"
                    @endif
                >
                    <div>
                        <?php
                        $model = explode('\\', $log->auditable_type);

                        switch ($log->event) {
                            case 'created':
                                echo "<label class='badge badge-success'>CRIOU</label>";
                                break;
                            case 'updated':
                                echo "<label class='badge badge-warning'>EDITOU</label>";
                                break;
                            case 'deleted':
                                echo "<label class='badge badge-danger'>DELETOU</label>";
                                break;
                        }
                        echo '<br><b>MODEL: </b>'.$translation[strtoupper($model[2])].'<br><br>';

                        echo '<p style="border: 1px solid #adadad"></p>';

                        echo '<div class="col-sm-1"><b>ID:</b> '.strtoupper($log->auditable_id).'</div>';
                        echo '<div class="col-sm-3"><b>Data</b>: '.date('d/m/Y H:i:s', strtotime($log->created_at)).'</div>';
                        echo '<div class="col-sm-6"><b>Rota:</b> '.$log->url.'</div>';
                        echo '<div class="col-sm-2"><b>IP:</b> '.$log->ip_address.'</div>';

                        echo '<p style="border: 1px solid #adadad; margin-top: 40px;"></p>';

                        if ($log->event == 'updated') {
                            echo '<div class="col-sm-6">';
                            echo '<strong>VALOR ANTIGO</strong><br><br>';
                            $object = json_decode($log->old_values);

                            foreach ($object as $key => $value) {
                                if ($key == 'date' || $key == 'date_start' || $key == 'date_end' || $key == 'law_date') {
                                    $newDate = date('d/m/Y', strtotime($value));
                                    echo '<strong>'.$translation[$key].'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                                } else {
                                    echo '<strong>'.$translation[$key].'</strong>: '.(is_object($value) ? '' : $value).'<br style="margin-bottom: 3px">';
                                }
                            }
                            echo '</div>';
                        }

                        if ($log->event == 'updated' || $log->event == 'created') {
                            echo '<div class="col-sm-6">';
                            echo '<strong>NOVO VALOR</strong><br><br>';
                            $object = json_decode($log->new_values);

                            foreach ($object as $key => $value) {
                                if ($key == 'date' || $key == 'date_start' || $key == 'date_end' || $key == 'law_date') {
                                    $newDate = date('d/m/Y', strtotime($value));
                                    echo '<strong>'.$translation[$key].'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                                } else {
                                    echo '<strong>'.$translation[$key].'</strong>: '.(is_object($value) ? '' : $value).'<br style="margin-bottom: 3px">';
                                }
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="clearfix"></div>
        <br>
        <div class="col-md-12">
            <span class="pull-right">
                <a href="{{route('lawsProjects.index')}}" class="btn btn-default"> Voltar </a>
            </span>
        </div>
    </div>
</div>

@endis
@endsection
