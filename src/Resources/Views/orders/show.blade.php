@extends('layouts.app', ['title' => __('Orders')])

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
                                <h3 class="mb-0">{{ "#".$order->id." - ".$order->created_at->locale(Config::get('app.locale'))->isoFormat('LLLL') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                                @if ($pdFInvoice)
                                <a target="_blank" href="/pdfinvoice/{{$order->id}}" class="btn btn-sm btn-success"><i class="fas fa-print"></i> {{ __('Print bill') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                   @include('orders.partials.orderinfo')
                   @include('orders.partials.actions.buttons',['order'=>$order])
                </div>
            </div>
            <div class="col-xl-5  mb-5 mb-xl-0">
                @if(config('app.isft'))
                <br/>
                <div class="card card-profile shadow">
                    <div class="card-header">
                        <h5 class="h3 mb-0">{{ __("Order tracking")}}</h5>
                    </div>
                    <div class="card-body">
                        @include('orders.partials.map',['order'=>$order])
                    </div>
                </div>
                @endif
                <br/>
                <div class="card card-profile shadow">
                    <div class="card-header">
                        <h5 class="h3 mb-0">{{ __("Status History")}}</h5>
                    </div>
                    @include('orders.partials.orderstatus')
                    
                </div>

                @foreach ($orderModules as $orderModule)
                    @include($orderModule.'::card')
                @endforeach

                @if(auth()->user()->hasRole('client'))
                @if($order->status->pluck('alias')->last() == "delivered")
                    <br/>
                    @include('orders.partials.rating',['order'=>$order])
                @endif
                @endif
            </div>
        </div>
        @include('layouts.footers.auth')
        @include('orders.partials.modals',['order'=>$order])
    </div>
@endsection

@section('head')
    <link type="text/css" href="{{ asset('custom') }}/css/rating.css" rel="stylesheet">
@endsection

@section('js')
<!--   Core JS Files   -->
<script src="{{ asset('softd') }}/js/core/popper.min.js"></script>
<script src="{{ asset('softd') }}/js/core/bootstrap.min.js"></script>
<script src="{{ asset('softd') }}/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var POS_ORDER_ID="<?php echo  $order->id; ?>";
    var LOCALE="<?php echo  App::getLocale() ?>";
    var CASHIER_CURRENCY = "<?php echo  config('settings.cashier_currency') ?>";
    var USER_ID = '{{  auth()->user()&&auth()->user()?auth()->user()->id:"" }}';
    var PUSHER_APP_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
    var PUSHER_APP_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
    var CASHIER_CURRENCY = "<?php echo  config('settings.cashier_currency') ?>";
    var LOCALE="<?php echo  App::getLocale() ?>";
    var SELECT_OR_ENTER_STRING="{{ __('Select, or enter keywords to search items') }}";

    var IS_POS=true;
    var CURRENT_TABLE_ID=null;
    var EXPEDITION=3;
    var CURRENT_TABLE_NAME=null;
    var CURRENT_RECEIPT_NUMBER="";
    var SHOWN_NOW="floor"; //floor,orders,order
    

    // "Global" flag to indicate whether the select2 control is oedropped down).
    var _selectIsOpen = false;
    
 </script>
 <!-- printThis -->
 <script src="{{ asset('vendor') }}/printthis/printThis.js"></script> 
 
<!-- Google Map -->
<script async defer src= "https://maps.googleapis.com/maps/api/js?libraries=geometry,drawing&key=<?php echo config('settings.google_maps_api_key'); ?>"> </script>

    <script src="{{ asset('custom') }}/js/ratings.js"></script>
    {{-- FEL --}}
    <script src="{{ asset('vendor') }}/posinvoicingfel/js/invoicebuton.js"></script>
    {{-- FEL --}}
@endsection

