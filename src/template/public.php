<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var object $btn_conversao
 * @var bool $hasModal
 * @var string $form
 */

$button = new \Elxdigital\CtaButton\Domain\Button($btn_conversao);
echo $button->getFunction();

if ($hasModal && !empty($form)) {
    echo <<<HTML
        <script rel="text/javascript" src="../src/template/assets/script_public.js" defer></script>
        <link rel="stylesheet" href="../src/template/assets/style_public.css">
        
        <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:9998;"></div>
        <div id="form-{$button->getBtnIdentificador()}" class="modal-button-cta" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; padding:2rem; border-radius:10px; box-shadow:0 2px 20px #333; z-index:9999; min-width:320px;">
            <button class="fecharModal" style="position:absolute; top:10px; right:10px; font-size:1.5em; background:transparent; border:none; cursor:pointer;">&times;</button>
            {$form}
        </div>
    HTML;
}
