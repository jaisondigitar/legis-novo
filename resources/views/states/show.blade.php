@extends('layouts.blit')
@section('title', 'Estado')
@section('content')
<div class="the-box rounded">
	 @include('states.show_fields')
</div>
@endsection
