
"use strict";
var receiptPOSInvoiceView=null;
var anularInvoiceView=null;


function anularFactura(idOrder,opcion){
  
  console.log('anular :: idFacrtura ', idOrder, ' opcion  ', opcion);
  $('#indicatoranular').show();
  $('#botonanular').hide();
  axios.delete(`/posfel/v1/revocate/${idOrder}?codigo_motivo_anulacion=${opcion}`, {}).then(function (response) {
    
    
     $('#botonanular').show();
     $('#indicatoranular').hide();
    //  $('#modalPayment').modal('hide');
     //Call to get the total price and items
 
     if(response.data.status){       
        anularInvoiceView.motivoAnulacion='0';
        $('#modalAnularInvoiceView').modal('hide');
       js.notify(response.data.message, "success");
       window.location.reload();
     }else{            
       js.notify(response.data.message, "warning");
     }
     
     
   }).catch(function (error) {
    
    //  $('#modalAnularInvoiceView').modal('hide');
     $('#botonanular').show();
     $('#indicatoranular').hide();
     js.notify(error, "warning");
   });
}

window.onload = function () {

  
  receiptPOSInvoiceView=new Vue({
    el:"#modalPOSInvoiceView",
    data:{
      invoice:null
    },

    methods: {
      moment: function (date) {
        return moment(date);
      },
      decodeHtml: function (html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;

        console.log("specia");
        console.log(txt.value)
        return txt.value;
      },
      formatPrice(price){
        var locale=LOCALE;
        if(CASHIER_CURRENCY.toUpperCase()=="USD"){
            locale=locale+"-US";
        }

        var formatter = new Intl.NumberFormat(locale, {
            style: 'currency',
            currency:  CASHIER_CURRENCY,
        });

        var formated=formatter.format(price);

        return formated;
      },
      date: function (date) {
        return moment(date).format('MMMM Do YYYY, h:mm:ss a');
      },
      imprimirFactura(){
        imprimeFacturaPos();
      }
    },
  });
  anularInvoiceView=new Vue({
    el:"#modalAnularInvoiceView",
    data:{
      idinvoice:null,
      motivosAnulacion:[],
      motivoAnulacion:'0'
    },

    methods: {
      moment: function (date) {
        return moment(date);
      },
      decodeHtml: function (html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;

        console.log("specia");
        console.log(txt.value)
        return txt.value;
      },
      formatPrice(price){

        

        return price;
      },
      date: function (date) {
        return moment(date).format('MMMM Do YYYY, h:mm:ss a');
      },
      getMotivosAnulacion(){
        axios.get(`/posfel/v1/revocation-reason`).then(function (response) {     
     
          
          console.log('ver motivos anulacion :: response.data ', response.data);        
         
          if(response.data.status){       
            js.notify('Motivos de anulación obtenidos.', "success");
            anularInvoiceView.motivosAnulacion=response.data.data;
            console.log('ver motivos anulacion :: anularInvoiceView.motivosAnulacion ', anularInvoiceView.motivosAnulacion);        
          }else{      
            js.notify('No existen motivos de anulación', "warning");
          }
          
        }).catch(function (error) {     
          
          $('#indicator').hide();
          js.notify(error, "warning");
        });
      },
      anular(){
        if(anularInvoiceView.motivoAnulacion != '0'){
          anularFactura(anularInvoiceView.idinvoice, anularInvoiceView.motivoAnulacion);
        } else {
          js.notify('Debe seleccionar un motivo de anulación', "warning");
        }
      }
    },
    created: function(){
      this.getMotivosAnulacion();
    }
  });
}

function verAnularFactura(idFactura){
  anularInvoiceView.idinvoice = idFactura;
  $('#modalAnularInvoiceView').modal('show');
}

function verFactura(idOrder){
  console.log('ver factura :: idorder ', idOrder);
  $('#indicator').show();
  axios.get(`/posfel/v1/invoice/${idOrder}`).then(function (response) {     
     
     $('#indicator').hide();
     console.log('ver factura :: response.data ', response.data);
    //  $('#modalPayment').modal('hide');
     //Call to get the total price and items     
     console.log('ver factura :: response.data.status ', response.data.status);
     if(response.data.status){       
       js.notify('Factura obtenida.', "success");
       receiptPOSInvoiceView.invoice=response.data.invoice;
      
       $('#modalPOSInvoiceView').modal('show');
     }else{      
       js.notify('No existe la factura', "warning");
     }
     
     
   }).catch(function (error) {     
     
     $('#indicator').hide();
     js.notify(error, "warning");
   });
}

function imprimeFacturaPos(){
  $("#posReciptInvoiceView").printThis();
}