<?php

require __DIR__ . "/../vendor/autoload.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method != "GET") {
    http_response_code(400);
    exit;
}

$controller = new \Elxdigital\CtaButton\Examples\Controller\PublicController();
$controller->public();
