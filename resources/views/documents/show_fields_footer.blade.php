<table width="100%">
    <tr>
        <td width="70%">
            <p>{{ $company->fullName }}</p>
            <p>{{ $company->getCity->name }} - {{ $company->getState->uf }}</p>
        </td>
        <td width='20%' align="center">
            {{date_timestamp_get($document->updated_at)}}
            <div>
                {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG(date_timestamp_get($document->updated_at), "C128") . '" alt="barcode"   />' !!}
            </div>
        </td>
    </tr>
</table>