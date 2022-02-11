@extends('layouts.blit')
@section('Breadcrumbs')
    {!! Breadcrumbs::render('commissions.list') !!}
@endsection
@section('content')
    <div class="row">
        @if(isset($commissions))
            @foreach($commissions as $commission)
                <div class="col-lg-6">
                    <div class="card text-center">
                    <div class="card-header" style="background-color: #444A54; color: #fff;">
                            <h3 class="card-title text-uppercase">{{$commission->name}}</h3>
                        </div>
                        <div class="card-body">
                            <a
                                href="{{route('admin.showLaw', $commission->id)}}"
                                class="btn btn-primary text-uppercase
                                    @if(!$commission->projects()->count())
                                        disabled
                                    @endif"
                            >
                                projeto de lei [{{$commission->projects()->count()}}]
                            </a>
                            <a
                                href="{{route('admin.showDocument', $commission->id)}}"
                                class="btn btn-warning text-uppercase
                                    @if(!$commission->documents()->count())
                                        disabled
                                    @endif"
                            >
                                documentos [{{$commission->documents()->count()}}]
                            </a>
                            <a
                                href="{{route('admin.showClose', $commission->id)}}"
                                class="btn btn-info text-uppercase
                                    @if(!$commission->advices()->where('closed', 0)->get()->count())
                                        disabled
                                    @endif"
                            >
                                Encerradas documentos [{{$commission->advices()->where('closed', 0)->get()->count()}}]
                            </a>
                        </div><!-- /.card-body -->
                    </div><!-- /.card card-success card-block-color -->
                </div>
            @endforeach
        @endif
    </div>
@endsection
