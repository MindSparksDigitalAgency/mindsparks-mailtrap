<?php

namespace App\config;

use App\controllers\ContactController;

class Router
{
    public static function handleRequest()
    {
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactController = new ContactController();

            $result = $contactController->sendContactFormEmail($data);

            echo json_encode($result);
        } else {
            http_response_code(405);
            echo json_encode(["success" => false, "error" => "Method not allowed."]);
        }
    }
}
