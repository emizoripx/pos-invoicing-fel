<div class="card shadow">
    <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">{{ __('Códigos CAFC') }}</h3>
                </div>
                @include('posinvoicingfel::general.generalactions')
            </div>
            <br/>
    </div>
    <div class="col-12">
        @include('partials.flash')
    </div>
    <div class="card-body">
        @yield('card_content')
    </div>

    <div class="card-footer py-4">
        @yield('card_footer')
    </div>
</div>
@section('js')
<!--   Core JS Files   -->
<script src="{{ asset('softd') }}/js/core/popper.min.js"></script>
<script src="{{ asset('softd') }}/js/core/bootstrap.min.js"></script>
<script src="{{ asset('softd') }}/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var POS_ORDER_ID="";
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
    {{-- FEL --}}
    {{-- <script src="{{ asset('vendor') }}/posinvoicingfel/js/invoicemodal.js"></script> --}}
    {{-- FEL --}}
@endsection