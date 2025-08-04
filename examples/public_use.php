<?php
require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/dep/dependencias.php";
require_once __DIR__ . "/../src/dep/set-variables.php";

/**
 * MOCK DE DADOS, PASSE O ID NECESSÁRIO QUE DESEJA CARREGAR NA TELA
 */
$btn_id = 14;

/**
 * IMPORTANTE PASSAR O CAMINHO DAS VIEWS DO SISTEMA QUE USARÁ ESTE BOTÃO
 */
$button = new \Elxdigital\CtaButton\Button(__DIR__);
?>

<html>
    <section>
        <?php $button->renderPublic($btn_id); ?>
    </section>
</html>
