@extends('layouts.app', ['title' => __($title_card)])

@include('posinvoicingfel::invoices.includes.posstyles')
{{-- @include('posinvoicingfel::orders.partials.modalviewinvoice', ['modal_id' => 'modalPOSInvoiceView', 'pos_invoice' => 'posReciptInvoiceView']) --}}

@section('admin_title')
    {{__($title_card)}}
@endsection
@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>


    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <!-- Invoice Card -->
                @yield('card')
            </div>
        </div>
        @include('layouts.footers.auth')
        {{-- @include('posinvoicingfel::invoices.partials.modals') --}}
    </div>
@endsection
