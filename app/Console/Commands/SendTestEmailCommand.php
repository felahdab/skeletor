<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Mail\EssaiMail;

class SendTestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:send-test-email-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un mail de test pour vérifier les paramètres SMTP.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email =  $this->ask('A quel email voulez vous envoyer un email de test ?');
        Mail::alwaysTo(null); // Pour annuler la configuration imposée dans le AppServiceProvider le cas échéant.
        Mail::to($email)->send(new EssaiMail());
    }
}
