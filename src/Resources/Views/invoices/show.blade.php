@extends('layouts.app', ['title' => __('Invoices')])

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-7 ">
                <br/>
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ "#".$invoice->id." - ".$invoice->created_at->locale(Config::get('app.locale'))->isoFormat('LLLL') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                                @if ($pdFInvoice)
                                <a target="_blank" href="/pdfinvoice/{{$invoice->id}}" class="btn btn-sm btn-success"><i class="fas fa-print"></i> {{ __('Print bill') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                   @include('posinvoicingfel::invoices.partials.invoiceinfo')
                   @include('posinvoicingfel::invoices.partials.actions.buttons',['invoice'=>$invoice])
                </div>
            </div>
            <div class="col-xl-5  mb-5 mb-xl-0">
                @if(config('app.isft'))
                <br/>
                <div class="card card-profile shadow">
                    <div class="card-header">
                        <h5 class="h3 mb-0">{{ __("Invoice tracking")}}</h5>
                    </div>
                    <div class="card-body">
                        @include('posinvoicingfel::invoices.partials.map',['invoice'=>$invoice])
                    </div>
                </div>
                @endif
                <br/>
                <div class="card card-profile shadow">
                    <div class="card-header">
                        <h5 class="h3 mb-0">{{ __("Status History")}}</h5>
                    </div>
                    @include('posinvoicingfel::invoices.partials.invoicestatus')
                    
                </div>

                @foreach ($invoiceModules as $invoiceModule)
                    @include($invoiceModule.'::card')
                @endforeach

                @if(auth()->user()->hasRole('client'))
                @if($invoice->status->pluck('alias')->last() == "delivered")
                    <br/>
                    @include('posinvoicingfel::invoices.partials.rating',['invoice'=>$invoice])
                @endif
                @endif
            </div>
        </div>
        @include('layouts.footers.auth')
        @include('posinvoicingfel::invoices.partials.modals',['invoice'=>$invoice])
    </div>
@endsection

@section('head')
    <link type="text/css" href="{{ asset('custom') }}/css/rating.css" rel="stylesheet">
@endsection

@section('js')
<!-- Google Map -->
<script async defer src= "https://maps.googleapis.com/maps/api/js?libraries=geometry,drawing&key=<?php echo config('settings.google_maps_api_key'); ?>"> </script>
  

    <script src="{{ asset('custom') }}/js/ratings.js"></script>
@endsection

