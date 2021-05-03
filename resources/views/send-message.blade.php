@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('home') !!}
@endsection
@section('content')
    <div class="the-box rounded">
        @include('common.errors')
        <div class="row">
            <div class="col-md-6">
                {!! Form::open(['url' => '/send-message', 'class' => 'form-signin']) !!}
                <h2 class="form-signin-heading">Enviar mensagem no Telegram como um Bot</h2>
                <label for="inputText" class="sr-only">Message</label>
                <textarea name="message" type="text" id="inputText" class="form-control" placeholder="Mensagem" required autofocus></textarea>
                <br />
                @if(Session::has('message'))
                    <div class="alert alert-{{ Session::get('status') }} status-box">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
                {!! Form::close() !!}
                <br />

            </div>
        </div>
    </div>
@endsection