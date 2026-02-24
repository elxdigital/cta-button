<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \ElxDigital\CtaButton\Button $button
 * @var object|null $data
 * @var array $forms
 */

$this->layout("_template_view", [
    "title" => "Admin Use - CTA Button",
]);
?>

<h1>Ola</h1>

<form action="<?= getFullUrl('src/routes/index.php?route=forms/pai/save') ?>" method="POST" enctype="multipart/form-data">
    <input type="text" name="formulario_pai" id="formulario_pai">

    <?php $button->renderPrivate('btn_cta', 'btn_home_banner', $forms, $data?->btn_cta); ?>

    <button type="submit">Enviar</button>
</form>
