<?php

namespace EmizorIpx\PosInvoicingFel\Console\Commands;

use EmizorIpx\PosInvoicingFel\Exceptions\PosInvoicingException;
use EmizorIpx\PosInvoicingFel\Notifications\TestMailSend;
use EmizorIpx\PosInvoicingFel\Repository\ParametricRepository;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emizor:test-mail {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test send mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle( )
    {
        try{

            $email = $this->argument('email');

            Notification::route('mail', $email)->notify( new TestMailSend() );
            
            $this->info('El mail de prueba se envió con Éxito');

        } catch(PosInvoicingException | Exception $ex){
            \Log::debug("Error al enviar el correo de prueba " . $ex->getMessage() . " Linea : " . $ex->getLine());
            $this->error($ex->getMessage());
        }
    }
}
