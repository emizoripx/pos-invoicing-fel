@extends('posinvoicingfel::general.index', ['title_card' => __('Códigos CAFCs')])

@section('card')
    @include('posinvoicingfel::cafc.partials.form')
@endsection
