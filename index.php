<?php
require "vendor/autoload.php";

$route = $_GET['route'] ?? $_POST['route'] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

if (!$route) {
    http_response_code(400);
    echo json_encode(['error' => 'Rota não especificada']);
    exit;
}

switch ($route) {
    case 'button/save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $button = new \Elxdigital\CtaButton\Controller\ButtonController();
            $button->saveButton($_POST);
        } else {
            echo "Método não permitido!";
        }

        break;
    case 'forms/pai/save':
        var_dump($_POST);exit;

        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada']);
        break;
}
