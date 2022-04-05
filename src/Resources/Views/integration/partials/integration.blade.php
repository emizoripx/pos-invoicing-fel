<div class="card card-profile bg-secondary shadow">
    <div class="card-header">
        <h5 class="h3 mb-0">{{ __("Configuraciones de Integración")}}</h5>
    </div>
    <div class="card-body">
        <?php
            $is_update_token = isset($restorant->fel_restorant->fel_token) ? true : false;
        ?>
        <form method="POST" action="{{ $is_update_token ? route('integration.update', $restorant->fel_restorant->fel_token->id) : route('integration.store')}}" >
            @csrf
            @if($is_update_token)
                @method('put')
            @endif
            <input type="hidden" name="user_id" value="{{ $restorant->user->id }}">
            <input type="hidden" name="restorant_id" value="{{ $restorant->id }}">
            @include('partials.fields',['fields'=>[
                ['class'=>'col-12', 'ftype'=>'input', 'placeholder' => 'Client ID', 'name'=>"Client ID",'id'=>"client_id",'required'=>true, 'value'=> $is_update_token ? $restorant->fel_restorant->fel_token->client_id : null],
                ['class'=>'col-12', 'ftype'=>'input', 'placeholder' => 'Client Secret', 'name'=>"Client Secret",'id'=>"client_secret",'required'=>true,'value'=> $is_update_token ?  $restorant->fel_restorant->fel_token->client_secret : null],
                ['class'=>'col-12', 'ftype'=>'input', 'placeholder' => 'FEL Host', 'name'=>"FEL Host",'id'=>"host",'required'=>true,'value'=> $is_update_token ? $restorant->fel_restorant->fel_token->host : null],
            ]])
            <div class="text-center">
                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
            </div>
        </form>

        <hr class="my-4">
        <div id="parametrics">
            <h6 class="heading-small text-muted mb-4">Sincronizar Paramétricas</h6>
            <div>
                <div class="form-group">
                    <label class="form-control-label" for="item_price">{{ __('Sincronizar Catálogo de Productos') }}</label>
                    <div class="row" style="float: right;">
                        <div class="row">
                            <div class="form-switch">
                                <label class="form-switch-label" for="flexSwitchCheckDefault">Últm. Sincronización: {{ isset($restorant->fel_restorant->last_products_sync) ? \Carbon\Carbon::parse($restorant->fel_restorant->last_products_sync)->format('h:i A, d/m/Y') : '' }}</label>
                            </div>
                            <div class="mx-4">
                                <i id="indicator_syncparametrics" style="display: none" class="fas fa-spinner fa-spin"></i>
                                <button type="button" @if($is_update_token == false) disabled  @endif v-on:click="syncProducts" id="sync_parametrics" class="btn btn-primary btn-sm mx-4" style="float: right; @if($is_update_token == false) cursor: not-allowed !important;  @endif">Sincronizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

