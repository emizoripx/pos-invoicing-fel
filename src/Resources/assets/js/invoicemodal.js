
"use strict";
var receiptPOSInvoiceView=null;


function anularFactura(idOrder,opcion){
  
  console.log('anular :: idorder ', idOrder, ' opcion  ', opcion);

//   axios.post(withSession(`/posfel/emit/${idOrder}`), {}).then(function (response) {
     
//      $('#submitOrderPOS').show();
//      $('#indicator').hide();
 
//      $('#modalPayment').modal('hide');
//      //Call to get the total price and items
//      getCartContentAndTotalPrice();
 
//      if(response.data.status){
//        window.showOrders();
//        js.notify(response.data.message, "success");
//        receiptPOSInvoice.invoice=response.data.invoice;
      
//        $('#modalPOSInvoice').modal('show');
//      }else{
//       if(opcion == 2){
//         $('#submitInvoicePOSOrder').show();
//         $('#printPos').show();
//         $('#modalPOSOrder').modal('show');
//       }
//        js.notify(response.data.message, "warning");
//      }
     
     
//    }).catch(function (error) {
     
//      $('#posReciptInvoice').modal('hide');
//      $('#submitOrderPOS').show();
//      $('#indicator').hide();
//      js.notify(error, "warning");
//    });
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
      }
    },
  });
}

function verFactura(idOrder){
  console.log('ver factura :: idorder ', idOrder);
  $('#indicator').show();
  axios.get(`/posfel/invoice/${idOrder}`).then(function (response) {     
     
     $('#indicator').hide();
 
     $('#modalPayment').modal('hide');
     //Call to get the total price and items     
 
     if(response.status){       
       js.notify('Factura obtenida.', "success");
       receiptPOSInvoiceView.invoice=response.invoice;
      
       $('#modalPOSInvoiceView').modal('show');
     }else{      
       js.notify('No existe la factura', "warning");
     }
     
     
   }).catch(function (error) {     
     
     $('#indicator').hide();
     js.notify(error, "warning");
   });
}