@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('commissions.list') !!}
@endsection
@section('content')
    @if(isset($commissions))
        @foreach($commissions as $c)
            <div class="col-lg-6">
                <div class="panel panel-default panel-square panel-no-border text-center">
                    <div class="panel-heading" style="background-color: #444A54; color: #fff;">
                        <h3 class="panel-title text-uppercase">{{$c->name}}</h3>
                    </div>
                    <div class="panel-body">
                        <a href="{{route('admin.showLaw', $c->id)}}" class="btn btn-primary text-uppercase @if(!$c->projects()->count()) disabled @endif">
                            projeto de lei [{{$c->projects()->count()}}]
                        </a>
                        <a href="{{route('admin.showDocument', $c->id)}}" class="btn btn-warning text-uppercase @if(!$c->documents()->count()) disabled @endif">
                            documentos [{{$c->documents()->count()}}]
                        </a>
                        <a href="{{route('admin.showClose', $c->id)}}" class="btn btn-info text-uppercase @if(!$c->advices()->where('closed', 0)->get()->count()) disabled @endif"> Encerradas documentos [{{$c->advices()->where('closed', 0)->get()->count()}}] </a>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel panel-success panel-block-color -->
            </div>
        @endforeach
    @endif
@endsection