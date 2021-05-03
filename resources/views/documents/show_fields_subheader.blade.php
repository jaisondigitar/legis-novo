<section class="header-sub">
    <h3>{{$document->document_type->name}} @if($document->number){{ $document->number . '/' . $document->getYear($document->date) }}@endif</h3>
    <div class="documento-origem">
        Origem documento: <strong>{{$document->owner->full_name}}</strong>
    </div>
</section>


