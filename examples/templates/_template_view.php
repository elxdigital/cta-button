<?php
require __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../dep/dependencias.php";
require_once __DIR__ . "/../../src/dep/set-variables.php";

/**
 * @var \League\Plates\Template\Template $this
 * @var string $title
 */
?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <title><?= $title ?></title>
    </head>

    <body>
        <div class="wrap-all-page">
            <?= $this->section("content") ?>

            <?= $this->section("modals") ?>
        </div>
    </body>
</html>
