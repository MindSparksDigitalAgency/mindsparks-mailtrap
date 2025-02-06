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

        if ($result === true) {
            $this->sendReplyEmail($data);
        }

        header('Content-Type: application/json');
        if ($result === true) {
            echo json_encode(["success" => true, "message" => "Your message was sent successfully."]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to send email. Error: $result"]);
        }
        exit;
    }

    public function sendReplyEmail($data)
    {
        $name = $data['name'];
        $email = $data['email'];
        $message = $data['message'];

        $replySubject = "Thank You for Contacting Us!";
        $replyBody = "
    <html>
        <head><title>Thank You</title></head>
        <body>
            <h2>Hi $name,</h2>
            <p>Thank you for reaching out to us! We have received your message and will get back to you as soon as possible.</p>
            <p>Here is a copy of your message:</p>
            <blockquote>$message</blockquote>
            <p>Best Regards,<br>MindSparks Team</p>
            <br>
            <a href='https://mindsparks.id' target='_blank'>mindsparks.id</a>
        </body>
    </html>
    ";

        $fromEmail = 'halo@mindsparks.id';
        $fromName = 'MindSparks';
        // Email admin sebagai pengirim
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: $fromName <$fromEmail>" . "\r\n";
        $headers .= "Reply-To: $fromEmail" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        // Kirim email balasan ke user
        return $this->emailService->sendEmail($email, $replySubject, $replyBody, $fromEmail, $fromName, $headers);
    }
}
