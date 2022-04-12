<div class="card card-profile bg-secondary shadow">
    <div class="card-header">
        <h5 class="h3 mb-0">{{ __("Configuraciones de Whatsapp")}}</h5>
    </div>
    <div class="card-body">
        
        <div>
            <div>
                <?php
                    $fel_restorant = $restorant->fel_restorant;
                ?>
                <form method="POST" action="{{ route('felrestorant.updatewhatsappsettings', $fel_restorant->id) }}" >
                    @csrf
                    @method('put')
                    <input type="hidden" name="restorant_id" value="{{ $restorant->id }}">
                    <div class="row">
                        @include('partials.fields',['fields'=>[
                            ['name'=>'Habilitar el Envió de Whatsapp', 'additionalInfo'=>'Habilita el envió de facturas por mensajes de Whatsapp.', 'id'=>'enabled_whatsapp_send', 'ftype'=>'bool', 'class' => 'col-12 ml-4', 'value'=> isset($fel_restorant->enabled_whatsapp_send) ? boolval($fel_restorant->enabled_whatsapp_send) : false ],
                            ['name'=>'Habilitar el Envió Automático de Facturas por Whatsapp ', 'additionalInfo'=>'Habilita el envió automático de facturas por Whatsapp', 'id'=>'enabled_whatsapp_auto_send', 'ftype'=>'bool', 'class' => ' col-12 ml-4', 'value' => isset($fel_restorant->enabled_whatsapp_auto_send) ? boolval($fel_restorant->enabled_whatsapp_auto_send) : false ],
                            ['name'=>'Habilitar Límite de Mensajes', 'additionalInfo'=>'Habilita un cantidad límite de mensajes para enviar', 'id'=>'has_limit', 'ftype'=>'bool', 'class' => ' col-12 ml-4', 'value' => isset($fel_restorant->has_limit) ? boolval($fel_restorant->has_limit) : false ],
                            ['class'=>'col-6', 'ftype'=>'input', 'type' => 'number', 'placeholder' => 'Cantidad Limite de Mensajes', 'name'=>"Cantidad Limite de Mensajes",'id'=>"whatsapp_message_limit",'required'=>false, 'value'=> isset($fel_restorant->whatsapp_message_limit) ? $fel_restorant->whatsapp_message_limit :  null],
                        ]])
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
            <hr class="my-4">
            <div>
                <h6 class="heading-small text-muted mb-4">Sincronizar Paramétricas</h6>
                <div>
                    <div class="form-group" style="border-bottom: 1px solid rgba(218, 217, 217, 0.806);">
                        <label class="form-control-label" for="item_price">{{ __('Cantidad de mensajes disponibles') }}</label>
                        <div class="row" style="float: right;">
                            <div class="row">
                                <div class="mx-5">
                                    <h2>{{ $fel_restorant->whatsapp_message_limit }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

