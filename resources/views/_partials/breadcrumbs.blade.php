@if ($breadcrumbs)
    <ol class="breadcrumb dark square rsaquo sm">
        @foreach ($breadcrumbs as $breadcrumb)
{{--            @if (!is_null($breadcrumb->url) && !$loop->last)--}}
{{--                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>--}}
{{--            @else--}}
{{--                <li class="active" style="margin-left: 5px;"><samp style="margin-left: 5px">{{ $breadcrumb->title }}</samp></li>--}}
{{--            @endif--}}
        @endforeach
    </ol>
@endif
