<?php

/**
 * @ORM\PrePersist
 * @author Puji Ermanto<pujiermanto@gmail.com>
 * @param string $
 */

namespace App\controllers;

use App\services\EmailService;

class ContactController
{
    private $emailService;

    public function __construct()
    {
        // Membuat instansi EmailService
        $this->emailService = new EmailService();
    }

    public function sendContactFormEmail($data)
    {
        if (!isset($data['name'], $data['email'], $data['service'], $data['message'])) {
            return ["success" => false, "error" => "Missing required fields."];
        }

        $name = $data['name'];
        $email = $data['email'];
        $service = $data['service'];
        $message = $data['message'];

        $to = 'halo@mindsparks.id';
        $subject = 'New Contact Form Submission';
        $body = "
            Hi Mindspark.id,\n\n
            Name: $name\n
            Email: $email\n
            Service: $service\n\n
            Message:\n$message
        ";

        // Menggunakan EmailService untuk mengirim email
        $result = $this->emailService->sendEmail($to, $subject, $body, $email, $name);

        if ($result === true) {
            return ["success" => true, "message" => "your message was sent to {$to},  successfully"];
        } else {
            return ["success" => false, "error" => "Failed to send email. Error: $result"];
        }
    }
}
