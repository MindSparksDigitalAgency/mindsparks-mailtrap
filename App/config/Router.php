<?php

namespace App\config;

use App\controllers\ContactController;

class Router
{
    public static function handleRequest()
    {

        $data = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/json");
            header("Accept: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            $contactController = new ContactController();

            $result = $contactController->sendContactFormEmail($data);

            echo json_encode($result);
        } else {
            http_response_code(405);
            echo json_encode(["success" => false, "error" => "Method not allowed."]);
        }
    }
}
