<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var object $btn_conversao
 * @var array $arrayClasses
 * @var bool $hasModal
 * @var string $form
 * @var bool $span
 */

$button = new \Elxdigital\CtaButton\Domain\Button($btn_conversao);
echo $button->getFunction($arrayClasses, $span);

if ($hasModal && !empty($form)) {
    $url = getFullUrl();

    echo <<<HTML
        <script rel="text/javascript" src="{$url}/src/template/assets/script_public.js" defer></script>
        <link rel="stylesheet" href="{$url}/src/template/assets/style_public.css">

        <div id="form-{$button->getBtnIdentificador()}" class="modal-button-cta wrap-modal">
            <div class="overlay-modal"></div>
            <div class="box-modal">
                <button class="close-modal"><span class="material-symbols-outlined">X</span></button>
                <div class="box-title">
                    <h2>{$button->getBtnTitulo()}</h2>
                </div>
        
                <div class="row">
                    <div class="col-xl-12">
                        {$form}
                    </div>
                </div>
            </div>
        </div>
    HTML;
}
