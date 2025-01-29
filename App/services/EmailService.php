<?php

namespace App\services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class EmailService
{
    private $mailer, $logger;

    public function __construct()
    {
        $this->logger = new Logger('email_logger');
        $this->logger->pushHandler(new StreamHandler('app.log', Logger::DEBUG));

        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = 'mail.mindsparks.id';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'landing.page@mindsparks.id';
        $this->mailer->Password = 'mindSparks@321';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port = 465;
        $this->mailer->Timeout = 60;
        $this->mailer->SMTPDebug = 0;
    }

    public function sendEmail($to, $subject, $body, $from, $fromName, $headers = null)
    {
        try {
            $this->mailer->setFrom($from, $fromName);
            $this->mailer->addAddress($to);

            // Log setiap tahap proses email
            $this->logger->info('Setting email parameters', ['from' => $from, 'to' => $to, 'subject' => $subject]);

            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->isHTML(true); // Menyatakan bahwa body email adalah HTML

            // Menambahkan custom headers jika ada
            if ($headers) {
                foreach ($headers as $header => $value) {
                    $this->mailer->addCustomHeader($header, $value);
                }
            }

            // Mengirim email
            $this->mailer->send();

            $this->logger->info('Email successfully sent', ['to' => $to]);
            return true;
        } catch (Exception $e) {
            $this->logger->error('Error sending email', ['error' => $e->getMessage()]);
            return $this->mailer->ErrorInfo;
        }
    }
}
