@if ($field['ftype']=="input")
    @include('posinvoicingfel::general.partials.input',$field)
@endif

@if ($field['ftype']=="select")
        @include('posinvoicingfel::general.partials.select',$field)
@endif