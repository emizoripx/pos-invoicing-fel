<div class="card shadow">
    <div class="card-header border-0">
        {{-- @if(count($contingency_files)) --}}
            <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">{{ __('Archivos') }}</h3>
                </div>
                @include('posinvoicingfel::general.generalactions')
            </div>
            <br/>
        {{-- @endif --}}
    </div>
    <div class="col-12">
        @include('partials.flash')
    </div>
    @if(count($contingency_files))
        <div class="table-responsive">
            <table class="table align-items-center">
                    @include('posinvoicingfel::contingency.partials.contingencydisplay')
            </table>
        </div>
    @endif
    <div class="card-footer py-4">
        @if(count($contingency_files))
        <nav class="d-flex justify-content-end" aria-label="...">
            {{ $contingency_files->appends(Request::all())->links() }}
        </nav>
        @else
            <h4>{{ __('You don`t have any files') }} ...</h4>
        @endif
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