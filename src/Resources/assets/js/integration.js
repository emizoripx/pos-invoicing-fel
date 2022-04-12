"use strict"

var syncparametrics = null


var init_integration = function ( restorant_id ) {
    console.log('Load Integration');
    syncparametrics = new Vue({
        el:"#parametrics",
        data: {
            restorant_id : restorant_id
        },
        methods: {
            syncProducts: function(){
                console.log('sync products ', this.restorant_id);

                $('#indicator_syncparametrics').show();
                $('#sync_parametrics').hide();

                axios.get(`/posfel/v1/sync-products/${restorant_id}`).then(function (response){
                    
                    console.log('Sync :: response.data ', response.data);

                    console.log('Sync :: response.data.status ', response.data.status);

                    if(response.data.status){

                        $('#sync_parametrics').show();
                        $('#indicator_syncparametrics').hide();

                        js.notify(response.data.message, "success");

                    } else {
                        
                        $('#sync_parametrics').show();
                        $('#indicator_syncparametrics').hide();

                        js.notify(response.data.message, "warning");

                    }
                }).catch( function (error) {
                    setTimeout(() => {
                        console.log('created 0.5seg');
                        $('#sync_parametrics').show();
                        $('#indicator_syncparametrics').hide();
                    }, 500);
                    
                    js.notify(error, "warning");
                });
            }
        }
    });

    // Control of Whatsapp Settings
    $("#whatsapp_message_limit").attr("disabled", !$("#has_limit:checked").length);
    $("#whatsapp_message_limit").attr("disabled", !$("#enabled_whatsapp_send:checked").length);
    $("#enabled_whatsapp_auto_send").attr("disabled", !$("#enabled_whatsapp_send:checked").length);
    $("#has_limit").attr("disabled", !$("#enabled_whatsapp_send:checked").length);

    $(function() {
        $("#has_limit").on('click', function() {
            $("#whatsapp_message_limit").attr("disabled", !$("#has_limit:checked").length);
        });

        $("#enabled_whatsapp_send").on('click', function() {

            $("#whatsapp_message_limit").attr("disabled", !$("#has_limit:checked").length || !$("#enabled_whatsapp_send:checked").length);
            $("#enabled_whatsapp_auto_send").attr("disabled", !$("#enabled_whatsapp_send:checked").length);
            $("#has_limit").attr("disabled", !$("#enabled_whatsapp_send:checked").length);
        });
    });
    

}
