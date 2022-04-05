
"use strict";
var butonInvoice=null;
var qrcode=null;

window.onload = function () {

  
    butonInvoice=new Vue({
    el:"#viewButonInvoice",
    data:{
      invoice:null,
      titleButon:'None',
      activeClass:'d-none'
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
            currencyDisplay: 'narrowSymbol'
        });

        var formated=formatter.format(price);

        return formated;
      },
      splitBs(number){
        return number.replace('Bs', '');
      },
      date: function (date) {
        return moment(date).format('MMMM Do YYYY, h:mm:ss a');
      },
      getInvoice(){
        console.log('ver factura :: idorder ', POS_ORDER_ID);
        $('#indicatorInvoiceOrder').show();
        $('#botonInvoiceOrder').hide();
        $('#botonInvoiceOrderIntentar').hide();
        axios.get(`/posfel/v1/invoice/${POS_ORDER_ID}`).then(function (response) {     
            
            
            console.log('ver factura :: response.data ', response.data);
            //  $('#modalPayment').modal('hide');
            //Call to get the total price and items     
            console.log('ver factura :: response.data.status ', response.data.status);
            if(response.data.status){       
              
              butonInvoice.invoice=response.data.invoice;
              makeQrCode();
              butonInvoice.titleButon = 'Ver Factura';
              // $('#modalPOSInvoiceView').modal('show');
              if(butonInvoice.invoice.cuf){       
                js.notify('Factura obtenida.', "success");
                butonInvoice.titleButon = 'Ver Factura';
              }else{      
                js.notify('No existe factura.', "success");
                butonInvoice.titleButon = 'Facturar';
              }
            }else{      
              js.notify('No existe la factura', "warning");
              butonInvoice.titleButon = 'Facturar';
            }
            setTimeout(() => {
              console.log('created 0.5seg');
              $('#indicatorInvoiceOrder').hide();
              $('#botonInvoiceOrder').show();
             }, 500);
            
            
        }).catch(function (error) {     
          setTimeout(() => {
            console.log('created 0.5seg');
            $('#botonInvoiceOrderIntentar').show();
            $('#indicatorInvoiceOrder').hide();
           }, 500);
            
            js.notify(error, "warning");
        });
      },
      facturarOrder(){
        // if(butonInvoice.motivoAnulacion != '0'){
        //   anularFactura(anularInvoiceView.idinvoice, anularInvoiceView.motivoAnulacion);
        // } else {
          js.notify('Facturar order', "success");
          facturarPos(POS_ORDER_ID);
        // }
      },
      abrirModal(){
        console.log('abrirModal :: ver ');
        if(this.invoice.cuf){
          abrirModalVerFactura();
        } else {
          this.facturarOrder();
        }
        // js.notify('Abrir modal', "success");
        // $('#modalPOSInvoiceView').modal('show');
        
      },
      formatDecimal(number){
        return number.replace(',', '.');
      }
    },
    created: function(){
        setTimeout(() => {
            console.log('created 0.5seg');
            this.getInvoice();
           }, 500);
      
    }
  });
}

function facturarPos(idOrder){
  

  console.log('facturar :: idorder ', idOrder);
  $('#indicatorInvoiceOrder').show();
    $('#botonInvoiceOrder').hide();

  axios.post(`/posfel/v1/emit/${idOrder}`, {}).then(function (response) {
     
    $('#indicatorInvoiceOrder').hide();
    $('#botonInvoiceOrder').show();
 
     if(response.data.status){
       
       js.notify(response.data.message, "success");
       butonInvoice.invoice=response.data.invoice;
       makeQrCode();
       butonInvoice.titleButon = 'Ver Factura';
       
       $('#modalPOSInvoiceView').modal('show');
       setTimeout(() => {
        $("#posReciptInvoiceView").printThis();
       }, 500);
        
     }else{
      
       js.notify(response.data.message, "warning");
     }
     
     
   }).catch(function (error) {
     
    $('#indicatorInvoiceOrder').hide();
    $('#botonInvoiceOrder').show();
     js.notify(error, "warning");
   });
}

function abrirModalVerFactura(){  
  console.log('function ver invoice :: ');
  $('#modalPOSInvoiceView').modal('show');
}

function imprimirFactura(){
  console.log('function imprimir invoice :: ');
  $("#posReciptInvoiceView").printThis();
}

function createQrInstance(){
  if(qrcode == null){
    qrcode= new QRCode("qrcode", {
      width: 150,
      height: 150,
      colorDark : "#000000",
      colorLight : "#ffffff",
      correctLevel : QRCode.CorrectLevel.M
    });
  }
}

function makeQrCode(){
  console.log("Generate QR");
  console.log( butonInvoice.invoice.url_sin !=null ? butonInvoice.invoice.url_sin : '');
  createQrInstance();
  qrcode.clear();
  qrcode.makeCode(butonInvoice.invoice.url_sin !=null ? butonInvoice.invoice.url_sin : '');
}