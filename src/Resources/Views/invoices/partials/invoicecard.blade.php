<div class="card shadow">
    <div class="card-header border-0">
        @if(count($invoices))
        <form method="GET">
            <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">{{ __('Facturas') }}</h3>
                </div>
                <div class="col-4 text-right">
                    <button id="show-hide-filters" class="btn btn-icon btn-1 btn-sm btn-outline-secondary" type="button">
                        <span class="btn-inner--icon"><i id="button-filters" class="ni ni-bold-down"></i></span>
                    </button>
                </div>
            </div>
            <br/>
            <div class="tab-content orders-filters">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-daterange datepicker row align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Date From') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input name="fromDate" class="form-control" placeholder="{{ __('Date from') }}" type="text" <?php if(isset($_GET['fromDate'])){echo 'value="'.$_GET['fromDate'].'"';} ?> >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Date to') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input name="toDate" class="form-control" placeholder="{{ __('Date to') }}" type="text"  <?php if(isset($_GET['toDate'])){echo 'value="'.$_GET['toDate'].'"';} ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- statuses -->
                        <div class="col-md-3">
                            @include('partials.select', ['name'=>"Estado",'id'=>"state_invoice",'placeholder'=>"Select status",'data'=> $states,'required'=>false, 'value'=>''])
                        </div>

                       
                        
                        @hasrole('admin|driver')
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="restorant">{{ __('Filter by Restaurant') }}</label>
                                    <select class="form-control select2" name="restorant_id">
                                        <option disabled selected value> -- {{ __('Select an option') }} -- </option>
                                        @foreach ($restorants as $restorant)
                                            <option <?php if(isset($_GET['restorant_id'])&&$_GET['restorant_id'].""==$restorant->id.""){echo "selected";} ?> value="{{ $restorant->id }}">{{$restorant->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if (config('app.isft'))
                        @hasrole('admin|owner')
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="client">{{ __('Filter by Client') }}</label>

                                <select class="form-control select2" id="blabla" name="client_id">
                                    <option disabled selected value> -- {{ __('Select an option') }} -- </option>
                                    @foreach ($clients as $client)
                                        <option  <?php if(isset($_GET['client_id'])&&$_GET['client_id'].""==$client->id.""){echo "selected";} ?>  value="{{ $client->id }}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        @hasrole('admin|owner')
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="driver">{{ __('Filter by Driver') }}</label>
                                <select class="form-control select2" name="driver_id">
                                    <option disabled selected value> -- {{ __('Select an option') }} -- </option>
                                    @foreach ($drivers as $driver)
                                        <option <?php if(isset($_GET['driver_id'])&&$_GET['driver_id'].""==$driver->id.""){echo "selected";} ?>   value="{{ $driver->id }}">{{$driver->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif    
                        @else
                        @endif
                        
                    </div>

                        <div class="col-md-6 offset-md-6">
                            <div class="row">
                                @if ($parameters)
                                    <div class="col-md-4">
                                        <a href="{{ Request::url() }}" class="btn btn-md btn-block">{{ __('Clear Filters') }}</a>
                                    </div>
                                    <div class="col-md-4">
                                    <a href="{{Request::fullUrl()."&report=true" }}" class="btn btn-md btn-success btn-block">{{ __('Download report') }}</a>
                                    </div>
                                @else
                                    <div class="col-md-8"></div>
                                @endif

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-md btn-block">{{ __('Filter') }}</button>
                                </div>
                        </div>
                    </div>
             </div>
        </form>
        @endif
    </div>
    <div class="col-12">
        @include('partials.flash')
    </div>
    @if(count($invoices))
    <div class="table-responsive">
        <table class="table align-items-center">
            @if (isset($financialReport))
                @include('finances.financialdisplay')
            @elseif (config('app.isqrsaas'))
                @include('posinvoicingfel::invoices.partials.invoicedisplay_local')
            @else
                @include('posinvoicingfel::invoices.partials.invoicedisplay')
            @endif
        </table>
    </div>
    @endif
    <div class="card-footer py-4">
        @if(count($invoices))
        <nav class="d-flex justify-content-end" aria-label="...">
            {{ $invoices->appends(Request::all())->links() }}
        </nav>
        @else
            <h4>{{ __('You don`t have any invoices') }} ...</h4>
        @endif
    </div>
    @include('posinvoicingfel::orders.partials.modalviewinvoice', ['modal_id' => 'modalPOSInvoiceView', 'pos_invoice' => 'posReciptInvoiceView'])
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
    <script src="{{ asset('vendor') }}/posinvoicingfel/js/invoicemodal.js"></script>
    {{-- FEL --}}
@endsection