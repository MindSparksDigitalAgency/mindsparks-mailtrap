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
        $this->emailService = new EmailService();
    }

    public function sendContactFormEmail($data)
    {
        // Validasi data
        if (!isset($data['name'], $data['email'], $data['phone'], $data['message'])) {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "error" => "Missing required fields."]);
            exit;
        }

        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $message = $data['message'];

        $to = 'halo@mindsparks.id';
        $subject = 'New Contact Form Submission';

        $body = "
    <html>
        <head><title>New Contact Form Submission</title></head>
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

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: $email" . "\r\n";

        $result = $this->emailService->sendEmail($to, $subject, $body, $email, $name, $headers);

        header('Content-Type: application/json');
        if ($result === true) {
            echo json_encode(["success" => true, "message" => "Your message was sent successfully."]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to send email. Error: $result"]);
        }
        exit;
    }
}
