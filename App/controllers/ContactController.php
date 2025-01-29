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
        if (!isset($data['name'], $data['email'], $data['phone'], $data['message'])) {
            return ["success" => false, "error" => "Missing required fields."];
        }

        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $message = $data['message'];

        $to = 'halo@mindsparks.id';
        $subject = 'New Contact Form Submission';

        // Mengubah body email menjadi format HTML
        $body = "
            <html>
                <head>
                    <title>New Contact Form Submission</title>
                </head>
                <body>
                    <h2>New Contact Form Submission</h2>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Phone Number:</strong> $phone</p>
                    <p><strong>Message:</strong></p>
                    <p>$message</p>
                </body>
            </html>
        ";

        // Menambahkan header Content-Type untuk email HTML
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: $email" . "\r\n";

        // Menggunakan EmailService untuk mengirim email
        $result = $this->emailService->sendEmail($to, $subject, $body, $email, $name, $headers);

        if ($result === true) {
            return ["success" => true, "message" => "Your message was sent to {$to} successfully."];
        } else {
            return ["success" => false, "error" => "Failed to send email. Error: $result"];
        }
    }
}
