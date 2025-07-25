<?php
require "../vendor/autoload.php";
require_once "dep/dependencias.php";
require_once "dep/set-variables.php";

$button = new \Elxdigital\CtaButton\Button();

/**
 * MOCK DE DADOS PARA TESTES
 * PARA ALTERNAR ENTRE TESTES COM OU SEM BOTÃO JÁ CADASTRADO, COMENTE OU DESCOMENTE A VARIÁVEL $data ABAIXO
 */

$data = null;
//$data = (object) ['btn_cta' => 1];
$forms = ["contato" => "Formulário de Contato", "curriculo" => "Formulário de Currículo", "modal" => "Formulário de Modal"];
?>

<html>
    <body>
        <h1>Ola</h1>

        <form action="<?= getFullUrl('index.php?route=forms/pai/save') ?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="formulario_pai" id="formulario_pai">

            <?php $button->renderPrivate('btn_cta', 'btn_home_banner', $forms, $data?->btn_cta); ?>

            <button type="submit">Enviar</button>
        </form>
    </body>
</html>
