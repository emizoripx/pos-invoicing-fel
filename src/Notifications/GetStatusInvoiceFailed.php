<?php

namespace EmizorIpx\PosInvoicingFel\Notifications;

use EmizorIpx\PosInvoicingFel\Models\FelInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GetStatusInvoiceFailed extends Notification
{
    use Queueable;

    protected $invoice;

    protected $error_message;

    protected $file;

    protected $line;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( FelInvoice $invoice, $file = "", $line = "", $error_message = "" )
    {
        $this->invoice = $invoice;

        $this->error_message = $error_message;

        $this->file = $file;

        $this->line = $line;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Notificación: Error en el POS')
                    ->greeting('Hola, Ocurrio un error en el POS')
                    ->line('Ocurrió un error al actualizar el estado de la factura # ' . $this->invoice->numeroFactura . ", perteneciente al Restaurant ". $this->invoice->restorant->name)
                    ->line('Detalle')
                    ->line('________________')
                    ->line('Factura #' . $this->invoice->numeroFactura)
                    ->line('Fecha Emision: ' . $this->invoice->fechaEmision)
                    ->line('Tipo Emision: ' . $this->invoice->tipoEmision)
                    ->line('Orden ID: ' . $this->invoice->order_id)
                    ->line('CUF: ' . $this->invoice->cuf)
                    ->line('________________')
                    ->line('Mensaje de Error')
                    ->line('File: ' . $this->file)
                    ->line('Line: ' . $this->line)
                    ->line('Message: ' . $this->error_message)
                    ->line('________________');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
