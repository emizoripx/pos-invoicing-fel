<?php

namespace EmizorIpx\PosInvoicingFel\Services\Whatsapp;

use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use EmizorIpx\PosInvoicingFel\Repository\FelInvoiceWhatsappMessageRepository;
use EmizorIpx\WhatsappMessages\Exceptions\WhatsappServiceException;
use EmizorIpx\WhatsappMessages\Facades\WhatsappMessage;
use Exception;

class WhatsappService {

    protected $fel_invoice;

    protected $body_params;

    protected $media_params;

    protected $buttons_params;

    protected $template_name;

    protected $invoice_message_repo;

    public function __construct(FelInvoice $fel_invoice)
    {
        $this->fel_invoice = $fel_invoice;

        $this->template_name = env('WHATSAPP_TEMPLATE_NAME');

        $this->invoice_message_repo = new FelInvoiceWhatsappMessageRepository();
    }

    public function prepareBodyParams(){

        $array_data = [
            is_null($this->fel_invoice->complento) ? $this->fel_invoice->numeroDocumento : $this->fel_invoice->numeroDocumento . ' '. $this->fel_invoice->complemento,
            $this->fel_invoice->razonSocialEmisor ,
            "Bs " . number_format($this->fel_invoice->montoTotal, 2)
        ];

        $this->body_params = $array_data;
    }

    public function prepareMediaParams(){

        $array_data = [
            "type" => "document",
            "url" => $this->fel_invoice->url_pdf,
            "filename" => "Factura". $this->fel_invoice->numeroFactura .".pdf" ,
        ];

        $this->media_params = $array_data;

    }

    public function prepareButtonParams(){
        $path = $this->fel_invoice->nombreRazonSocial != "CONTROL TRIBUTARIO" ? 'invoices?nit='.$this->fel_invoice->numeroDocumento : '?';
        $array_data = [
            "type" => "url",
            "parameter" => $path,
        ];

        $this->buttons_params = $array_data;
    }

    public function sendMessage( $phone_number ){

        try {

            $invoice_message = $this->invoice_message_repo->create([
                'invoice_id' => $this->fel_invoice->id,
                'restorant_id' => $this->fel_invoice->restorant_id,
                'user_id' => 1,
                'client_name' => $this->fel_invoice->nombreRazonSocial == "CONTROL TRIBUTARIO" ? "Sin Nombre" : $this->fel_invoice->nombreRazonSocial ,
            ]);

            $this->prepareBodyParams();

            $this->prepareMediaParams();

            $this->prepareButtonParams();

            $response = WhatsappMessage::sendWhithTemplate( '591' . $phone_number, $this->template_name, $this->body_params, $this->media_params, $this->buttons_params );

            $this->invoice_message_repo->update($invoice_message->id, [
                'message_key' => $response['message_key'],
                'message_description' => $response['message'],
                'is_send' => true,
            ]);

            return $response['message'];


        } catch( WhatsappServiceException $ex ){

            $err = json_decode($ex->getMessage());
            $msg = $err->errors->message ;
            $reason = property_exists($err->errors, 'reason') ? $err->errors->reason : '';

            $this->invoice_message_repo->update($invoice_message->id, [
                'message_key' => $err->message_key,
                'message_error' => $msg . ": " . $reason
            ]);

            throw new Exception($msg . ': '. $reason);

        }

    }

}