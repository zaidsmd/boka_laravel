<?php
namespace App\Services;

use App\Jobs\SendEmailJob;

class SmtpService
{
    /**
     * Envoie un email en utilisant la queue.
     *
     * @param mixed $destinations Un ou plusieurs destinataires
     * @param string $subject Sujet de l'email
     * @param string $body Corps de l'email en HTML
     * @return bool
     */
    public function send($destinations, $subject, $body)
    {
        // Vérifie que les destinations sont sous forme de tableau
        $destinations = is_array($destinations) ? $destinations : [$destinations];

//        Artisan::call('cache:clear');

        // Place le job en queue pour envoi de l'email
        try {
            SendEmailJob::dispatch($destinations, $subject, $body);
            return true;
        } catch (\Exception $e) {
            LogService::logException($e);
            return false;
        }
    }
}
