@extends('layouts.app', ['title' => __('Facturas')])
@extends('posinvoicingfel::layouts.master')
@section('admin_title')
    {{__('Facturas')}}
@endsection
@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>


    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <!-- Invoice Card -->
                @include('posinvoicingfel::invoices.partials.invoicecard')
            </div>
        </div>
        @include('layouts.footers.auth')
        @include('posinvoicingfel::invoices.partials.modals')
    </div>
@endsection


