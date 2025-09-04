<?php

!defined("__DIR_ROOT_DEP__") ? define('__DIR_ROOT_DEP__', dirname(__DIR__, 2)) : __DIR_ROOT_DEP__;

$envFile = dirname(__DIR__, 2) . '/.env';
if (file_exists($envFile) && class_exists(\Dotenv\Dotenv::class)) {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR_ROOT_DEP__);
    $dotenv->load();
}

// url
!defined("CONF_URL_BASE") ? define('CONF_URL_BASE', $_ENV['CONF_URL_BASE']) : CONF_URL_BASE;
!defined("CONF_URL_TEST") ? define('CONF_URL_TEST', $_ENV['CONF_URL_TEST']) : CONF_URL_TEST;

// banco de dados
!defined("CONF_DB_HOST") ? define("CONF_DB_HOST", $_ENV['CONF_DB_HOST']) : CONF_DB_HOST;
!defined("CONF_DB_NAME") ? define("CONF_DB_NAME", $_ENV['CONF_DB_NAME']) : CONF_DB_NAME;
!defined("CONF_DB_USER") ? define("CONF_DB_USER", $_ENV['CONF_DB_USER']) : CONF_DB_USER;
!defined("CONF_DB_PASS") ? define("CONF_DB_PASS", $_ENV['CONF_DB_PASS']) : CONF_DB_PASS;
!defined("CONF_DB_PORT") ? define("CONF_DB_PORT", $_ENV['CONF_DB_PORT']) : CONF_DB_PORT;

// mail
!defined("CONF_MAIL_HOST") ? define("CONF_MAIL_HOST", $_ENV['CONF_MAIL_HOST']) : CONF_MAIL_HOST;
!defined("CONF_MAIL_PORT") ? define("CONF_MAIL_PORT", $_ENV['CONF_MAIL_PORT']) : CONF_MAIL_PORT;
!defined("CONF_MAIL_USER") ? define("CONF_MAIL_USER", $_ENV['CONF_MAIL_USER']) : CONF_MAIL_USER;
!defined("CONF_MAIL_PASS") ? define("CONF_MAIL_PASS", $_ENV['CONF_MAIL_PASS']) : CONF_MAIL_PASS;
!defined("CONF_MAIL_SENDER") ? define("CONF_MAIL_SENDER", ['name' => $_ENV['CONF_MAIL_SENDER_NAME'], 'address' => $_ENV['CONF_MAIL_SENDER_ADDRESS']]) : CONF_MAIL_SENDER;

if (empty($_SERVER["HTTP_HOST"]) || $_SERVER["HTTP_HOST"] == "localhost") {
    !defined("CONF_MAIL_TEST") ? define("CONF_MAIL_TEST", ['name' => $_ENV['CONF_MAIL_TEST_NAME'], 'address' => $_ENV['CONF_MAIL_TEST_ADDRESS']]) : CONF_MAIL_TEST;
}
