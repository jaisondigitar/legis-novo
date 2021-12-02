@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('documents.edit') !!}
@endsection
@section('content')
<div class="the-box rounded">
    @include('common.errors')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($document, ['route' => ['documents.update', $document->id], 'method' => 'patch','files' => true]) !!}
                @include('documents.fields')
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
        <style>
            .log{
                padding: 15px;
            }
        </style>

        @foreach($logs as $key => $log)
            <div class="col-md-12">
                <div class="col-lg-12 log" @if($key%2==0) style="border: 1px solid #ddd; background-color: #ddd;" @else style="border: 1px solid #ddd; background-color: #fff;" @endif>
                    <?php

                    switch ($log->event) {
                        case 'created': echo "<label class='badge badge-success'>CRIOU</label>"; break;
                        case 'updated': echo "<label class='badge badge-warning'>EDITOU</label>"; break;
                        case 'deleted': echo "<label class='badge badge-danger'>DELETOU</label>"; break;
                    }

                    echo ' '.date('d/m/Y h:i:s', strtotime($log->created_at));

                    $model = explode('\\', $log->auditable_type);

                    echo '<br><br>';

                    echo ' <b>USUÁRIO:</b> '.strtoupper($log->user->name).' <br> <b>EMAIL:</b> '.$log->user->email.'<br>';
                    echo '<b>IP:</b> '.$log->ip_address.'<br><br>';
                    echo '<b>Rota:</b> '.$log->url.'<br>';

                    if ($log->event == 'updated') {
                        echo '<br><p><strong>VALOR ANTIGO</strong></p>';
                        $object = json_decode($log->old_values);

                        foreach ($object as $key=>$value) {
                            echo '<strong>'.$key.'</strong>: '.$value.'<br style="margin-bottom: 3px">';
                        }
                    }

                    if ($log->event == 'updated' || $log->event == 'created') {
                        echo '<br><p><strong>NOVO VALOR</strong></p>';
                        $object = json_decode($log->new_values);

                        foreach ($object as $key=>$value) {
                            echo '<strong>'.$key.'</strong>: '.$value.'<br style="margin-bottom: 3px">';
                        }
                    }


                    ?>

                </div>
            </div>
        @endforeach
        <div class="clearfix"></div>
        <br>
        <div class="col-md-12">
            <span class="pull-right">
                <a href="{{route('documents.index')}}" class="btn btn-default"> Voltar </a>
            </span>
        </div>
    </div>
</div>


@endis
@endsection
